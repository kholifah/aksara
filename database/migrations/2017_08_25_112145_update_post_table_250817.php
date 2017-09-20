<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePostTable250817 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('posts', function (Blueprint $table) {
                    $table->text('post_slug')->after('post_title');
                    $table->longText('post_content')->after('post_slug');
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
                    $table->dropColumn('post_slug');
                    $table->dropColumn('post_content');
                });
    }
}
