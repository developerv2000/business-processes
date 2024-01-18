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
        Schema::create('kvpp_promocompany', function (Blueprint $table) {
            $table->unsignedInteger('kvpp_id');
            $table->unsignedSmallInteger('promo_company_id');
            $table->primary(['kvpp_id', 'promo_company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kvpp_promocompany');
    }
};
