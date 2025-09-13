<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->text('video_url'); // URL to the stored video
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            $table->foreign('candidate_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
