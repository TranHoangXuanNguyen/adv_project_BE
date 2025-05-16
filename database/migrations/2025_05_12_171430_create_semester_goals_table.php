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
        Schema::create('semester_goals', function (Blueprint $table) {
            $table->id('s_goal_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');

            $table->text('course_expected');
            $table->text('teacher_expected');
            $table->text('themselves_expected');

            $table->timestamps();

            // FK
            $table->foreign('student_id')
                ->references('user_id')->on('users')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('subject_id')->on('subjects')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_goals');
    }
};
