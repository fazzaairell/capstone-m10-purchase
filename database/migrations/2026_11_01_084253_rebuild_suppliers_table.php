<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('suppliers');

        Schema::create('suppliers', function (Blueprint $table) {
            // 1. Identitas
            $table->id();
            $table->string('supplier_code', 30)->unique();
            $table->string('company_name', 150);

            // 2. Legalitas dan perpajakan
            $table->enum('tax_type', ['PKP', 'NON_PKP'])->default('PKP');
            $table->string('npwp', 35)->nullable();

            // 3. Narahubung
            $table->string('contact_person', 100);
            $table->string('email', 100);
            $table->string('phone', 25);

            // 4. Alamat
            $table->text('address');
            $table->string('city', 60);
            $table->string('postal_code', 10)->nullable();

            // 5. Logistik dan pengadaan
            $table->enum('delivery_type', ['DC', 'DSD'])->default('DC');
            $table->unsignedInteger('lead_time_days')->default(3);
            $table->decimal('minimum_order_qty', 12, 2)->default(0);
            $table->enum('return_policy', ['Exchange', 'Credit_Note', 'No_Return'])->default('Credit_Note');

            // 6. Keuangan dan pembayaran
            $table->string('payment_terms', 50)->default('Net 30');
            $table->string('bank_name', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('account_holder', 100)->nullable();

            // 7. Evaluasi dan status
            $table->enum('status', ['active', 'suspended', 'terminated'])->default('active');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('notes')->nullable();

            // 8. Timestamp dan soft delete
            $table->timestamps();
            $table->softDeletes();

            // untuk pencarian dan pengecekan duplikat yang cepat
            $table->index('status');
            $table->index(['company_name', 'contact_person']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};