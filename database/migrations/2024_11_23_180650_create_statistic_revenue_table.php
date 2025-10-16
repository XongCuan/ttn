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
        Schema::create('statistic_revenue', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id');
            $table->date('statistic_date');
            $table->double('amount')->default(0);
            $table->tinyInteger('customer_type');
            $table->unique(['source_id', 'statistic_date', 'customer_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_revenue');
    }
};
