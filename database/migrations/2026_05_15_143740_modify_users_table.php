<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('municipality', 100)->nullable()->after('email');
            $table->string('course', 100)->nullable()->after('municipality');
            $table->decimal('gwa', 4, 2)->nullable()->after('course');
            $table->tinyInteger('year_level')->nullable()->after('gwa');
            $table->boolean('is_admin')->default(false)->after('year_level');
            $table->boolean('email_notifications')->default(true)->after('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'municipality',
                'course',
                'gwa',
                'year_level',
                'is_admin',
                'email_notifications',
            ]);
        });
    }
};