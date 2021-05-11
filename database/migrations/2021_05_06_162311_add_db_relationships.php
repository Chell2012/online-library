<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDbRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('publisher_id')->change();
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->unsignedBigInteger('category_id')->change();
            $table->foreign('category_id')->references('id')->on('categories');
        });
        Schema::table('books_authors', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->change();
            $table->foreign('book_id')->references('id')->on('books');
            $table->unsignedBigInteger('author_id')->change();
            $table->foreign('author_id')->references('id')->on('authors');
        });
        Schema::table('books_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->change();
            $table->foreign('book_id')->references('id')->on('books');
            $table->unsignedBigInteger('tag_id')->change();
            $table->foreign('tag_id')->references('id')->on('tags');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign('books_publisher_id_foreign');
            $table->dropForeign('books_category_id_foreign');
        });
        Schema::table('books_authors', function (Blueprint $table) {
            $table->dropForeign('books_authors_book_id_foreign');
            $table->dropForeign('books_authors_author_id_foreign');
        });
        Schema::table('books_tags', function (Blueprint $table) {
            $table->dropForeign('books_tags_book_id_foreign');
            $table->dropForeign('books_tags_tag_id_foreign');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign('tags_category_id_foreign');
        });
    }
}
