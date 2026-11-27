<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\TrialLead;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $newLeads = collect();
            $overdueCount = 0;
            $quickStudents = collect();

            try {
                if (Schema::hasTable('trial_leads')) {
                    $newLeads = TrialLead::where('status', 'Baru')
                        ->latest()
                        ->take(5)
                        ->get(['id', 'student_name', 'grade_level', 'created_at']);
                }

                if (Schema::hasTable('students') && Schema::hasTable('tuition_invoices')) {
                    $overdueCount = Student::where('status', 'Aktif')
                        ->whereHas('invoices', function ($q) {
                            $q->whereIn('status', ['Belum Lunas', 'Kurang'])
                                ->whereDate('due_date', '<', now()->toDateString());
                        })
                        ->count();

                    $quickStudents = Student::orderBy('full_name')
                        ->get(['id', 'full_name', 'student_code', 'grade_level', 'status'])
                        ->map(fn($s) => [
                            'id' => $s->id,
                            'name' => $s->full_name,
                            'code' => $s->student_code,
                            'grade' => $s->grade_level,
                            'status' => $s->status,
                            'url' => route('admin.students.show', $s->id),
                        ]);
                }
            } catch (\Throwable) {
                // Fallback safely during migrations or isolated console commands
            }

            $adminWaDisplay = Setting::get('admin_whatsapp', WhatsAppService::OFFICIAL_WA_DISPLAY);
            $adminWaFormatted = WhatsAppService::formatPhoneNumber($adminWaDisplay);

            $view->with([
                'adminNotifLeads' => $newLeads,
                'adminNotifOverdue' => $overdueCount,
                'adminNotifTotal' => $newLeads->count() + ($overdueCount > 0 ? 1 : 0),
                'adminQuickStudents' => $quickStudents,
                'adminBimbelName' => Setting::get('bimbel_name', 'MustikaBimbel'),
                'adminBimbelAddress' => Setting::get('bimbel_address', 'Perumahan Amarylis Garden Blok I No. 11, Cibinong'),
                'adminWaDisplay' => $adminWaDisplay,
                'adminWaFormatted' => $adminWaFormatted,
            ]);
        });
    }
}
