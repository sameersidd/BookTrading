<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_user_id');
            $table->integer('to_user_id');
            $table->integer('trading_book_id');
            $table->integer('for_book_id')->nullable();
            $table->enum('status', ['offered', 'accepted', 'declined', 'deleted']);
            $table->timestamps();

            $table->foreign('from_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('to_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('trading_book_id')
                ->references('id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('for_book_id')
                ->references('id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_offers');
    }
}
