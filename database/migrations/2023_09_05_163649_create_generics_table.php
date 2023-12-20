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
        Schema::create('generics', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('manufacturer_id');
            $table->unsignedMediumInteger('mnn_id');
            $table->string('brand')->nullable();
            $table->unsignedSmallInteger('form_id');
            $table->unsignedSmallInteger('category_id');
            $table->string('dose', 300)->nullable();
            $table->string('pack')->nullable();
            $table->string('minimum_volume')->nullable();
            $table->unsignedSmallInteger('expiration_date_id');
            $table->string('dossier', 1000)->nullable();
            $table->string('bioequivalence', 600)->nullable();
            $table->string('additional_payment', 400)->nullable();
            $table->string('patent_expiry', 400)->nullable();
            $table->boolean('registered_in_eu')->default(0);
            $table->boolean('marketed_in_eu')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generics');
    }
};
