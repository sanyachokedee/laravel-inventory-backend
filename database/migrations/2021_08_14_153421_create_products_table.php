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
            $table->increments('id'); //int 10 หลัก
            $table->string('name'); 
            $table->string('slug'); //ชื่อบทความเช่น my-iphone-201
            $table->string('description')->nullable();  //nullable คือ ไม่ระบุได้
            $table->decimal('price',9,2); // 125.75
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
