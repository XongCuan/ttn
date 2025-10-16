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
        Schema::create('range_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('name')->nullable();
            $table->float('min_price')->nullable();
            $table->float('max_price')->nullable();
            $table->timestamps();
        });

        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('contact_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('name');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('range_price_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->tinyInteger('department');
            $table->string('fullname');
            $table->char('phone', 20)->nullable();
            $table->char('email', 100)->nullable();
            $table->char('gender', 20)->nullable();
            $table->unsignedInteger('province_code')->nullable();
            $table->unsignedInteger('district_code')->nullable();
            $table->unsignedInteger('ward_code')->nullable();
            $table->tinyInteger('area')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('avatar')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('date_add')->nullable();
            $table->timestamps();
        });

        Schema::create('assigns_contacts', function (Blueprint $table) {
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->unique(['contact_id', 'admin_id']);
        });

        Schema::create('contact_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->dateTime('date_time')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigns_contacts');
        Schema::dropIfExists('contact_activities');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('range_prices');
        Schema::dropIfExists('sources');
        Schema::dropIfExists('contact_types');
        Schema::dropIfExists('sectors');
    }
};
