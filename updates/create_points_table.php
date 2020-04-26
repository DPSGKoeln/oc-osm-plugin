<?php namespace Zoomyboy\Osm\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePointsTable extends Migration
{
    public function up()
    {
        Schema::create('zoomyboy_osm_points', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->string('href');
            $table->string('icon');
            $table->integer('category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zoomyboy_osm_points');
    }
}
