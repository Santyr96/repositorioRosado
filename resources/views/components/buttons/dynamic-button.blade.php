<a class="flex items-center justify-center gap-2 px-2 z-30 py-3 bg-purple-600 rounded-md text-white relative font-semibold after:-z-20 after:absolute 
                    after:h-1 after:w-1 after:bg-purple-800 after:left-5 overflow-hidden after:bottom-0 after:translate-y-full after:rounded-md after:hover:scale-[300] 
                    after:hover:transition-all after:hover:duration-700 after:transition-all after:duration-700 transition-all duration-700 text-shadow-purple 
                    hover:[text-shadow:2px_2px_2px_#fda4af] text-center {{$class}}"
    href={{ $href }} download={{$download}} role="button">
    {{ $slot }}
    {{$message}}
</a>
