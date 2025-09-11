<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name')->nullable(); // في حال ليست مرتبطة بمستخدم
            $table->string('author_role')->nullable(); // طالب/معلم...
            $table->tinyInteger('rating')->nullable();
            $table->text('body');
            $table->boolean('featured')->default(false)->index();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('testimonials');
    }
};
