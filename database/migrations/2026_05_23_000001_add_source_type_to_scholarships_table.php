<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            // 'api' = synced from CHED/DOST/LGU, 'manual' = added by admin
            $table->enum('source_type', ['api', 'manual'])->default('api')->after('source_url');
            // Organization name for manual entries (e.g. "SM Foundation", "Globe Telecom")
            $table->string('organization_name')->nullable()->after('source_type');
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'organization_name']);
        });
    }
};