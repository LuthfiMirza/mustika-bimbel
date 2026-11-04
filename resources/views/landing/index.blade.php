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
    {{-- 1. Hero Section & 3 Pilar Utama --}}
    @include('landing.partials.hero-pillars')

    {{-- 2. Mini-Game Tantangan Hitung Cepat 30 Detik --}}
    @includeIf('landing.partials.speed-game')

    {{-- 3. Visualizer Metode Jarimatika & Tab Katalog Materi --}}
    @includeIf('landing.partials.curriculum-tabs')

    {{-- 4. Jadwal Belajar Real-Time & Form Klaim Free Trial WA --}}
    @includeIf('landing.partials.schedule-booking')

    {{-- 5. Lokasi Amarylis Garden Cibinong & Modal Cek Raport --}}
    @includeIf('landing.partials.location-modal')
</div>
@endsection
