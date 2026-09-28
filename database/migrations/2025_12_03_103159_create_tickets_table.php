<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Link ticket to the user who raised it
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('admin_resolution')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->string('admin_image')->nullable(); // image path only
            $table->enum('status', [
                'pending',
                'irrelevant',
                'resolved'
            ])->default('pending');

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
