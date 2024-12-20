@vite('resources/js/components/modals/closeModal.js')
<div id="{{ $id }}" tabindex="-1"
    class="advise-modal flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full {{ $class }}">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative  rounded-lg shadow bg-gray-600">

            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                <h3 id="modalTitle" class="text-xl font-medium text-white">
                    {{ $modalTitle }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                <p id="message" class="text-base leading-relaxed text-white">
                    {{ $modalMessage }}
                </p>
            </div>

            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div id="child" class="w-full">
                    {!! $child !!}
                </div>
            </div>

        </div>
    </div>
</div>
