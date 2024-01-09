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
        Schema::create('process_crbecountry', function (Blueprint $table) {
            $table->unsignedInteger('process_id');
            $table->unsignedSmallInteger('country_id');
            $table->primary(['process_id', 'country_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_crbecountry');
    }
};
