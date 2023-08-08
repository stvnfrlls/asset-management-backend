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
        Schema::create('asset_details', function (Blueprint $table) {
            $table->id();
            $table->string('asset_no');
            $table->string('img_url')->nullable();
            $table->unsignedBigInteger('classification');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('asset_type')->nullable();
            $table->unsignedBigInteger('manufacturer')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('model')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_details');
    }
};
