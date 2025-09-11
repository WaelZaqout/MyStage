<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->enum('access_type', ['purchase','subscription','voucher'])->default('purchase')->index();
            $table->enum('status', ['active','canceled','expired','pending'])->default('active')->index();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id','course_id']); // مستخدم لا يلتحق بنفس الدورة مرتين
        });
    }
    public function down(): void {
        Schema::dropIfExists('enrollments');
    }
};
