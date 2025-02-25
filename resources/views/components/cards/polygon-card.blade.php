<div>
    <div class="bg-white h-[22rem] xl:h-[32rem] w-3/5 xl:w-4/5 lg:h-96  
    flex flex-col items-center justify-center p-6 mx-auto"
        style="clip-path: polygon(50% 20%, 100% 0, 100% 80%, 50% 100%, 0 80%, 0 0);">
        <img class="mb-2 xl:transform xl:translate-y-3 xl:h-12 xl:mb-4" src="{{ asset($src) }}" alt="{{ $alt }}">
        <h2 class=" text-xl lg:text-2xl xl:text-4xl text-black text-center font-bold mb-4">{{ $title }}</h2>
        <p class="text-center text-sm xl:text-2xl">{{ $message1 }}</p>
    </div>

    <div class="-mt-12 bg-white h-[22rem] xl:h-[32rem] w-3/5 xl:w-4/5 lg:h-96
    flex flex-col items-center justify-center p-3 mx-auto"
        style="clip-path: polygon(50% 20%, 100% 0, 100% 80%, 50% 100%, 0 80%, 0 0);">
        <p class="text-center text-sm/relaxed xl:text-xl/relaxed font-work pt-6">
            {{ $message2 }}
        </p>
    </div>
</div>

