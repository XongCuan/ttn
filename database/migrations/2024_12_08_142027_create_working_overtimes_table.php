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
        Schema::create('working_overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_overtime_id');
            $table->unsignedBigInteger('admin_id');
            $table->date('date');
            $table->float('hour');
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::create('type_overtimes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_overtimes');
        Schema::dropIfExists('type_overtimes');
    }
};
