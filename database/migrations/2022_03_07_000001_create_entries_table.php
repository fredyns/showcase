<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->date('date')->nullable();
            $table->text('text')->nullable();
            $table->uuid('uuid');
            $table->string('file')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->boolean('bool')->nullable();
            $table->decimal('number', 5, 2)->nullable();
            $table->json('json')->nullable();

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
        Schema::dropIfExists('entries');
    }
};
