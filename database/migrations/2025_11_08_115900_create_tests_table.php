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
        Schema::create("tests", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("name_en")->nullable();
            $table->text("description")->nullable();
            $table->string("type")->default("model_test");
            $table
                ->foreignId("chapter_id")
                ->nullable()
                ->constrained()
                ->onDelete("set null");
            $table->integer("duration_minutes");
            $table->integer("total_questions");
            $table->integer("total_marks");
            $table->decimal("pass_percentage", 5, 2)->default(40.0);
            $table->json("question_ids");
            $table->json("settings")->nullable();
            $table->boolean("is_active")->default(true);
            $table->boolean("is_featured")->default(false);
            $table->integer("attempts_count")->default(0);
            $table->decimal("average_score", 5, 2)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tests");
    }
};
