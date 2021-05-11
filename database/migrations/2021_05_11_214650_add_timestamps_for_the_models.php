<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsForTheModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('publishers', function (Blueprint $table) {
            $table->timestamps();
        });
        
        Schema::table('tags', function (Blueprint $table) {
            $table->timestamps();
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
            $table->dropTimestamps();
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        
        Schema::table('tags', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
