<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePressReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('press_releases', function (Blueprint $table) {
            $table->id();
            $table->string('title_en',255);
            $table->string('slug_en',255)->unique();
            $table->string('title_ar',255)->nullable();
            $table->string('slug_ar',255)->nullable();
            $table->string('excerpt_en',1000)->nullable();
            $table->string('excerpt_ar',1000)->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_ar')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->boolean('is_published')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('press_releases');
    }
}
