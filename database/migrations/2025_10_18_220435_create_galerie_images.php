<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galerie_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('galerie_id');
            $table->string('image'); // chemin de l'image
            $table->string('description')->nullable(); // optionnel
            $table->timestamps();
            $table->foreign('galerie_id')->references('id')->on('galeries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerie_images');
    }
};
