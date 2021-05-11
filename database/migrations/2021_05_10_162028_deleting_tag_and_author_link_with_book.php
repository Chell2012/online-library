<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletingTagAndAuthorLinkWithBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books_authors', function (Blueprint $table) {
            $table->dropForeign('books_authors_book_id_foreign');
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
        });
        Schema::table('books_tags', function (Blueprint $table) {
            $table->dropForeign('books_tags_book_id_foreign');
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books_authors', function (Blueprint $table) {
            $table->dropForeign('books_authors_book_id_foreign');
            $table->foreign('book_id')->references('id')->on('books');
        });
        Schema::table('books_tags', function (Blueprint $table) {
            $table->dropForeign('books_tags_book_id_foreign');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }
}
