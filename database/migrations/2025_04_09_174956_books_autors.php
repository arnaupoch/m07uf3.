<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(table: 'books_autors', callback: function (Blueprint $table): void {
            $table->unsignedBigInteger(column: 'books_id');
            $table->unsignedBigInteger(column: 'autors_id');
            $table->timestamps();
            
            $table->foreign(columns: 'books_id')->references(columns: 'id')->on(table: 'books')->onDelete(action: 'cascade');
            $table->foreign(columns: 'autors_id')->references(columns: 'id')->on(table: 'autors')->onDelete(action: 'cascade');
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists(table: 'books_autors');
    }
};

