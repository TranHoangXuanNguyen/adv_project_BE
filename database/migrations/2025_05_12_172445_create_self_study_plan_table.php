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
        Schema::create('self_study_plan', function (Blueprint $table) {
            $table->id('self_plan_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('week_track_id');

            $table->text('lesson_learn')->nullable();
            $table->string('time_spend')->nullable();
            $table->text('learning_resource')->nullable();
            $table->text('learning_activities')->nullable();
            $table->boolean('in_solve')->default(false);
            $table->tinyInteger('concentration')->nullable(); // 1-3
            $table->date('date')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->foreign('week_track_id')->references('week_track_id')->on('weekly_tracking')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_study_plan');
    }
};
