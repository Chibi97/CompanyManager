<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsConditions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcementsConditions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('condition_id');
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->unsignedInteger('announcement_id');
            $table->foreign('announcement_id')->references('id')->on('announcements');
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
        Schema::dropIfExists('announcementsConditions');
    }
}
