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
        Schema::table('documents', function (Blueprint $table) {
            $table->timestamp('is_checked')->nullable(true);
            $table->text('url_view')->nullable();
            $table->string('number')->nullable();
            $table->text('issued_whom')->nullable();
            $table->string('it_works_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('url_view');
            $table->dropColumn('number');
            $table->dropColumn('issued_whom');
            $table->dropColumn('it_works_date');

        });
    }
};
