<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('level_1_code', 20);
            $table->string('level_1_name', 100);
            $table->string('level_2_code', 20);
            $table->string('level_2_name', 100);
            $table->string('level_3_code', 20);
            $table->string('level_3_name', 100);
            $table->string('level_4_code', 20)->unique();
            $table->string('level_4_name', 100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('wilayah');
    }
};
