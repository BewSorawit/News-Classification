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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('payload'); // เพิ่มคอลัมน์ payload
            $table->integer('last_activity'); // เพิ่มคอลัมน์ last_activity
            $table->string('user_id')->nullable(); // เพิ่มคอลัมน์ user_id (ถ้าต้องการใช้)
            $table->string('ip_address')->nullable(); // เพิ่มคอลัมน์ ip_address (ถ้าต้องการใช้)
            $table->string('user_agent')->nullable(); // เพิ่มคอลัมน์ user_agent (ถ้าต้องการใช้)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
