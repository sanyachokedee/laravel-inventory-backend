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
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();  // id primiary key+ auto incrememt
            $table->string('fullname');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // เมื่อมีการยืนยันตัวตนเองเวลาบันทึกที่ได้ยืนยัน
            $table->string('password');
            $table->string('tel');
            $table->string('avatar')->nullable();   // nullable เป็นค่าว่างได้
            $table->tinyInteger('role')->default(2);  //ถ้าไม่ได้ระบุมาให้เป็นเลข 2=user ทั่วไป 1=admin
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
