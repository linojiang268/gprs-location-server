<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChinaMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('china_mobiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('key');
            $table->bigInteger('lac');
            $table->bigInteger('cell_id');
            $table->double('lat');
            $table->double('lon');
            $table->bigInteger('radius');
            $table->jsonb('more_info')->nullable();
            $table->timestamp('data_refresh_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index(['key', 'lac', 'cell_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('china_mobiles');
    }
}
