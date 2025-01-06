<input class="w-full border-b-4 h-12 border-black text-sm pl-1 mr-1 focus:outline-none md:text-lg {{ $class ?? '' }}"
    type="{{ $type ?? 'text' }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    value="{{ $value ?? '' }}" />
