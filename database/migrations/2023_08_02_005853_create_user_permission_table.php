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
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('asset_create');
            $table->string('asset_update');
            $table->string('asset_transfer');
            $table->string('asset_device');
            $table->string('asset_dispose');
            $table->string('asset_download');
            $table->string('dashboard');
            $table->string('license_create');
            $table->string('license_update');
            $table->string('license_delete');
            $table->string('asset_upload');
            $table->string('view_logs');
            $table->string('dev_tools');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permission');
    }
};
