<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enq_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enq_id'); // Link tới bảng enq
            
            // Thông tin sản phẩm
            $table->string('code', 100)->nullable(); // Mã code sản phẩm
            $table->text('description_sale')->nullable(); // Mô tả Sale
            $table->text('description_inter')->nullable(); // Mô tả Inter
            $table->integer('quantity')->default(1); // Số lượng
            $table->string('unit', 50)->nullable(); // Đơn vị
            $table->string('origin', 100)->nullable(); // Xuất xứ
            
            // Giá (có thể để null khi mới tạo, sau Inter báo giá mới fill)
            $table->decimal('unit_price', 15, 2)->nullable(); // Đơn giá
            $table->decimal('total_price', 15, 2)->nullable(); // Tổng cộng
            
            // Thời gian giao hàng
            $table->string('delivery_time')->nullable(); // Delivery time DDP term
            
            // Ghi chú
            $table->text('note')->nullable(); // Ghi chú Sale
            $table->text('note_sale_leader')->nullable(); // Ghi chú Sale Leader
            
            $table->integer('sort_order')->default(0); // Thứ tự hiển thị
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('enq_id')->references('id')->on('enq')->onDelete('cascade');
            
            // Index
            $table->index('enq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enq_details');
    }
};