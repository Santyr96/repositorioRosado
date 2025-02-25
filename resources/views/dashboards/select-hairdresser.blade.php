<div class="flex flex-col items-center gap-2 font-work text-center">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>

        <h1 class="text-xl"><strong>Selecciona una peluquería</strong></h1>
        
    <form name="fSelectHairdresser" method="POST" data-select_services="{{ route('dashboard.services') }}" data-delete_hairdresser="{{route('dashboard.deleteHairdresser')}}"
    data-reload="{{route('dashboard.selectHairdresser')}}">
        @csrf
        <select class="mb-4" name="hairdresser_id" id="peluquerias">
            <option value="">Selecciona peluqueria</option>
            @foreach ($hairdressers as $hairdresser)
                <option value="{{ $hairdresser->id }}">{{ $hairdresser->name }}</option>
            @endforeach
        </select>
        <x-buttons.submit-button id="submit" name="submit" message="Seleccionar"
            class="w-48 p-4 text-sm md:text-xl xl:w-3/4">
        </x-buttons.submit-button>
    </form>
</div>
