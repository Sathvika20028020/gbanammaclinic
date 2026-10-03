<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installation_recharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_id')
                ->constrained('installations')
                ->onDelete('cascade');
            $table->date('recharge_date');
            $table->date('expiry_date');
            $table->string('plan_validity')->default('1 Month');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('receipt_no')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installation_recharges');
    }
};
