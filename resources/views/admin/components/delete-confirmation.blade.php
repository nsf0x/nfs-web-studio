<div x-cloak
     x-show="deleteModalOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="deleteModalOpen = false"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-950/60 p-4 backdrop-blur-sm"
     role="dialog"
     aria-modal="true"
     aria-labelledby="delete-dialog-title"
     x-bind:aria-label="'Konfirmasi hapus ' + deleteName">
    <div x-show="deleteModalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="translate-y-3 scale-95"
         x-transition:enter-end="translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="translate-y-0 scale-100"
         x-transition:leave-end="translate-y-3 scale-95"
         class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="p-6 sm:p-7">
            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.7 3.86a2 2 0 0 0-3.4 0Z"/>
                </svg>
            </div>
            <h2 id="delete-dialog-title" class="text-xl font-bold text-navy-900">Hapus data ini?</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Anda akan menghapus <span class="font-semibold text-gray-700" x-text="deleteName"></span>.
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end sm:px-7">
            <button type="button"
                    @click="deleteModalOpen = false"
                    class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2">
                Batal
            </button>
            <form method="POST" :action="deleteAction">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
