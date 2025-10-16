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
        Schema::table('customers', function (Blueprint $table) {
            // CHỈ THÊM các trường mới - KHÔNG XÓA gì cả
            $table->string('company')->nullable()->after('fullname'); // Tên Khách Hàng
            $table->string('short_name')->nullable()->after('company'); // Tên viết tắt  
            $table->string('tax_code')->nullable()->after('short_name'); // Mã số Thuế
            $table->string('customer_type')->nullable()->after('tax_code'); // Loại Khách Hàng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // CHỈ XÓA các trường mới thêm
            $table->dropColumn(['company', 'short_name', 'tax_code', 'customer_type']);
        });
    }
};