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
        Schema::create('process_histories', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('action');
            $table->unsignedInteger('process_id');
            $table->json('options');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_histories');
    }
};
