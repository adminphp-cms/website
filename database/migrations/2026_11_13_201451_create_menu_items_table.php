<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->jsonb('title');
            $table->string('url')->nullable();
            $table->boolean('opens_in_new_tab')->default(false);
            $table->position();
            $table->nesting();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
