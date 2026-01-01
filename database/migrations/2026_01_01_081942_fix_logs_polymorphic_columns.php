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
        Schema::table('logs', function (Blueprint $table) {
            $table->string('loggable_type')->nullable()->after('loggable_id');
            $table->dropColumn('loggable_name'); // remove the old incorrect column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->string('loggable_name')->after('loggable_id');
            $table->dropColumn('loggable_type');
        });
    }
};
