<div x-cloak
     x-show="packageDetails"
     x-transition.opacity
     @click.self="packageDetails = null"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-950/60 p-4 backdrop-blur-sm"
     role="dialog"
     aria-modal="true"
     aria-labelledby="package-detail-title">
    <div x-show="packageDetails"
         x-transition
         class="max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
        <div class="bg-navy-900 p-6 text-white sm:p-8">
            <div class="mb-3 text-sm font-semibold uppercase tracking-wide text-gold" x-text="packageDetails?.serviceName"></div>
            <h2 id="package-detail-title" class="text-2xl font-bold" x-text="packageDetails?.name"></h2>
            <p class="mt-3 text-sm leading-6 text-gray-300" x-text="packageDetails?.description"></p>
            <div class="mt-5 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                <span class="text-2xl font-extrabold text-gold" x-text="packageDetails?.price"></span>
                <span class="text-sm text-gray-300" x-text="packageDetails?.billingPeriod"></span>
            </div>
            <div class="mt-2 flex gap-4 text-sm text-gray-300">
                <span x-show="packageDetails?.deliveryDays" x-text="packageDetails?.deliveryDays"></span>
                <span x-show="packageDetails?.revisionCount" x-text="packageDetails?.revisionCount"></span>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <h3 class="font-semibold text-navy-900">Yang termasuk dalam paket</h3>
            <ul class="mt-4 space-y-3">
                <template x-for="feature in (packageDetails?.features || [])" :key="feature">
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 13 4 4L19 7"/>
                        </svg>
                        <span x-text="feature"></span>
                    </li>
                </template>
            </ul>
            <p class="mt-5 rounded-xl bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                Detail kebutuhan, kesepakatan, dan transaksi akan dibahas langsung melalui WhatsApp.
            </p>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 p-5 sm:flex-row sm:justify-end sm:px-8">
            <button type="button"
                    @click="packageDetails = null"
                    class="rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2">
                Tutup
            </button>
            <a :href="packageDetails?.contactUrl"
               class="btn-primary justify-center px-5 py-3 text-sm">
                Lanjut ke Kontak
            </a>
        </div>
    </div>
</div>
