<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enq', function (Blueprint $table) {
            // Thêm các cột mới
            $table->string('enq_code', 50)->unique()->nullable()->after('id');
            $table->unsignedBigInteger('customer_id')->nullable()->after('enq_code');
            $table->unsignedBigInteger('brand_id')->nullable()->after('sector_id');
            $table->string('company')->nullable()->after('fullname');
            $table->string('short_name')->nullable()->after('company');
            $table->string('tax_code', 50)->nullable()->after('short_name');
            $table->string('customer_type', 20)->nullable()->after('gender');
            $table->longText('description')->nullable()->after('note');
            $table->softDeletes();
            
            // Sửa cột status
            $table->string('status', 50)->default('pending')->change();
            
            // Thêm index
            $table->index('customer_id');
            $table->index('admin_id');
            $table->index('team_id');
            $table->index('status');
            $table->index('enq_code');
        });
    }

    public function down(): void
    {
        Schema::table('enq', function (Blueprint $table) {
            $table->dropColumn([
                'enq_code',
                'customer_id',
                'brand_id',
                'company',
                'short_name',
                'tax_code',
                'customer_type',
                'description'
            ]);
            $table->dropSoftDeletes();
            
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['admin_id']);
            $table->dropIndex(['team_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['enq_code']);
        });
    }
};