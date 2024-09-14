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
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // Kolumna id (auto-incremental primary key)
            $table->string('class_name'); // Kolumna class_name typu string
            $table->string('markings'); // Kolumna markings typu string
            $table->enum('class_type', ['women', 'men', 'mixed']); // Kolumna class_type jako enum
            $table->integer('places'); // Kolumna places typu integer
            $table->integer('room'); // Kolumna room typu integer
            $table->string('instructor'); // Kolumna instructor typu string
            $table->date('date'); // Kolumna date typu date
            $table->time('time_start'); // Kolumna time_start typu time
            $table->time('time_end'); // Kolumna time_end typu time
            $table->string('price');
            $table->timestamps(); // Kolumny created_at i updated_at (opcjonalnie, jeśli potrzebujesz)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes'); // Usuwamy tabelę 'classes'
    }
};
