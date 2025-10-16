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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('code')->unique();
            $table->string('name');
            $table->char('division_type');
            $table->char('codename');
            $table->integer('phone_code');
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->integer('province_code')->unsigned();
            $table->integer('code')->unique();
            $table->string('name');
            $table->char('division_type');
            $table->char('codename');
            $table->timestamps();
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->integer('district_code')->unsigned();
            $table->integer('code')->unique();
            $table->string('name');
            $table->char('division_type');
            $table->char('codename');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
};
