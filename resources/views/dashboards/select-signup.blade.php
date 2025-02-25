<div class="flex flex-col items-center gap-2 font-work text-center">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>

        <h1 class="text-xl"><strong>Elige una peluquería para gestionar tus citas</strong></h1>
        <p>Selecciona la peluqueria donde quieres gestionar tus citas</p>
        
    <form name="fSelectSignUpForm" method="POST" data-form="{{ route('dashboard.showCalendar') }}"
        data-url="{{ route('dashboard.showHairdressers') }}">
        @csrf
        <select class="mb-4" name="hairdresser_id" id="peluquerias">
            <option value="">Selecciona peluqueria</option>
            @foreach ($hairdressers as $hairdresser)
                <option value="{{ $hairdresser->id }}">{{ $hairdresser->name }}</option>
            @endforeach
        </select>
        <x-buttons.submit-button id="enviar" name="signup" message="Seleccionar"
            class="w-48 p-4 text-sm md:text-xl xl:w-3/4">
        </x-buttons.submit-button>
    </form>

    @auth
    @if (Auth::user()->role == 'propietario')
    <h2>
        Recuerda crear seleccionar servicios para que tus usuarios puedan escoger los servicios de tu peluqueria.
    </h2>
    @endif
    @endauth
</div>
