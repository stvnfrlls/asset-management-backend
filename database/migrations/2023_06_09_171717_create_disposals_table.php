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
        Schema::create('disposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->string('name');
            $table->unsignedBigInteger('department')->nullable();;
            $table->string('method');
            $table->string('trade_to')->nullable();
            $table->string('amount')->nullable();
            $table->string('reference')->nullable();
            $table->longText('description')->nullable();
            $table->string('purpose')->nullable();;
            $table->date('date');
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('asset_details')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposals');
    }
};
