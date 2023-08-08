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
        Schema::create('location_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('site')->nullable();
            $table->string('area')->nullable();
            $table->string('responsible')->nullable();
            $table->unsignedBigInteger('department')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')->references('id')->on('asset_details')->onDelete('no action');
            $table->foreign('department')->references('id')->on('departments')->onDelete('no action');
            $table->foreign('role_id')->references('id')->on('user_roles')->onDelete('no action');
            $table->foreign('status_id')->references('id')->on('status_types')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_details');
    }
};
