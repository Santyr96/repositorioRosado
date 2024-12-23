@vite('resources/js/components/dashboards/calendar/calendar.js')

<div id="container" class="w-full flex flex-col items-center">
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al enviar el formulario"
        modalMessage=""></x-modals.error-modal>
        
        <x-modals.advice-modal class="hidden xl:left-40" modalTitle="Eliminar cita"
        modalMessage="¿Estas seguro de eliminar esta cita?" id="deleteWarning"
        :child="view('elements-for-modals.confirmation-delete')"></x-modals.advice-modal>
        
    <x-modals.appointment-edit-and-delete-modal id="editAndDeleteModal" modalTitle="Editar Cita" modalMessage="" :services="$services" :hairdresser="$hairdresser"></x-modals.appointment-edit-and-delete-modal>
    <x-modals.appointment-create-modal id="createModal" modalTitle="Crear Cita" modalMessage="¿Quieres crear una cita?" :services="$services" :hairdresser="$hairdresser" :clients="$clients"></x-modals.appointment-create-modal>
    <div id="title" class="font-noto text-xl md:text-3xl font-bold mb-2">
        <h1>Planifica tus citas</h1>
    </div>
    <div id="calendar"
        class="w-[90%] h-[31rem] pb-4 mb-4 px-1 xl:px-4 md:h-[62rem] xl:h-[40rem] 2xl:h-[50rem] 2xl:w-3/4 
        lg:h-[800px] overflow-scroll text-xs/relaxed md:text-lg font-noto border-2 border-black
        bg-purple-500 text-white">
    </div>
</div>
