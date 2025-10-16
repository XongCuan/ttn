<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->tinyInteger('department');
            $table->string('name')->nullable();
            $table->tinyInteger('priority');
            $table->tinyInteger('scale')->default(10);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('demo_ontime')->nullable();
            $table->date('demo_date')->nullable();
            $table->text('desc')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });

        Schema::create('assigns_projects', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->unique(['project_id', 'admin_id']);
        });

        Schema::create('project_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->tinyInteger('status');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('demo_date')->nullable();
            $table->boolean('demo_ontime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigns_projects');
        Schema::dropIfExists('project_requirements');
        Schema::dropIfExists('projects');
    }
};
