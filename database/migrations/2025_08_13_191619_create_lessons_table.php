<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->unsignedInteger('duration_sec')->default(0);
            $table->boolean('free_preview')->default(false);
            $table->enum('content_type', ['video','file','quiz','live','article'])->default('video');
            $table->string('video_path')->nullable();   // مسار فيديو داخلي/خارجي
            $table->string('file_path')->nullable();    // مرفق
            $table->longText('body')->nullable();       // مقالة/وصف/نص الدرس
            $table->timestamp('live_starts_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['course_id','slug']);
            $table->index(['course_id','sort_order']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('lessons');
    }
};
