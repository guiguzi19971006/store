<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_token_type_id');
            $table->string('content', 20);
            $table->dateTime('activated_time', $precision = 0);
            $table->dateTime('expiration_time', $precision = 0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_token_type_id')->references('id')->on('user_token_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tokens');
    }
}
