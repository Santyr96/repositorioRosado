<div class="flex flex-col items-center gap-2 font-work text-center">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>

    <h1 class="text-xl"><strong>Date de alta en tu peluquería preferida</strong></h1>
    <p>Selecciona tu peluqueria del siguiente listado</p>

    <form name="fFormSignUp" method="POST" data-form="{{ route('dashboard.signupHairdresser') }}"
        data-url="{{ route('dashboard.showHairdressers') }}">
        @csrf
        <select class="mb-4" name="hairdresser_id" id="peluquerias">
            <option value="">Selecciona peluqueria</option>
            @foreach ($hairdressers as $hairdresser)
                <option value="{{ $hairdresser->id }}">{{ $hairdresser->name }}</option>
            @endforeach
        </select>
        <x-buttons.submit-button id="enviar" name="signup" message="Alta"
            class="w-48 p-4 text-sm md:text-xl xl:w-3/4">
        </x-buttons.submit-button>
    </form>
    <h2><strong>Peluquerias a las que te has dado de alta</strong></h2>
    <div class="w-80 border-2 border-black p-4">
        @if ($hairdressersSignedUp->isNotEmpty())
            <ul>
                @foreach ($hairdressersSignedUp as $hairdresser)
                    <li>{{ $hairdresser->name }}</li>
                @endforeach

            </ul>
        @else
            <p>No te has dado de alta en ninguna peluqueria</p>
        @endif
    </div>
</div>
