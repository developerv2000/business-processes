<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manufacturer_zone', function (Blueprint $table) {
            $table->unsignedInteger('manufacturer_id');
            $table->unsignedSmallInteger('zone_id');
            $table->primary(['manufacturer_id', 'zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturer_zone');
    }
};
