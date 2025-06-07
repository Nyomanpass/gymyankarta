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
    <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-white rounded-full p-3">
        <i class=" fas fa-check-circle text-warna-700 text-7xl"></i>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-1 mt-10">{{ $title }}</h3>
    <p class="text-gray-600 mb-8 md:mb-9">{{ $description }}</p>
    {{ $button }}

</div>