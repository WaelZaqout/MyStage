<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model'); // model_type / model_id (course, lesson, profile, ...)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // من رفع الملف
            $table->string('path');
            $table->string('disk')->default('public');
            $table->enum('type', ['image','video','document','audio','other'])->default('other')->index();
            $table->unsignedBigInteger('size')->default(0);
            $table->json('meta')->nullable(); // duration, mime, width/height...
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('media');
    }
};
