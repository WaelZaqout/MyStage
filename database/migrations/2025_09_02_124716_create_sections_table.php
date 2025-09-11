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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // مثال: مقدمة، مواضيع متقدمة
            $table->string('slug')->nullable(); // اختياري لو حاب تستخدم سلاك
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();


            $table->unique(['course_id', 'title']); // منع التكرار داخل نفس الكورس
            $table->index(['course_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
