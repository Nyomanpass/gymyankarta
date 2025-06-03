


<div class="relative">
    <input 
        type="{{ $type ?? 'text' }}" 
        id="{{ $id ?? 'input-' . uniqid() }}"
        class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer bg-warna-50 {{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? $label ?? 'Input' }}"
        value="{{ $value ?? '' }}"
        {{ $attributes }}
    />
    <label 
        for="{{ $id ?? 'input-' . uniqid() }}"
        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-warna-50 px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
    >
        {{ $label ?? 'Label' }}
    </label>
</div>
