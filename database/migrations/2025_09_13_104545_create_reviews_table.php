<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('score')->nullable(); // e.g., 1-5
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('submission_id');
            $table->timestamps();

            $table->foreign('reviewer_id')->references('id')->on('users');
            $table->foreign('submission_id')->references('id')->on('submissions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
