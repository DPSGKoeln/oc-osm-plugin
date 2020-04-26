<?php namespace Zoomyboy\Osm\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePointCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('zoomyboy_osm_point_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zoomyboy_osm_point_categories');
    }
}
