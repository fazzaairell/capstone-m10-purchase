<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // buang tabel lama yang isinya masih dasar (item dulu, karena menunjuk ke permintaan)
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');

        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number', 20)->unique();
            $table->string('requester_name', 100);
            $table->string('department', 50)->nullable();   // boleh kosong untuk draf
            $table->text('reason')->nullable();             // boleh kosong untuk draf
            $table->decimal('total_estimated', 14, 2)->default(0);
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->cascadeOnDelete();
            $table->string('name', 255);
            $table->decimal('quantity', 12, 2)->default(1);
            $table->string('unit', 20)->default('Pcs');
            $table->decimal('estimated_price', 14, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
        Schema::dropIfExists('purchase_requests');
    }
};