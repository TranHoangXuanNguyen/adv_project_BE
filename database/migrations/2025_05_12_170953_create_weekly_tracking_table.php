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
        Schema::create('weekly_tracking', function (Blueprint $table) {
            $table->id('week_track_id');
            $table->string('week_name', 250);
            $table->unsignedBigInteger('semester_id');
            $table->dateTime('start_day');
            $table->dateTime('end_day');
            $table->timestamps();

            // FK: Mỗi tuần theo dõi thuộc 1 học kỳ
            $table->foreign('semester_id')
                ->references('semester_id')->on('semesters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_tracking');
    }
};
