<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityFeatureUserStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_feature_user_story', function (Blueprint $table) {
            $table->unsignedBigInteger('secfeature_id');
            $table->unsignedBigInteger('user_story_id');
            $table->foreign('secfeature_id')->references('id')->on('security_features')->onDelete('cascade');
            $table->foreign('user_story_id')->references('id')->on('user_stories')->onDelete('cascade');
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
        Schema::dropIfExists('security_feature_user_story');
    }
}
