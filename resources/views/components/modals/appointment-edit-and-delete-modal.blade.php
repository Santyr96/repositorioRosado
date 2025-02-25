<div id="{{ $id }}" tabindex="-1"
    class=" hidden flex justify-center items-center fixed top-0 left-0 xl:left-40 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative rounded-lg shadow bg-purple-700">

            <div class="flex items-center justify-between p-4 md:p-5 border-2 rounded-t bg-white border-gray-600">
                <h3 id="title" class="text-xl font-medium text-black">
                    {{ $modalTitle }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="{{ $id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="p-4 md:p-5 space-y-4">
                <p id="messages" class="text-base leading-relaxed text-white">
                    {{ $modalMessage }}
                </p>
            </div>

            <div class="flex flex-col gap-1 items-center">
                <label class="text-white" for="cliente">Cliente</label>
                    <input class="bg-gray-200 px-2" type="text" id="client" name="client"  value="" disabled>
                    <label class="text-white" for="date">Fecha</label>
                    <textarea class="bg-gray-200 text-center" name="date" id="date" cols="30" value="" disabled></textarea>
                <form name="fAppointment" action="" method="post" enctype="multipart/form-data"
                    data-update="{{ route('dashboard.updateAppointment') }}" data-delete="{{route('dashboard.deleteAppointment')}}" class="flex flex-col gap-2">
                    @csrf
                    <label class="text-white" for="service">Servicio</label>
                    <select name="service" id="service">
                        @if ($services->isNotEmpty())
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        @else
                            <option value="">No hay servicios disponibles</option>
                        @endif
                    </select>
                    <label class="text-white"  for="start">Fecha de inicio</label>
                    <input type="datetime-local" id="start" name="start">
                    @auth
                        @if (Auth::user()->role == 'propietario')
                        <label class="text-white" for="status">Estado</label>
                            <select name="status" id="statusSelect">
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmado">Confirmado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        @else
                            <input type="hidden" id="status" name="status" value="pendiente">
                        @endif
                    @endauth
                    <input type="hidden" id="id_appointment" name="id_appointment">
                    <input type="hidden" id="hairdresser_id" name="hairdresser_id" value="{{ $hairdresser->id }}">

                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button id="updateButton" type="submit"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Editar
                            cita</button>
                            <button id="deleteButton" type="submit"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Eliminar cita</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
