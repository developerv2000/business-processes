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
        Schema::create('process_statuses', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name');
            $table->unsignedSmallInteger('parent_id')->nullable();
            $table->unsignedSmallInteger('stage')->unique()->nullable(); // only roots
            $table->boolean('stage_responsible')->nullable(); // only childs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_statuses');
    }
};
