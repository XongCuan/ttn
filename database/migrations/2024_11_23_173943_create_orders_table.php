<?php

use App\Enums\Order\ServiceStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('name')->nullable();
            $table->double('sub_total');
            $table->double('total');
            $table->tinyInteger('status');
            $table->tinyInteger('customer_type');
            $table->tinyInteger('priority');
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('order_arises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('name');
            $table->double('amount');
            $table->longText('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('name');
            $table->double('amount');
            $table->text('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->tinyInteger('type');
            $table->double('amount')->default(0);
            $table->tinyInteger('status')->default(ServiceStatus::Inactive->value);
            $table->date('day_begin')->nullable();
            $table->date('day_end')->nullable();
            $table->longText('desc')->nullable();
            $table->timestamps();
        });

        Schema::create('assigns_orders', function (Blueprint $table) {
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->unique([ 'admin_id', 'order_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('order_arises');
        Schema::dropIfExists('order_services');
        Schema::dropIfExists('assigns_orders');
        Schema::dropIfExists('orders');
    }
};
