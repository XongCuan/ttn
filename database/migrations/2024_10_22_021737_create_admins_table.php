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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->tinyInteger('department');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->tinyInteger('super_department')->nullable();
            $table->char('username', 100)->unique();
            $table->string('fullname')->nullable();
            $table->char('phone', 20)->unique()->nullable();
            $table->char('email', 100)->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->char('gender', 20)->nullable();
            $table->text('avatar')->nullable();
            $table->tinyInteger('status');
            $table->boolean('is_superadmin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->json('work_remote_date')->nullable();
            $table->double('salary')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('leave_days')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admin_departments', function(Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->tinyInteger('department');
            $table->unique(['admin_id', 'department']);
            $table->timestamps();
        });

        Schema::create('admin_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_bank_accounts');
        Schema::dropIfExists('admin_departments');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('teams');
    }
};
