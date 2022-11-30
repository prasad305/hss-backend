<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_user')->nullable()->comment('this is for star admin id');
            $table->unsignedBigInteger('created_by')->nullable()->comment('this is for creator or manager admin id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('this is for updated by');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country_code')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->longText('details')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('email_send_status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('password')->nullable();
            $table->integer('user_points')->nullable();
            $table->boolean('is_online')->default(0);
            $table->integer('active_status')->default(1)->comment('1 = active, 0 = inactive');
            $table->integer('status')->default(0)->comment('0= unapproved, 1 = approved');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
