@extends('layouts.public')

@section('title', 'MustikaBimbel Cibinong — Bimbel MIPA untuk Masa Depanmu (TK, SD, SMP)')

@section('content')
<div x-data="{
    selectedProgramId: '{{ $programs->first()?->id ?? '' }}',
    selectedScheduleId: '{{ $schedules->first()?->id ?? '' }}',
    selectedGrade: 'SMP',
    gameScore: null,
    gameAvgTime: null,
    applyGameResult(score, avgTime, mode) {
        this.gameScore = score;
        this.gameAvgTime = avgTime;
        this.selectedGrade = mode === 'jarimatika' ? 'SD' : 'SMP';
        document.getElementById('form-trial')?.scrollIntoView({ behavior: 'smooth' });
    },
    chooseSchedule(scheduleId, programId, targetGrade) {
        this.selectedScheduleId = String(scheduleId);
        if (programId) this.selectedProgramId = String(programId);
        if (targetGrade === 'TK-SD') this.selectedGrade = 'TK';
        else if (targetGrade) this.selectedGrade = targetGrade;
        document.getElementById('form-trial')?.scrollIntoView({ behavior: 'smooth' });
    }
}">
    {{-- 1. Hero Section --}}
    @include('landing.partials.hero')

    {{-- 2. Statement Section --}}
    @include('landing.partials.statement')

    {{-- 3. Marquee #1 (Gold) --}}
    @include('landing.partials._marquee', ['tone' => 'gold', 'tilt' => '-2deg'])

    {{-- 4. Core Features / 3 Pilar (#keunggulan) --}}
    @include('landing.partials.features')

    {{-- 5. Mini-Game Tantangan Hitung Cepat 30 Detik --}}
    @includeIf('landing.partials.speed-game')

    {{-- 6. Marquee #2 (Lime) --}}
    @include('landing.partials._marquee', ['tone' => 'lime', 'tilt' => '2deg'])

    {{-- 7. Visualizer Metode Jarimatika & Tab Katalog Materi --}}
    @includeIf('landing.partials.curriculum-tabs')

    {{-- 8. Kamu Nggak Sendirian (Keluhan Umum Orang Tua) --}}
    @includeIf('landing.partials.pain-points')

    {{-- 9. Kenalan Sama Pengajar --}}
    @includeIf('landing.partials.teacher')

    {{-- 10. Program & Biaya --}}
    @includeIf('landing.partials.programs-pricing')

    {{-- 11. Jadwal Belajar Real-Time & Form Klaim Free Trial WA --}}
    @includeIf('landing.partials.schedule-booking')

    {{-- 12. FAQ --}}
    @includeIf('landing.partials.faq')

    {{-- 13. Hias Buku Tugasmu (Sticker Board Draggable) --}}
    @includeIf('landing.partials.sticker-board')

    {{-- 14. Big Closing CTA --}}
    @includeIf('landing.partials.big-cta')

    {{-- 15. Lokasi Amarylis Garden Cibinong & Modal Cek Raport --}}
    @includeIf('landing.partials.location-modal')
</div>
@endsection
