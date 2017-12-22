<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChinaTelecomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('china_telecoms', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigInteger('key');
            $table->bigInteger('sid');
            $table->bigInteger('nid');
            $table->bigInteger('bid');
            $table->double('lat');
            $table->double('lon');
            $table->bigInteger('radius');
            $table->jsonb('more_info')->nullable();
            $table->timestamp('data_refresh_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index(['key', 'sid', 'nid', 'bid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('china_telecoms');
    }
}
