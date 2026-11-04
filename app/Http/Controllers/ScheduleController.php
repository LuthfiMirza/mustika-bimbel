<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Display list of schedules and seat capacity.
     */
    public function index(): View
    {
        $schedules = Schedule::with(['program', 'students'])->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Update schedule session quota and time.
     */
    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'session_name' => ['required', 'string', 'max:120'],
            'days_text' => ['required', 'string', 'max:80'],
            'start_time' => ['required', 'string', 'max:10'],
            'end_time' => ['required', 'string', 'max:10'],
            'max_quota' => ['required', 'integer', 'min:1', 'max:30'],
            'filled_quota' => ['required', 'integer', 'min:0', 'max:30'],
        ]);

        $schedule->update($validated);

        return back()->with('success', "Data kuota jadwal '{$schedule->session_name}' berhasil diperbarui.");
    }
}
