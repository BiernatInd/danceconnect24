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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone_number');
            $table->enum('sex', ['men', 'women']); // Enum dla płci
            $table->enum('sign_up_type', ['group', 'one_off']); // Czy dołączył do grupy
            $table->string('classes_id'); // Enum dla roli
            $table->string('user_id')->nullable();
            $table->string('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders'); // Usuwamy tabelę 'classes'
    }
};
