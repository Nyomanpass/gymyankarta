@props(['model', 'label', 'options' => [], 'descriptions' => []])
@php($selectId = 'cashier-'.str_replace('.', '-', $model))
<div class="relative" wire:key="{{ $selectId }}-{{ md5(json_encode($options)) }}"
    x-data="{
        open: false,
        value: $wire.entangle(@js($model)).live,
        choices: @js($options),
        active: 0,
        get keys() { return Object.keys(this.choices); },
        show() {
            this.active = Math.max(0, this.keys.indexOf(String(this.value ?? '')));
            this.open = true;
            this.reveal();
        },
        move(step) {
            if (!this.open) { this.show(); return; }
            this.active = (this.active + step + this.keys.length) % this.keys.length;
            this.reveal();
        },
        reveal() { this.$nextTick(() => this.$refs.list.children[this.active]?.scrollIntoView({ block: 'nearest' })); },
        choose(key) { this.value = key; this.open = false; this.$refs.trigger.focus(); }
    }"
    @click.outside="open = false"
    @keydown.escape.stop.prevent="open = false"
    @keydown.tab="open = false">
    <label id="{{ $selectId }}-label" for="{{ $selectId }}" class="block text-sm font-medium text-warna-300 mb-2">{{ $label }}</label>
    <button type="button" id="{{ $selectId }}" x-ref="trigger" role="combobox"
        aria-haspopup="listbox" aria-controls="{{ $selectId }}-list" aria-labelledby="{{ $selectId }}-label"
        :aria-expanded="open" :aria-activedescendant="open ? '{{ $selectId }}-option-' + active : null"
        @click="open ? open = false : show()"
        @keydown.arrow-down.prevent="move(1)" @keydown.arrow-up.prevent="move(-1)"
        @keydown.home.prevent="show(); active = 0; reveal()"
        @keydown.end.prevent="show(); active = keys.length - 1; reveal()"
        @keydown.enter.prevent="open ? choose(keys[active]) : show()"
        @keydown.space.prevent="open ? choose(keys[active]) : show()"
        class="w-full flex items-center justify-between gap-3 border bg-white px-4 py-3.5 rounded-xl text-left text-sm transition-colors"
        :class="open ? 'border-warna-400 ring-2 ring-orange-100' : 'border-gray-200 hover:border-gray-400'">
        <span x-text="choices[value] || 'Pilih {{ $label }}'" :class="choices[value] ? 'text-warna-300 font-medium' : 'text-gray-400'"></span>
        <svg class="w-4 h-4 shrink-0 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" aria-hidden="true" viewBox="0 0 20 20" fill="none"><path d="m5 7 5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
    <div x-show="open" x-cloak x-transition.opacity id="{{ $selectId }}-list" x-ref="list" role="listbox" aria-labelledby="{{ $selectId }}-label"
        class="absolute left-0 right-0 top-full mt-2 z-30 max-h-64 overflow-y-auto rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl">
        @foreach($options as $key => $text)
            <div id="{{ $selectId }}-option-{{ $loop->index }}" role="option" :aria-selected="value === @js((string) $key)"
                @click="choose(@js((string) $key))" @mouseenter="active = {{ $loop->index }}"
                class="flex items-center justify-between gap-3 rounded-lg px-3 py-3 cursor-pointer text-sm"
                :class="value === @js((string) $key) ? 'bg-orange-50 text-orange-800' : (active === {{ $loop->index }} ? 'bg-gray-50 text-warna-300' : 'text-warna-300')">
                <div><p class="font-medium">{{ $text }}</p>@if(isset($descriptions[$key]))<p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $descriptions[$key] }}</p>@endif</div>
                <span x-show="value === @js((string) $key)" class="text-orange-700" aria-hidden="true">✓</span>
            </div>
        @endforeach
    </div>
    @error($model)<p class="mt-2 text-xs text-red-600" role="alert">{{ $message }}</p>@enderror
</div>
