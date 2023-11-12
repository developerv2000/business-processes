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
        Schema::create('blacklist_manufacturer', function (Blueprint $table) {
            $table->unsignedSmallInteger('blacklist_id');
            $table->unsignedInteger('manufacturer_id');
            $table->primary(['blacklist_id', 'manufacturer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklist_manufacturer');
    }
};
