<div class="overflow-hidden rounded-xl border border-gray-200 transition-colors hover:border-accent/40"
     x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}"
            aria-controls="faq-answer-{{ $index }}"
            :aria-expanded="open === {{ $index }}"
            class="flex w-full items-center justify-between gap-4 bg-white px-6 py-4 text-left transition-colors hover:bg-gray-50">
        <span class="text-sm font-semibold text-navy-900 sm:text-base">{{ $faq->question }}</span>
        <svg class="h-5 w-5 shrink-0 text-gray-400 transition-transform duration-200"
             :class="open === {{ $index }} ? 'rotate-180 text-accent' : ''"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div id="faq-answer-{{ $index }}" x-show="open === {{ $index }}" x-transition x-cloak
         class="border-t border-gray-100 px-6 pb-5 text-sm leading-relaxed text-gray-500">
        <div class="pt-4">{{ $faq->answer }}</div>
    </div>
</div>
