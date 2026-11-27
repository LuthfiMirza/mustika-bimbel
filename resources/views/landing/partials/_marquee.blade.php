@php
    $marqueeItems = $items ?? [
        'KELAS COBA GRATIS',
        'JARIMATIKA TK–SD',
        'MIPA SD–SMP',
        'MAKS 10 SISWA/SESI',
        'E-RAPORT TIAP PERTEMUAN',
        'AMARYLIS GARDEN CIBINONG',
    ];
    $toneClass = match ($tone ?? 'gold') {
        'lime' => 'marquee--lime',
        'ink' => 'marquee--ink',
        default => '',
    };
    $tiltVal = $tilt ?? '-2deg';
@endphp

<div class="overflow-x-clip py-4 select-none">
    <div class="marquee {{ $toneClass }}" style="--tilt: {{ $tiltVal }};">
        <div class="marquee__track">
            @for ($loopCopy = 0; $loopCopy < 2; $loopCopy++)
                @foreach ($marqueeItems as $item)
                    <span class="inline-flex items-center gap-4 whitespace-nowrap">
                        <span>{{ $item }}</span>
                        <span aria-hidden="true">★</span>
                    </span>
                @endforeach
            @endfor
        </div>
    </div>
</div>
