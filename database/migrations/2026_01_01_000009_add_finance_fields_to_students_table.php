<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedInteger('monthly_discount')->default(0)->after('schedule_id');
            $table->string('discount_reason', 120)->nullable()->after('monthly_discount');
            $table->date('left_date')->nullable()->after('join_date');
            $table->text('internal_notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['monthly_discount', 'discount_reason', 'left_date', 'internal_notes']);
        });
    }
};
