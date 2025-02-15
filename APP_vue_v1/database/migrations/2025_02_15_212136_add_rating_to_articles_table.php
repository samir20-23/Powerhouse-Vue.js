<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add the rating column (make sure it does not conflict if it already exists)
            $table->integer('rating')->default(0)->after('body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Remove the rating column if needed
            $table->dropColumn('rating');
        });
    }
}
