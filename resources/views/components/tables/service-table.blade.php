<div class="w-[95%] h-96 xl:h-[40rem] relative  overflow-auto">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>

    @if ($services->isEmpty())
        <p>No hay servicios registrados.</p>
        <table id="tableServices" class="w-full text-center leading-normal table-auto border-collapse border border-slate-400 font-work" data-url="{{ route('dashboard.services') }}">
            <thead class="text-xs text-white uppercase bg-purple-500">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Formulario para crear -->
                <tr id="crear" class="text-[0.80rem]">
                    <td class="border border-slate-300">
                        <input class="p-2 text-sm resize-none" name="name" type="text"
                            placeholder="Nombre del servicio">
                    </td>
                    <td class="text-center border border-slate-300">
                        <textarea class="p-2 text-sm resize-none" name="description" placeholder="Descripción"></textarea>
                    </td>
                    <td class="border text-center border-slate-300">
                        <div class="flex items-center justify-center w-full">
                            <input class="w-16 p-2 text-sm resize-none" step="0.01" type="number" name="price"
                                placeholder="5,00">
                            <span class="ml-1">€</span>
                        </div>
                    </td>
                    <td class="border border-slate-300">
                        <form action="#" method="post" name="createServicesForm"
                            data-form="{{ route('dashboard.createService') }}"
                            >
                            @csrf
                            <button class="text-white rounded bg-green-500 hover:bg-green-300 p-1 mt-1"
                                type="submit">Crear</button>
                                <input type="hidden" name="idHairdresser" value="{{ $hairdresser->id }}">
                        </form>
                    </td>
                   
                </tr>
            </tbody>
        </table>

    @else
        <table id="tableServices" class="w-full text-center leading-normal table-auto border-collapse border border-slate-400 font-work" data-url="{{ route('dashboard.services') }}">
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

                        <td class="border border-slate-300">
                            <input class="p-1 text-sm resize-y xl:w-full text-center" name="name" type="text"
                                value="{{ $service->name }}">
                        </td>
                        <td class="text-center border border-slate-300">
                            <textarea class="p-1 text-sm resize-none xl:w-full" name="description">{{ $service->description }}</textarea>
                        </td>
                        <td class="border text-center border-slate-300">
                            <div class="flex items-center justify-center w-full">
                                <input class="w-16 p-1 text-sm resize-none" step="0.01" type="number" name="price"
                                    value="{{ $service->price }}">
                                <span class="ml-1">€</span>
                            </div>
                        </td>

                        <td class="border border-slate-300 p-1">
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

                <!-- Formulario para crear -->
                <tr id="crear" class="text-[0.80rem]">
                    <td class="border border-slate-300">
                        <input class="p-2 text-sm resize-none xl:w-full text-center" name="name" type="text"
                            placeholder="Nombre del servicio">
                    </td>
                    <td class="text-center border border-slate-300">
                        <textarea class="p-2 text-sm resize-none xl:w-full" name="description" placeholder="Descripción"></textarea>
                    </td>
                    <td class="border text-center border-slate-300">
                        <div class="flex items-center justify-center w-full">
                            <input class="w-16 p-2 text-sm resize-none" step="0.01" type="number" name="price"
                                placeholder="5,00">
                            <span class="ml-1">€</span>
                        </div>
                    </td>
                    <td class="border border-slate-300">
                        <form action="#" method="post" name="createServicesForm"
                            data-form="{{ route('dashboard.createService') }}"
                            >
                            @csrf
                            <button class="text-white rounded bg-green-500 hover:bg-green-300 p-1 mt-1"
                                type="submit">Crear</button>
                                <input type="hidden" name="idHairdresser" value="{{ $hairdresser->id }}">
                        </form>
                    </td>
                   

                </tr>
            </tbody>
        </table>
    @endif
</div>
