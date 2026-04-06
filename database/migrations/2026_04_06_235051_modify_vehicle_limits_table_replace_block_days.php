<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_limits', function (Blueprint $table) {
            $table->dropColumn(['max_liters', 'block_days']);
            $table->decimal('block_days_per_amount', 8, 2)->default(1)->after('max_amount');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_limits', function (Blueprint $table) {
            $table->dropColumn('block_days_per_amount');
            $table->decimal('max_liters', 10, 2)->default(0);
            $table->integer('block_days')->default(7);
        });
    }
};
