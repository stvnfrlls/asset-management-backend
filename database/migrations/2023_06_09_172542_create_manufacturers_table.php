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
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer_name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('asset_details', function (Blueprint $table) {
            $table->foreign('manufacturer')->references('id')->on('manufacturers')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturers');
    }
};
