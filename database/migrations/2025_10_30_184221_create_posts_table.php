<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('caption');
            $table->string('picture')->nullable();
            $table->string('type')->nullable();
            $table->enum('status', ['active', 'reported', 'archived'])->default('active');
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('reports_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id');
        });

        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->unique(['user_id', 'post_id']);
            $table->timestamps();
        });

        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
            $table->unique(['user_id', 'post_id']);
            $table->index(['user_id', 'post_id']);
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('post_likes');
        Schema::dropIfExists('post_reports');
        Schema::dropIfExists('posts');
    }
};
