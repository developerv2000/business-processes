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
            $table->smallInteger('days_past')->nullable();

            // stage 2 (ПО)
            $table->date('stage_2_start_date')->nullable();
            $table->unsignedInteger('year_1')->nullable();
            $table->unsignedInteger('year_2')->nullable();
            $table->unsignedInteger('year_3')->nullable();

            // Stage 3 (АЦ)
            $table->unsignedDecimal('manufacturer_first_offered_price', 8, 2)->nullable(); // only admins can edit
            $table->unsignedDecimal('manufacturer_followed_offered_price', 8, 2)->nullable();
            $table->unsignedDecimal('our_first_offered_price', 8, 2)->nullable(); // only admins can edit
            $table->unsignedDecimal('our_followed_offered_price', 8, 2)->nullable();
            $table->unsignedSmallInteger('currency_id')->nullable();
            $table->unsignedDecimal('manufacturer_followed_offered_price_in_usd', 8, 2)->nullable();

            // Stage 4 (СЦ)
            $table->unsignedDecimal('agreed_price', 8, 2)->nullable();

            // Stage 5 (КК)
            $table->unsignedSmallInteger('promo_company_id')->nullable();
            $table->string('trademark_en')->nullable();
            $table->string('trademark_ru')->nullable();

            // After КК fields
            $table->unsignedDecimal('increased_price', 8, 2)->nullable();
            $table->unsignedDecimal('increased_price_percentage', 8, 2)->nullable();
            $table->date('increased_price_date')->nullable();
            $table->string('dossier_status')->nullable();
            $table->string('clinical_trial_year')->nullable();
            $table->string('clinical_trial_ich_country')->nullable();
            $table->string('additional_1')->nullable();
            $table->string('additional_2')->nullable();

            $table->timestamps();
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
