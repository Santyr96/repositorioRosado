<form name="fCreateService" action="" method="post">
    @csrf
    <label for="name">Nombre para el servicio</label>
    <input type="text" name="name" id="name">
    <x-forms.span-validate class="w-10/12">
    </x-forms.span-validate>

    <label for="description">Descripción</label>
    <textarea name="description" id="description" cols="30" rows="10"></textarea>
    <x-forms.span-validate class="w-10/12">
    </x-forms.span-validate>

    <label for="price">Precio</label>
    <input type="number" name="price" id="price">

    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
        <button id="send" type="submit"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Editar servicio
            cita</button>
        <button id="cancel" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            data-modal-hide="{{ $id }}">Cancelar</button>
    </div>
</form>
