<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('plans', function (Blueprint $table) {
            // ربط مع Stripe
            $table->string('stripe_price_id')->nullable()->index()->after('features');

            // حدود الاستخدام
            $table->integer('max_videos')->nullable()->after('stripe_price_id');
            $table->integer('max_courses')->nullable()->after('max_videos');
            $table->integer('max_files')->nullable()->after('max_courses');
        });
    }

    public function down(): void {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['stripe_price_id', 'max_videos', 'max_courses', 'max_files']);
        });
    }
};
