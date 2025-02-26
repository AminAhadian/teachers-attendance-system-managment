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
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->integer('teacher_delay')->defualt(0)->after('teacher_exit_at');
            $table->integer('teacher_hurry')->defualt(0)->after('teacher_delay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_sessions', function (Blueprint $table) {
            $table->dropColumn('teacher_delay');
            $table->dropColumn('teacher_hurry');
        });
    }
};
