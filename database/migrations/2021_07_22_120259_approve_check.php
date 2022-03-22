<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApproveCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->integer('approved')->default('0');
        });
        Schema::table('books', function (Blueprint $table) {
            $table->integer('approved')->default('0');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('approved')->default('0');
        });
        Schema::table('publishers', function (Blueprint $table) {
            $table->integer('approved')->default('0');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->integer('approved')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
