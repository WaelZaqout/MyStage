<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // مثال: الباقة الأساسية
            $table->enum('audience', ['student','teacher'])->default('student')->index();
            $table->enum('billing_period', ['monthly'])->default('monthly');
            $table->decimal('price', 10, 2);
            $table->char('currency', 3)->default('SAR');
            $table->json('features')->nullable(); // قائمة مزايا الخطة
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('plans');
    }
};
