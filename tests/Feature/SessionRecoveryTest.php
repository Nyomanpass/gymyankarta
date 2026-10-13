<?php

use App\Livewire\Login;
use App\Models\User;
use Livewire\Livewire;

function recoveryUser(string $role = 'member'): User
{
    return User::factory()->create([
        'username' => fake()->unique()->userName(), 'role' => $role, 'status' => 'active',
        'membership_started_date' => now()->subDay(), 'membership_expiration_date' => now()->addMonth(),
    ]);
}

it('returns an already signed-in member to their own dashboard when reopening login', function () {
    $member = recoveryUser();
    $this->actingAs($member)->get(route('login'))->assertRedirect(route('dashboard.member'));
    $this->get(route('dashboard.member'))->assertOk();
    // Reopening login repeatedly must never send a member to the admin dashboard.
    $this->get(route('login'))->assertRedirect(route('dashboard.member'));
});

it('returns a signed-in admin to the admin dashboard', function () {
    $this->actingAs(recoveryUser('admin'))->get(route('login'))->assertRedirect(route('dashboard'));
});

it('regenerates the session on login and clears it on logout before logging in again', function () {
    $member = recoveryUser();
    $this->get(route('login'))->assertOk();
    $oldSession = session()->getId();
    Livewire::test(Login::class)->set('username', $member->username)->set('password', 'password')
        ->call('login')->assertRedirect(route('dashboard.member'));
    $this->assertAuthenticatedAs($member);
    expect(session()->getId())->not->toBe($oldSession);
    session()->put('old_form_state', 'stale');
    $oldToken = session()->token();
    $this->get(route('logout'))->assertRedirect(route('login'));
    $this->assertGuest();
    expect(session()->has('old_form_state'))->toBeFalse()->and(session()->token())->not->toBe($oldToken);
    Livewire::test(Login::class)->set('username', $member->username)->set('password', 'password')
        ->call('login')->assertRedirect(route('dashboard.member'));
    $this->assertAuthenticatedAs($member);
});

it('does not allow invalid passwords or inactive accounts', function () {
    $member = recoveryUser();
    Livewire::test(Login::class)->set('username', $member->username)->set('password', 'incorrect')->call('login');
    $this->assertGuest();
    $member->update(['status' => 'inactive']);
    Livewire::test(Login::class)->set('username', $member->username)->set('password', 'password')->call('login');
    $this->assertGuest();
});

it('serves fresh login HTML with one Alpine instance and version metadata', function () {
    $response = $this->get(route('login'))->assertOk()->assertSee('name="app-release"', false)
        ->assertDontSee('unpkg.com/alpinejs', false);
    expect($response->headers->get('Cache-Control'))->toContain('no-store');
});

it('exposes an uncached release check without renewing login sessions', function () {
    $this->get(route('app.release'))->assertOk()->assertJsonStructure(['version'])->assertCookieMissing(config('session.cookie'));
    $response = $this->actingAs(recoveryUser())->get(route('app.release'))->assertOk();
    expect($response->headers->get('Cache-Control'))->toContain('no-store');
    $response->assertCookieMissing(config('session.cookie'));
});
