<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enq', function (Blueprint $table) {
            $table->string('fullname')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('enq', function (Blueprint $table) {
            $table->string('fullname')->nullable(false)->change();
        });
    }
};