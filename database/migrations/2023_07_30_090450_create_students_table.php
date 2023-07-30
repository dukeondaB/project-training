<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('avatar')->nullable();
            $table->date('birth_day');
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->timestamps();
            $table->softDeletes(); // Thêm cột deleted_at cho Soft Deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
