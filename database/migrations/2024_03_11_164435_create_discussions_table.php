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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); // unsigned itu agar defaultnya tidak mines
            $table->bigInteger('category_id')->unsigned(); // unsigned itu agar defaultnya tidak mines
            $table->string('title');
            $table->string('slug');
            $table->string('content_preview');
            $table->string('content');
            $table->timestamps();
            $table->softDeletes(); // dilaravel 9 itu tdk menggunakan ini 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
