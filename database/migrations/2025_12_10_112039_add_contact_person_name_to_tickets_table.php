<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add contact_person_name column to tickets table
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            // Adding new column safely
            if (!Schema::hasColumn('tickets', 'contact_person_name')) {
                $table->string('contact_person_name')
                      ->nullable()
                      ->after('user_id'); // Place it after user_id for clarity
            }
        });
    }

    /**
     * Rollback column
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'contact_person_name')) {
                $table->dropColumn('contact_person_name');
            }
        });
    }
};
