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
        Schema::create('device_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('license_id')->nullable();
            $table->unsignedBigInteger('documentsuite_id')->nullable();
            $table->unsignedBigInteger('component_id')->nullable();
            $table->string('processor')->nullable();
            $table->string('category')->nullable();
            $table->string('os_prior_license_key')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')->references('id')->on('asset_details')->onDelete('no action');
            $table->foreign('license_id')->references('id')->on('licensings')->onDelete('no action');
            $table->foreign('documentsuite_id')->references('id')->on('licensings')->onDelete('no action');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_specs');
    }
};
