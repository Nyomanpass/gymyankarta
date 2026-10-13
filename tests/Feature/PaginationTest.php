<?php

use App\Livewire\LaporanMember;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

it('shows a sliding window of at most five page numbers', function ($current, $expected) {
    $paginator = new LengthAwarePaginator(range(1, 10), 200, 10, $current, ['pageName' => 'reportPage']);
    $html = Blade::render('<x-table-pagination :paginator="$paginator" />', compact('paginator'));
    preg_match_all('/aria-label="(?:Ke halaman|Halaman) (\d+)"/', $html, $matches);
    expect(array_map('intval', $matches[1]))->toBe($expected);
    expect($html)->toContain("nextPage('reportPage')")->toContain('aria-current="page"');
})->with([
    [1, [1, 2, 3, 4, 5]],
    [10, [8, 9, 10, 11, 12]],
    [20, [16, 17, 18, 19, 20]],
]);

it('handles an empty list without fake page buttons', function () {
    $paginator = new LengthAwarePaginator([], 0, 10);
    $html = Blade::render('<x-table-pagination :paginator="$paginator" />', compact('paginator'));
    expect($html)->toContain('0–0')->not->toContain('gotoPage(');
});

it('paginates member reports independently and resets only the changed list', function () {
    User::factory()->count(12)->sequence(fn ($sequence) => [
        'username' => 'pagination-member-'.$sequence->index,
        'role' => 'member', 'status' => 'active',
        'membership_started_date' => now()->startOfMonth(),
        'membership_expiration_date' => now()->addDays(3),
    ])->create();

    Livewire::test(LaporanMember::class)
        ->call('gotoPage', 2, 'newMembersPage')
        ->assertSet('paginators.newMembersPage', 2)
        ->assertSet('paginators.expiringPage', 1)
        ->assertViewHas('newMembersThisMonth', fn ($page) => $page->currentPage() === 2 && $page->count() === 5)
        ->call('gotoPage', 3, 'expiringPage')
        ->assertSet('paginators.newMembersPage', 2)
        ->assertViewHas('membersExpiringSoon', fn ($page) => $page->currentPage() === 3 && $page->count() === 2)
        ->set('perPagememberbaru', 10)
        ->assertSet('paginators.newMembersPage', 1)
        ->assertSet('paginators.expiringPage', 3)
        ->set('perPagbatas', 10)
        ->assertSet('paginators.expiringPage', 1);
});
