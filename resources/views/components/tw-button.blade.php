<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 font-medium bg-red-600 rounded-lg text-white h-10 md:hover:bg-[#ac143c] transition-all duration-300']) }}>
    {{ $slot }}
</button>
