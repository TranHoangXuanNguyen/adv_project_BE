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
        Schema::create('weekly_goals', function (Blueprint $table) {
            $table->id('week_goal_id');
            $table->unsignedBigInteger('week_track_id');
            $table->dateTime('start_day');
            $table->dateTime('end_day');
            $table->text('task_des');
            $table->boolean('status')->default(false);
            $table->timestamps();

            // Foreign Key
            $table->foreign('week_track_id')
                ->references('week_track_id')->on('weekly_tracking')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_goals');
    }
};
