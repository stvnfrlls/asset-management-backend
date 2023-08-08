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
        Schema::create('transfer_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('from')->nullable();
            $table->string('site')->nullable();
            $table->string('area')->nullable();
            $table->string('responsible')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->date('transferred_date')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('asset_id')->references('id')->on('asset_details')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_lists');
    }
};
