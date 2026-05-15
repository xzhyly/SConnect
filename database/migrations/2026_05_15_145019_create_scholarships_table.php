<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('provider');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->decimal('minimum_gwa', 4, 2)->nullable();
            $table->string('required_course')->nullable();
            $table->string('municipality')->nullable();
            $table->text('benefits')->nullable();
            $table->string('application_link')->nullable();
            $table->string('source_url')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};