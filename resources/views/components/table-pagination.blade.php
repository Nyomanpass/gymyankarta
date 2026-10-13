@props(['paginator', 'label' => 'data', 'instance' => 'main'])
@php
    $current = $paginator->currentPage();
    $last = max(1, $paginator->lastPage());
    $start = max(1, min($current - 2, $last - 4));
    $end = min($last, $start + 4);
    $pageName = $paginator->getPageName();
    $buttonClass = 'inline-flex min-h-10 min-w-10 items-center justify-center rounded-xl border border-gray-200 bg-white px-3 text-xs font-medium text-warna-300 hover:bg-orange-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors';
@endphp
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 border-t border-gray-100 pt-5 mt-5" wire:key="pagination-{{ $pageName }}-{{ $instance }}">
    <div class="text-xs text-warna-200 leading-relaxed" aria-live="polite">
        <p>Menampilkan <span class="font-semibold text-warna-300">{{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-warna-300">{{ $paginator->total() }}</span> {{ $label }}</p>
        <p class="mt-1">Halaman {{ $current }} dari {{ $last }}</p>
    </div>
    @if($paginator->hasPages())
        <nav aria-label="Navigasi halaman {{ $label }}" class="flex flex-wrap items-center gap-1.5">
            <button type="button" wire:click="previousPage('{{ $pageName }}')" wire:loading.attr="disabled" wire:target="previousPage,nextPage,gotoPage" @disabled($paginator->onFirstPage()) class="{{ $buttonClass }}" aria-label="Halaman sebelumnya">‹<span class="hidden sm:inline ml-1.5">Sebelumnya</span></button>
            @for($number = $start; $number <= $end; $number++)
                @if($number === $current)
                    <span aria-current="page" aria-label="Halaman {{ $number }}" class="inline-flex min-h-10 min-w-10 items-center justify-center rounded-xl border border-warna-400 bg-warna-400 px-3 text-xs font-semibold text-white">{{ $number }}</span>
                @else
                    <button type="button" wire:click="gotoPage({{ $number }}, '{{ $pageName }}')" wire:loading.attr="disabled" wire:target="previousPage,nextPage,gotoPage" class="{{ $buttonClass }}" aria-label="Ke halaman {{ $number }}">{{ $number }}</button>
                @endif
            @endfor
            <button type="button" wire:click="nextPage('{{ $pageName }}')" wire:loading.attr="disabled" wire:target="previousPage,nextPage,gotoPage" @disabled(!$paginator->hasMorePages()) class="{{ $buttonClass }}" aria-label="Halaman berikutnya"><span class="hidden sm:inline mr-1.5">Berikutnya</span>›</button>
        </nav>
    @endif
</div>
