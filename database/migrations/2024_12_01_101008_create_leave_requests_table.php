<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('status')->default(LeaveRequestStatus::Pending);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_half_day')->default(false);
            $table->char('half_day_type')->nullable();
            $table->text('reason')->nullable();
            $table->text('reason_rejection')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
