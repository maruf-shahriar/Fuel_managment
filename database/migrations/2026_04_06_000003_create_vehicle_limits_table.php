<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_limits', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_type')->unique();
            $table->decimal('max_amount', 10, 2);
            $table->decimal('max_liters', 10, 2);
            $table->integer('block_days')->default(7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_limits');
    }
};
