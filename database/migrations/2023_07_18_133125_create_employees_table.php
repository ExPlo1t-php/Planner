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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('employee_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('team_leader_manager_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->timestamps();
    
            $table->foreign('department_id')->references('id')->on('departments')->restrictOnDelete();;
            $table->foreign('project_id')->references('id')->on('projects')->restrictOnDelete();
            $table->foreign('position_id')->references('id')->on('positions')->restrictOnDelete();
            $table->foreign('station_id')->references('id')->on('stations')->restrictOnDelete();
            $table->foreign('team_leader_manager_id')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('team_id')->references('id')->on('teams')->restrictOnDelete();
            $table->foreign('terminal_id')->references('id')->on('terminals')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
