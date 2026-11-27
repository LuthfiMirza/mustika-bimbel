@php
    $pose = $pose ?? 'wave';
    $size = $size ?? 120;
    $animate = $animate ?? true;
    // Irama goyang berbeda tiap maskot supaya tidak bergerak serempak
    $GLOBALS['__mascotN'] = ($GLOBALS['__mascotN'] ?? 0) + 1;
    $mn = $GLOBALS['__mascotN'];
    $wiggleStyle = $animate
        ? sprintf('animation-duration: %.2fs; animation-delay: -%.2fs;', 2.6 + ($mn % 4) * 0.35, fmod($mn * 0.83, 3))
        : '';
@endphp

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 140 140" fill="none"
     xmlns="http://www.w3.org/2000/svg"
     class="{{ $animate ? 'wiggle' : '' }} {{ $class ?? '' }}"
     style="{{ $wiggleStyle }}"
     aria-hidden="true">
    <!-- Left Arm / Hand -->
    @if ($pose === 'wave')
        <!-- Waving 5-finger Jarimatika hand up left -->
        <path d="M36 62 C22 52, 16 38, 22 30" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <circle cx="22" cy="28" r="10" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
        <path d="M16 20 L14 13 M20 18 L20 11 M25 18 L27 11 M29 21 L33 16 M14 27 L9 24" stroke="#111111" stroke-width="2.5" stroke-linecap="round"/>
    @elseif ($pose === 'wow')
        <path d="M34 65 C18 55, 14 40, 20 30" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <circle cx="20" cy="28" r="9" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
    @elseif ($pose === 'think')
        <path d="M38 68 C26 70, 28 84, 48 82" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <circle cx="50" cy="82" r="8" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
    @else
        <!-- Default arm down -->
        <path d="M36 74 C24 80, 22 92, 28 96" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
    @endif

    <!-- Right Arm / Hand -->
    @if ($pose === 'thumbs')
        <!-- Thumbs up 5-finger Jarimatika hand -->
        <path d="M104 68 C118 60, 122 48, 118 40" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <rect x="108" y="30" width="18" height="16" rx="7" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
        <path d="M115 30 L115 20 C115 17, 120 17, 120 20 L120 30" fill="#FFFDF7" stroke="#111111" stroke-width="3.5" stroke-linecap="round"/>
    @elseif ($pose === 'wow')
        <path d="M106 65 C122 55, 126 40, 120 30" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <circle cx="120" cy="28" r="9" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
    @else
        <path d="M104 72 C116 78, 118 90, 112 96" stroke="#111111" stroke-width="4.5" stroke-linecap="round"/>
        <circle cx="112" cy="98" r="8" fill="#FFFDF7" stroke="#111111" stroke-width="3.5"/>
    @endif

    <!-- Rounded 5-Point Star Body ("Tika si Bintang Hitung") -->
    <path d="M70 14
             C75 14, 79 26, 84 37
             C86 41, 90 43, 94 44
             C106 45, 118 47, 120 53
             C122 58, 112 67, 103 75
             C100 78, 99 82, 100 86
             C103 98, 106 111, 101 115
             C96 119, 84 111, 74 104
             C71 102, 69 102, 66 104
             C56 111, 44 119, 39 115
             C34 111, 37 98, 40 86
             C41 82, 40 78, 37 75
             C28 67, 18 58, 20 53
             C22 47, 34 45, 46 44
             C50 43, 54 41, 56 37
             C61 26, 65 14, 70 14 Z"
          fill="#FACC15" stroke="#111111" stroke-width="4.5" stroke-linejoin="round"/>

    <!-- Rosy Cheeks -->
    <ellipse cx="48" cy="73" rx="6" ry="3.5" fill="#FB7185" opacity="0.45"/>
    <ellipse cx="92" cy="73" rx="6" ry="3.5" fill="#FB7185" opacity="0.45"/>

    <!-- Big Expressive Eyes -->
    <circle cx="56" cy="60" r="6.5" fill="#111111"/>
    <circle cx="84" cy="60" r="6.5" fill="#111111"/>
    <circle cx="58" cy="58" r="2.2" fill="#FFFFFF"/>
    <circle cx="86" cy="58" r="2.2" fill="#FFFFFF"/>

    <!-- Mouth Expression by Pose -->
    @if ($pose === 'wow')
        <ellipse cx="70" cy="78" rx="7" ry="8.5" fill="#E8432E" stroke="#111111" stroke-width="3"/>
    @elseif ($pose === 'think')
        <path d="M63 77 Q70 75 77 79" stroke="#111111" stroke-width="3.5" stroke-linecap="round"/>
    @else
        <path d="M58 74 Q70 86 82 74" stroke="#111111" stroke-width="3.8" stroke-linecap="round" fill="none"/>
    @endif
</svg>
