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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('credits', 20, 10)->default(0)->change();
        });

        Schema::table('credit_transactions', function (Blueprint $table) {
            $table->decimal('amount', 20, 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('credits')->default(0)->change();
        });

        Schema::table('credit_transactions', function (Blueprint $table) {
            $table->bigInteger('amount')->change();
        });
    }
};
