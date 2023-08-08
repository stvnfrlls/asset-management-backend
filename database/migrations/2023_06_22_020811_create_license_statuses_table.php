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
        Schema::create('license_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('licensings', function (Blueprint $table) {
            $table->unsignedBigInteger('status')->change();
            $table->foreign('status')->references('id')->on('license_statuses')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_statuses');
    }
};
