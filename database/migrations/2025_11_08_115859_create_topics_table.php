<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("topics", function (Blueprint $table) {
            $table->id();
            $table->foreignId("chapter_id")->constrained()->onDelete("cascade");
            $table->string("name");
            $table->string("name_en")->nullable();
            $table->text("description")->nullable();
            $table->string("type")->default("theory");
            $table->integer("order")->default(0);
            $table->integer("difficulty_level")->default(1);
            $table->boolean("is_active")->default(true);
            $table->json("learning_objectives")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("topics");
    }
};
