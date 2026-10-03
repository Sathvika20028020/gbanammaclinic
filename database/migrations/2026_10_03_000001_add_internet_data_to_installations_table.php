<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('installed_on');
            $table->string('internet_id')->nullable()->after('provider');
            $table->string('internet_password')->nullable()->after('internet_id');
            $table->date('last_recharge_date')->nullable()->after('internet_password');
            $table->date('recharge_expiry_date')->nullable()->after('last_recharge_date');
            $table->string('plan_validity')->nullable()->after('recharge_expiry_date');
            $table->string('status')->default('active')->after('plan_validity');
        });
    }

    public function down(): void
    {
        Schema::table('installations', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'internet_id',
                'internet_password',
                'last_recharge_date',
                'recharge_expiry_date',
                'plan_validity',
                'status',
            ]);
        });
    }
};
