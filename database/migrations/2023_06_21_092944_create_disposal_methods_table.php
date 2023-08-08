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
        Schema::create('disposal_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('disposals', function (Blueprint $table) {
            $table->unsignedBigInteger('method')->change();
            $table->foreign('method')->references('id')->on('disposal_methods')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposal_methods');
    }
};
