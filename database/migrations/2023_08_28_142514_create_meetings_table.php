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
        Schema::create('meetings', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('manufacturer_id');
            $table->unsignedSmallInteger('year');
            $table->unique(['manufacturer_id', 'year']);
            $table->string('who_met', 1000)->nullable();
            $table->string('plan', 3000)->nullable();
            $table->string('topic', 3000)->nullable();
            $table->string('result', 3000)->nullable();
            $table->string('outside_the_exhibition', 3000)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
