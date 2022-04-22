<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listenings', function (Blueprint $table) {
            $table->id();
            $table->string("user_id")->index("user_id");//this will be Auth user
            $table->string("artist_id")->index("artist_id");
            $table->string("spotify_track_id")->index("spotify_track_id");
            $table->string("track_name")->nullable();
            $table->string('played_at')->default("none");

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
        Schema::dropIfExists('listenings');
    }
}
