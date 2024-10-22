<select class= "w-full border-b-4 h-12 border-black text-sm pl-1 mr-1 focus:outline-none{{$class}}" name={{$name}} {{$disabled}}>
    
    @foreach ($options as $value => $label )
        <option value={{$value}}> {{$label}}</option>
    @endforeach
</select>