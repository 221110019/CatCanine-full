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
<<<<<<< Updated upstream
<<<<<<< HEAD
            $table->string('type')->nullable();
=======
>>>>>>> bd61f0cefcf520b4ea6cd7199fba02ccde41c8bc
=======
            $table->string('type')->nullable();
>>>>>>> Stashed changes
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('reports_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
