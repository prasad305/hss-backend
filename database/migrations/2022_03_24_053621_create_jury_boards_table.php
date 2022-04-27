<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuryBoardsTable extends Migration
{


    public function up()
    {
        Schema::create('jury_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('star_id');
            $table->unsignedBigInteger('manager_admin_id');
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->text('terms_and_condition')->nullable();
            $table->text('description')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('image')->nullable();
            $table->string('agreement')->nullable();
            $table->boolean('status')->default(0)->comment('0 = active , 1 = deactive');
            $table->timestamps();
        });
    }
}
