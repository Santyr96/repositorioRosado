<div id="serviceTable" data-url="{{ route('dashboard.services') }}" class="w-[95%] h-96 xl:h-[40rem] relative flex flex-col gap-2 overflow-auto">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>

    <x-modals.advice-modal class="hidden xl:left-40" modalTitle="Eliminar servicio"
        modalMessage="¿Estas seguro de eliminar este servicio?" id="deleteWarning"
        :child="view('elements-for-modals.confirmation-delete')"></x-modals.advice-modal>


    @if ($services->isEmpty())
        <p>No hay servicios registrados.</p>
        <button id="create" data-form="{{ route('dashboard.createService') }}" class="text-white rounded bg-green-500
            hover:bg-green-300 p-1 mt-1 w-28" type="button">Crear</button>
        <input id="idHairdresser" type="hidden" name="idHairdresser" value="{{ $hairdresser->id }}">
    @else
        <button id="create" data-form="{{ route('dashboard.createService') }}"
            class="text-white rounded bg-green-500 hover:bg-green-300 p-1 mt-1 w-28 self-end" type="submit">Crear</button>
        <input id="idHairdresser" type="hidden" name="idHairdresser" value="{{ $hairdresser->id }}">

        <table id="tableServices"
            class="w-full text-center leading-normal table-auto border-collapse border border-slate-400 font-work"
            data-url="{{ route('dashboard.services') }}">
            <thead class="text-xs text-white uppercase bg-purple-500">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="text-[0.80rem] text-center">

                        <td id="tdName" class="border border-slate-300">

                            {{ $service->name }}
                        </td>
                        <td id="tdDescription" class="text-center border border-slate-300">
                            {{ $service->description }}
                        </td>
                        <td id="tdPrice" class="border text-center border-slate-300">
                            <div class="flex items-center justify-center w-full">
                                {{ $service->price }}
                                <span class="ml-1">€</span>
                            </div>
                        </td>

                        <td id="tdActions" class="border border-slate-300 p-1">
                            <form class="updateForm" method="post"
                                data-form="{{ route('dashboard.updateService', $service->id) }}">
                                @csrf
                                <button
                                    class="text-white rounded bg-blue-500 hover:bg-blue-300 p-1 mt-1">Editar</button>
                            </form>

                            <form method="post" class="deleteForm"
                                data-form="{{ route('dashboard.deleteService', $service->id) }}">
                                @csrf
                                <button type="submit"
                                    class="text-white rounded bg-red-500 hover:bg-red-300 p-1 mt-1">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tr>
            </tbody>
        </table>
    @endif
</div>
