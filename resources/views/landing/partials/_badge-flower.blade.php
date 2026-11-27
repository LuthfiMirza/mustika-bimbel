@php
    $fill = ($tone ?? 'lime') === 'gold' ? '#FACC15' : '#D7FF3A';
    $icon = $icon ?? 'sparkles';
    $size = $size ?? 58;
@endphp

<div class="relative inline-flex items-center justify-center shrink-0 {{ $class ?? '' }}"
     style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[2px_2px_0_#111]" aria-hidden="true">
        <path d="M50 4 C56 4, 60 12, 66 14 C72 16, 80 12, 84 17 C89 22, 85 30, 88 36 C91 42, 98 46, 98 52 C98 58, 90 62, 88 68 C85 74, 89 82, 84 86 C79 91, 71 87, 65 89 C59 91, 55 98, 49 98 C43 98, 39 90, 33 88 C27 86, 19 90, 15 85 C10 80, 14 72, 11 66 C8 60, 2 56, 2 50 C2 44, 9 40, 12 34 C15 28, 11 20, 16 15 C21 10, 29 14, 35 12 C41 10, 44 4, 50 4 Z"
              fill="{{ $fill }}" stroke="#111111" stroke-width="4" stroke-linejoin="round"/>
    </svg>
    <i data-lucide="{{ $icon }}" class="w-5 h-5 text-ink absolute"></i>
</div>
