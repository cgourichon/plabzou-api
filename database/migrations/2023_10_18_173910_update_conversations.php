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
        Schema::table('conversations', function (Blueprint $table) {
            $table->softDeletes();
            $table->dropColumn('name');
            //$table->unsignedBigInteger('teacher_id');
            $table->foreignId('teacher_id')->constrained('teachers', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->string('name')->nullable();
            $table->dropForeign('teacher_id');
            $table->dropColumn('teacher_id');
        });
    }
};
