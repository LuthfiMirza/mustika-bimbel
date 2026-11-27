<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show dynamic bimbel settings and WhatsApp message templates.
     */
    public function index(): View
    {
        $settings = Setting::allMap();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Persist updated settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bimbel_name' => ['required', 'string', 'max:120'],
            'bimbel_address' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:120'],
            'admin_whatsapp' => ['required', 'string', 'max:30'],
            'payment_info' => ['required', 'string', 'max:500'],
            'tuition_due_day' => ['required', 'integer', 'min:1', 'max:28'],
            'period_start_month' => ['required', 'regex:/^\d{4}-\d{2}$/'],
            'wa_template_reminder' => ['required', 'string', 'max:2000'],
            'wa_template_receipt' => ['required', 'string', 'max:2000'],
            'wa_template_arrival' => ['required', 'string', 'max:2000'],
            'wa_template_report' => ['required', 'string', 'max:2000'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, (string) $value);
        }

        return back()->with('success', 'Pengaturan bimbel, info rekening, dan template WhatsApp berhasil diperbarui!');
    }
}
