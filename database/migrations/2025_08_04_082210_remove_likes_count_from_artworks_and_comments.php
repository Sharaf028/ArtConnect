<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->integer('likes_count')->default(0)->after('category');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->integer('likes_count')->default(0)->after('content');
        });
    }
};
