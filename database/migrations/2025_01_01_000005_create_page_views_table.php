<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('ip_hash', 64);
            $table->string('user_agent')->nullable();
            $table->timestamp('visited_at')->useCurrent();
        });

        Schema::table('page_views', function (Blueprint $table) {
            $table->index(['path', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
