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
        Schema::create('enq', function (Blueprint $table) {
            $table->id();        
            $table->unsignedBigInteger('invite_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('range_price_id')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
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
            $table->longText('note')->nullable();
            $table->boolean('is_new')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enq');
    }
};
