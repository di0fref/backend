<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('folder_id')->default(0);
            $table->text('text')->nullable();
            $table->boolean('bookmark')->default(0);
            $table->boolean('locked')->default(0);
            $table->boolean('deleted')->default(0);
            $table->string("user_id")->default(0);
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
        Schema::dropIfExists('notes');
    }
}
