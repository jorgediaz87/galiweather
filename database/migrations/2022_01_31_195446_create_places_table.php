<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('municipality');
            $table->enum('province', ['A Coruña', 'Lugo', 'Ourense', 'Pontevedra']);
            $table->float('latitude', 12, 6);
            $table->float('longitude', 12, 6);
            $table->enum('type', ['beach', 'locality']);
        });

        Schema::table('places', function (Blueprint $table) {
            $table->foreignId('port_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('reference_port_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['port_id']);
            $table->dropForeign(['reference_port_id']);
        });

        Schema::dropIfExists('places');
    }
}
