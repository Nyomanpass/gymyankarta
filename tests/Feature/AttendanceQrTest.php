<?php

use App\Livewire\DashboardMember;
use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceQr;
use Livewire\Livewire;

function qrUser(string $role = 'admin'): User
{
    return User::factory()->create([
        'username' => fake()->unique()->userName(),
        'role' => $role, 'status' => 'active',
        'membership_started_date' => now()->subDays(2),
        'membership_expiration_date' => now()->addMonth(),
    ]);
}

it('keeps QR stable across requests and time and downloads the same SVG', function () {
    $this->actingAs(qrUser());
    $this->get(route('qr.attendance'))->assertOk()
        ->assertSee('dashboard-main')->assertSee('Kelola kode QR')
        ->assertDontSee('target="_blank"', false);
    $original = $this->get(route('qr.generate'))->assertOk()->getContent();
    $this->travel(60)->days();
    expect($this->get(route('qr.generate'))->assertOk()->getContent())->toBe($original);
    $this->get(route('qr.generate', ['download' => 1]))->assertOk()
        ->assertHeader('Content-Disposition', 'attachment; filename="qr-absensi-gymyankarta.svg"')
        ->assertContent($original);
});

it('only allows admins to replace the QR and rejects old or fabricated codes', function () {
    $qr = app(AttendanceQr::class);
    $old = $qr->payload();
    $this->actingAs(qrUser('member'));
    $this->post(route('qr.rotate'))->assertForbidden();
    $this->get(route('qr.generate'))->assertForbidden();
    expect($qr->valid($old))->toBeTrue();
    $this->actingAs(qrUser());
    $this->post(route('qr.rotate'))->assertRedirect(route('qr.attendance'));
    expect($qr->valid($old))->toBeFalse()
        ->and($qr->valid($qr->payload()))->toBeTrue()
        ->and($qr->valid(base64_encode('{"type":"attendance"}')))->toBeFalse();
});

it('records member attendance once and updates the dashboard without reload', function () {
    $this->actingAs(qrUser('member'));
    $payload = app(AttendanceQr::class)->payload();
    Livewire::test(DashboardMember::class)->call('processQrScan', $payload)
        ->assertSet('isAttendedToday', true)->assertSet('showQrScanner', false)
        ->call('processQrScan', $payload);
    expect(Attendance::count())->toBe(1);
});

it('does not record attendance for replaced codes or inactive memberships', function () {
    $user = qrUser('member');
    $this->actingAs($user);
    $qr = app(AttendanceQr::class);
    $old = $qr->payload();
    $qr->rotate();
    Livewire::test(DashboardMember::class)->call('processQrScan', $old);
    $user->update(['membership_expiration_date' => now()->subDay()]);
    Livewire::test(DashboardMember::class)->call('processQrScan', $qr->payload());
    expect(Attendance::count())->toBe(0);
});
