<!-- Section: Grafik Perkembangan Belajar (Chart.js) -->
<div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border-2 border-slate-200/80">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-[#0D9488]">Analisis Performa Siswa</span>
            <h2 class="text-lg sm:text-2xl font-extrabold text-[#0F2C59]">Grafik Perkembangan Belajar</h2>
        </div>

        @php
            $firstScore = count($chartScores) > 0 ? $chartScores[0] : 0;
            $latestScore = count($chartScores) > 0 ? end($chartScores) : 0;
            $scoreDiff = $latestScore - $firstScore;
        @endphp

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-extrabold flex items-center gap-1.5">
                <i data-lucide="trending-up" class="w-4 h-4 text-emerald-600"></i>
                Peningkatan Skor: {{ $scoreDiff >= 0 ? '+' . $scoreDiff : $scoreDiff }} Poin
            </span>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Chart 1: Skor Latihan Soal (0-100) -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#0F2C59]"></div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#0F2C59]">Skor Latihan Soal (0–100)</h3>
                </div>
                <span class="text-xs font-bold text-slate-500">Rata-rata: {{ $averageScore }}</span>
            </div>
            <div class="relative h-60 sm:h-64">
                <canvas id="practiceScoreChart"></canvas>
            </div>
            <p class="text-[11px] text-slate-500 text-center mt-3">
                Evaluasi tingkat pemahaman konsep dan akurasi penyelesaian soal latihan.
            </p>
        </div>

        <!-- Chart 2: Rating Kecepatan Hitung (1-5 Bintang) -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#0D9488]"></div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-[#0F2C59]">Rating Kecepatan Hitung (1–5 ⭐)</h3>
                </div>
                <span class="text-xs font-bold text-slate-500">Rata-rata: {{ $averageSpeed }} / 5</span>
            </div>
            <div class="relative h-60 sm:h-64">
                <canvas id="speedRatingChart"></canvas>
            </div>
            <p class="text-[11px] text-slate-500 text-center mt-3">
                Refleksi ketangkasan jari Jarimatika dan trik efisiensi waktu pengerjaan.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const labels = {!! json_encode($chartLabels) !!};
    const scores = {!! json_encode($chartScores) !!};
    const speeds = {!! json_encode($chartSpeeds) !!};

    // Practice Score Chart
    const ctxScore = document.getElementById('practiceScoreChart');
    if (ctxScore) {
        new Chart(ctxScore, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Latihan',
                    data: scores,
                    borderColor: '#0F2C59',
                    backgroundColor: 'rgba(250, 204, 21, 0.25)',
                    pointBackgroundColor: '#FACC15',
                    pointBorderColor: '#0F2C59',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.35,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 40,
                        max: 100,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Skor: ${ctx.parsed.y} / 100`
                        }
                    }
                }
            }
        });
    }

    // Speed Rating Chart
    const ctxSpeed = document.getElementById('speedRatingChart');
    if (ctxSpeed) {
        new Chart(ctxSpeed, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rating Kecepatan (1-5)',
                    data: speeds,
                    backgroundColor: '#0D9488',
                    borderRadius: 8,
                    maxBarThickness: 36,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1,
                            font: { family: 'Plus Jakarta Sans', size: 10 }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Kecepatan: ${ctx.parsed.y} dari 5 Bintang`
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush

