<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tuition_invoices', function (Blueprint $table) {
            $table->string('billing_month', 7)->nullable()->index()->after('billing_period');
            $table->unsignedInteger('base_amount')->default(0)->after('billing_month');
            $table->unsignedInteger('discount_amount')->default(0)->after('base_amount');
            $table->unsignedInteger('paid_amount')->default(0)->after('amount');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE tuition_invoices MODIFY COLUMN status ENUM('Belum Lunas', 'Kurang', 'Lunas') NOT NULL DEFAULT 'Belum Lunas'");
        }

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_invoice_id')->constrained('tuition_invoices')->cascadeOnDelete();
            $table->string('receipt_number')->unique();
            $table->date('payment_date');
            $table->unsignedInteger('amount');
            $table->string('payment_method', 50);
            $table->string('received_by', 100)->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE tuition_invoices MODIFY COLUMN status ENUM('Belum Lunas', 'Lunas') NOT NULL DEFAULT 'Belum Lunas'");
        }

        Schema::table('tuition_invoices', function (Blueprint $table) {
            $table->dropColumn(['billing_month', 'base_amount', 'discount_amount', 'paid_amount']);
        });
    }
};
