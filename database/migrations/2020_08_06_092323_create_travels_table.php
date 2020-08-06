<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*@PrimaryKey(autoGenerate = true)
    var id: Long = 0L,
    @ColumnInfo(name = "origin_location_id")
    var originLocationId: Long,
    @ColumnInfo(name = "destination_location_id")
    var destinationLocationId: Long,
    @ColumnInfo(name = "distance")
    var distance: Double = 0.0,
    @ColumnInfo(name = "duration")
    var duration: Long = 0L,
    @ColumnInfo(name = "duration_text")
    var durationText: String*/
        Schema::create('travels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_location_id')->unsigned();
            $table->bigInteger('destination_location_id')->unsigned();
            $table->double('distance');
            $table->bigInteger('duration');
            $table->string('duration_text');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('origin_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('destination_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travels');
    }
}
