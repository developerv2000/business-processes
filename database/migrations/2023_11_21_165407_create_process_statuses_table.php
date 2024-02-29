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
            $table->string('name_for_admins'); // some names (especially stage > 5 names) can be different due to user roles
            $table->string('name_for_analysts');
            $table->unsignedSmallInteger('parent_id')->nullable(); // General statuses
            $table->unsignedSmallInteger('stage')->unique()->nullable(); // only for roots (General statuses). Used on process create
            $table->unsignedSmallInteger('responsible_child_id')->nullable(); // only for roots (General statuses). Used on process create
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
