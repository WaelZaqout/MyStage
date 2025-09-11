<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->text('summary')->nullable();
            $table->enum('level', ['beginner','intermediate','advanced'])->default('beginner')->index();
            $table->string('language', 5)->default('ar');
            $table->decimal('price', 10, 2)->nullable(); // سعر الدورة الفردية
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->char('currency', 3)->default('SAR');
            $table->boolean('is_published')->default(false)->index();
            $table->string('cover')->nullable();
            $table->string('intro_video')->nullable();
            $table->unsignedInteger('total_minutes')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('courses');
    }
};
