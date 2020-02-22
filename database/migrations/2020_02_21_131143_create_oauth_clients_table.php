<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("client_id")->nullable(false)->unique();
            $table->string("client_secret")->nullable(false);
            $table->integer("access_token_validity")->nullable(false);
            $table->integer("refresh_token_validity")->nullable(false);
            $table->string("web_server_redirect_uri")->nullable(true);
            $table->string("additional_information")->nullable(true);
            $table->string("app_key")->nullable(false);
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
        Schema::dropIfExists('oauth_clients');
    }
}
