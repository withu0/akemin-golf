<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();      // hero, about, beauty, future, global, life_intro, join
            $table->string('eyebrow')->nullable(); // small English label
            $table->json('title')->nullable();
            $table->json('lead')->nullable();       // short intro / subtitle
            $table->json('body')->nullable();       // long form (paragraphs separated by blank lines)
            $table->json('extra')->nullable();      // arbitrary structured data (lists, quotes)
            $table->string('image')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
