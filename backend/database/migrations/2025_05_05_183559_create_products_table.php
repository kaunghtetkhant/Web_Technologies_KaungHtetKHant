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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_no');
            $table->double('price')->default(0.0);
            $table->double('discount')->nullable();
            $table->integer('qty');
            $table->string('logo');
            $table->longText('description')->nullable();
            $table->integer('rating')->default(0);
            $table->foreignIdFor(\App\Models\Subcategory::class);
            $table->foreignIdFor(\App\Models\Brand::class);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
