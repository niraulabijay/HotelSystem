<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id(); $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->longText('description')->nullable();
            $table->integer('no_of_guest')->nullable()->unsigned();
            $table->integer('price')->nullable()->unsigned();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_types');
    }
}
