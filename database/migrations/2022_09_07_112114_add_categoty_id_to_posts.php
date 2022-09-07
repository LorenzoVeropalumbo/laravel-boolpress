<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategotyIdToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Creamo la colonna category_id
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            // Aggiunta della relazione
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('set null');
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
            
            // Rimuovo la foreign key
            $table->dropForeign('posts_category_id_foreign');
            
            // Rimuovo la colonna
            $table->dropColumn('category_id');
        });
    }
}
