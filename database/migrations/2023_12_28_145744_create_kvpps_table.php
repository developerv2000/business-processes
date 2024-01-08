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
        Schema::create('kvpps', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedSmallInteger('status_id');
            $table->unsignedSmallInteger('country_code_id');
            $table->unsignedSmallInteger('priority_id');
            $table->unsignedSmallInteger('source_id');
            $table->unsignedSmallInteger('mnn_id');
            $table->unsignedSmallInteger('form_id');
            $table->string('dose', 300);
            $table->string('pack');
            $table->unsignedSmallInteger('promo_company_id');
            $table->string('info', 1000)->nullable();
            $table->date('date_of_forecast');
            $table->unsignedInteger('forecast_year_1');
            $table->unsignedInteger('forecast_year_2');
            $table->unsignedInteger('forecast_year_3');
            $table->unsignedSmallInteger('portfolio_manager_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kvpps');
    }
};
