<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('building_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained();
            $table->foreignId('place_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_place');
    }
};
