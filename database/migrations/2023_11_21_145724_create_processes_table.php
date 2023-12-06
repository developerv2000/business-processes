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
        Schema::create('processes', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('generic_id');
            $table->unsignedSmallInteger('status_id');
            $table->date('status_update_date');

            // stage 1 (ВП)
            $table->unsignedSmallInteger('country_code_id');
            $table->date('date'); // process date
            $table->unsignedSmallInteger('days_past')->nullable();

            // stage 2 (ПО)
            $table->date('stage_2_start_date')->nullable();
            $table->string('year_1')->nullable();
            $table->string('year_2')->nullable();
            $table->string('year_3')->nullable();

            // Stage 3 (АЦ)
            $table->unsignedDecimal('manufacturer_first_offered_price', 8, 4)->nullable(); // unchangeable
            $table->unsignedDecimal('manufacturer_followed_offered_price', 8, 4)->nullable();
            $table->unsignedDecimal('our_first_offered_price', 8, 4)->nullable(); // unchangeable
            $table->unsignedDecimal('our_followed_offered__price', 8, 4)->nullable();
            $table->unsignedSmallInteger('currency_id')->nullable();

            // Stage 4 (СЦ)
            $table->unsignedDecimal('agreed', 8, 4)->nullable();

            // Stage 5 (КК)
            $table->string('marketing_authorization_holder')->nullable();
            $table->string('trademark_en')->nullable();
            $table->string('trademark_ru')->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
