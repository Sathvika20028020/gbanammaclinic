<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED

            $table->string('name', 255);
            $table->string('latitude', 300)->nullable();
            $table->string('longitude', 300)->nullable();
            $table->string('color', 20)->nullable();
            $table->longText('boundary')->nullable(); 
            $table->boolean('status')->default(1); 
            $table->string('x_min', 100)->nullable();
            $table->string('x_max', 100)->nullable();
            $table->string('y_min', 100)->nullable();
            $table->string('y_max', 100)->nullable();

            // FK to corporations table
            $table->foreignId('corporation_id')
                  ->nullable()
                  ->constrained('corporations')
                  ->onDelete('set null'); 

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
