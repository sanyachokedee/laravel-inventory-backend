<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('menu_head', function () {
    // return "menu_head";
    // return view('menu_head',['name' => 'James']);  // view show james passed
    // $data = Product::all();
    // $header = DB::table('Products')->find(4); // work array[] user $footer->name
    // $footer = DB::table('Products')->find(6); // work array[] use $footer->slug
    // $header = DB::table('Products')->where('id',4)->get();   not work

    $header = DB::table('Products')->where('id',4)->value('name'); // work return value
    $footer = DB::table('Products')->where('id',6)->value('slug'); // work return value  
    echo $header;
        echo "<br>";
        // print_r $header;

    return view('menu_head',
    [
        'header'=>$header,
        'footer'=>$footer
    ]);
        
});