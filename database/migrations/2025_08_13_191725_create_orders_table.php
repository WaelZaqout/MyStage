<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total', 10, 2);
            $table->char('currency', 3)->default('SAR');
            $table->enum('status', ['pending','paid','failed','refunded','canceled'])->default('pending')->index();
            $table->string('payment_provider')->nullable(); // stripe/paypal/...
            $table->string('provider_ref')->nullable();     // رقم العملية
            $table->json('meta')->nullable();               // بيانات استرجاع/تفاصيل بوابة الدفع
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });


    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
