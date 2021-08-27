<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id primiary key+ auto incrememt
            $table->string('name'); 
            $table->string('slug'); //ชื่อบทความเช่น my-iphone-201
            $table->string('description')->nullable();  //nullable คือ ไม่ระบุได้
            $table->decimal('price',9,2); // 1,458,925.75 รวมได้ 9 หลัก
            $table->string('image')->nullable(); // รูปภาพ ไม่ระบุก็ได้
            $table->unsignedBigInteger('user_id')->comment('Created by user');   // ->comment คือ ระบุให้อ่าน
            $table->foreign('user_id')->references('id')->on('users');  // foreign key อ้างอิงจาก tablue user field id
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
        Schema::dropIfExists('products');
    }
}
