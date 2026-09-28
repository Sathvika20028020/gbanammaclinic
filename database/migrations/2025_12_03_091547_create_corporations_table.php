<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->id(); 

            $table->string('name', 255)->unique();
            $table->longText('boundary')->nullable(); 

            
            $table->string('x_min', 300)->nullable();
            $table->string('x_max', 300)->nullable();
            $table->string('y_min', 300)->nullable();
            $table->string('y_max', 300)->nullable();

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporations');
    }
};
