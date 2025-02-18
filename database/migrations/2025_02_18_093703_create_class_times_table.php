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
        Schema::create('class_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('class_schedules')->cascadeOnDelete();
            $table->integer('day')->default(1);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('type')->default('static');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_times');
    }
};
