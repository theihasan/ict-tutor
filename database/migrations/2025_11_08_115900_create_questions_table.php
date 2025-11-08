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
        Schema::create("questions", function (Blueprint $table) {
            $table->id();
            $table->foreignId("chapter_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("topic_id")
                ->nullable()
                ->constrained()
                ->onDelete("set null");
            $table->text("question");
            $table->text("question_en")->nullable();
            $table->json("options");
            $table->char("correct_answer", 1);
            $table->text("explanation")->nullable();
            $table->string("type")->default("mcq");
            $table->integer("difficulty_level")->default(1);
            $table->integer("marks")->default(1);
            $table->json("tags")->nullable();
            $table->boolean("is_active")->default(true);
            $table->integer("usage_count")->default(0);
            $table->decimal("success_rate", 5, 2)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("questions");
    }
};
