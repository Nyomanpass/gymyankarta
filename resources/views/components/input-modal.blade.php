@props(['title' => '', 'subtitle' => '', 'actions' => null])

<div 
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 10)"
    x-show="show"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-50"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition transform ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-50"
    {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-lg']) }}
>
    @if($title || $subtitle)
        <div class="mb-6">
            @if($title)
                <h1 class="text-lg md:text-xl xl:text-2xl font-semibold mb-2 text-gray-900">
                    {{ $title }}
                </h1>
            @endif
            
            @if($subtitle)
                <p class="text-sm md:text-base text-gray-600">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <div class="flex-1">
        {{ $slot }}
    </div>

    <!-- Actions Section -->
    @isset($actions)
        <div class="mt-6 pt-4 border-t border-gray-200 w-full flex justify-end">
            {{ $actions }}
        </div>
    @endisset

    
</div>