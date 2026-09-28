<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wards', function (Blueprint $table) {

            // Standard primary key
            $table->id(); 

            // Foreign key relationship
            $table->foreignId('constituency_id')
                ->constrained('constituencies')
                ->onDelete('cascade');

            $table->string('name', 100)->nullable();
            $table->string('number', 50)->nullable();
            $table->boolean('status')->default(1);
            $table->string('type', 100)->nullable();

            // GIS fields
            $table->longText('boundry')->nullable();
            $table->string('x_min', 100)->nullable();
            $table->string('x_max', 100)->nullable();
            $table->string('y_min', 100)->nullable();
            $table->string('y_max', 100)->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
