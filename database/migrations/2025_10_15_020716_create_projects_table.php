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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150); // Short, indexed title
            $table->text('description'); // Longer text for project details
            $table->string('tech_stack', 255)->nullable(); // Optional, e.g. "Vue, Laravel, MySQL"
            $table->string('demo_link')->nullable(); // Optional link to live demo
            $table->string('github_link')->nullable(); // Optional link to GitHub repo
            $table->string('image')->nullable(); // Path or URL to image
            $table->boolean('is_featured')->default(false); // Boolean instead of string for true/false
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
