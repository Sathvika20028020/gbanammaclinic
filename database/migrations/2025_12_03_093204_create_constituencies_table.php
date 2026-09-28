<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('constituencies', function (Blueprint $table) {
            $table->id(); 

            // FK to zones table
            $table->foreignId('zone_id')
                  ->nullable()
                  ->constrained('zones')
                  ->onDelete('set null');

            $table->string('name', 255)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();

            $table->boolean('status')->default(1); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('constituencies');
    }
};
