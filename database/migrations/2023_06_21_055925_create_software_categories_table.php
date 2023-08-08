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
        Schema::create('software_categories', function (Blueprint $table) {
            $table->id();
            $table->string('software_category');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('licensings', function (Blueprint $table) {
            $table->unsignedBigInteger('category')->change();
            $table->foreign('category')->references('id')->on('software_categories')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_categories');
    }
};
