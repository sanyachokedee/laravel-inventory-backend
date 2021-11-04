<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Read all product
        // return Product::all(); // อ่านทั้งหมด

        //อ่านข้อมูลแบบแบ่งหน้า
        // return Product::orderBy('id','desc')->paginate(25);  //แบบเดิมได้ได้ inner users
        return Product::with('users','users')->orderBy('id','desc')->paginate(25);

        //ทดสอบ role ด้วย ability

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //ทดสอบ role ด้วย ability = 1 เช็คสิทธิ์ก่อน
    public function store(Request $request)
    {
        
        // เช็คสิทธิ์ (Role) ว่าเป็น admin(1)
        $user = auth()->user();
        // $user->tokenCan = 1;
        
        if($user->tokenCan("1")){   
            // return Product::create($request->all());
            // return response($request->all(),201);

            //ตรวจสอบว่ามีข้อมูลมาหรือไม่ https://laravel.com/docs/8.x/validation#introduction
            // Validate form
            $request->validate([
                'name' => 'required|min:3',
                'slug' => 'required',
                'price' => 'required'
            ]);                    
            
            // กำหนดตัวแปรรับค่าจากฟอร์ม
            $data_product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            // รับไฟล์ภาพเข้ามา
            $image = $request->file('file');

            // เช็คว่าผู้ใช้มีการอัพโหลดภาพเข้ามาหรือไม่ ?
            if(!empty($image)){

                // อัพโหลดรูปภาพ
                // เปลี่ยนชื่อรูปที่ได้
                $file_name = "product_".time().".".$image->getClientOriginalName();

                // กำหนดขนาดกว้าง และสูง ของภาพที่ต้องการย่อขนาด
                $imgWidth = 400;
                $imgHeight= 400;
                $folderupload = public_path('/images/products/thumbnail');
                $path = $folderupload."/".$file_name;

                // อัพโหลดเข้าสู่ folder thumbnail
                $img = Image::make($image->getRealPath());
                $img->orientate()->fit($imgWidth,$imgHeight, function($constraint){
                    $constraint->upsize();
                });
                $img->save($path);

                // อัพโหลดภาพต้นฉบับเข้า folder original
                $destinationPath = public_path('/images/products/original');
                    // move() เป็นของ laravel คือ เอาภาพไปเก็บไว้ที่ระบุ (ที่เก็บ,ชื่อไฟล์)
                $image->move($destinationPath,$file_name);

                // กำหนด path รูปเพื่อใส่ตารางในฐานข้อมูล
                // url('/') อ่าน path ของ project ที่ทำงานอยู่ http://localhost/ ถ้าไม่เจอภาพให้ระบุไว้เป็นแบบนี้ no_img.jpg
                $data_product['image'] = url('/').'/images/products/thumbnail/'.$file_name;

            }else{
                $data_product['image'] = url('/').'/images/products/thumbnail/no_img.jpg';
            }
            // Create data to tabale product
            return Product::create($data_product);
        }
        else
        {
            return [
                'status' => 'Permission denied to create',
            ];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // เช็คสิทธิ์ (Role) ว่าเป็น admin(1)
        $user = auth()->user();

        if ($user->tokenCan("1"))
        {
            // $product = Product::find($id);
            // $product->update($request->all());

            // return $product;

            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required'
            ]);

            $data_product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            // รับภาพเข้ามา
            $image = $request->file('file');
            if (!empty($image)) {

                $file_name = "product_" . time() . "." . $image->getClientOriginalExtension();
                
                $imgwidth = 400;
                $imgHeight = 400;
                $folderupload = public_path('/images/products/thumbnail');
                $path = $folderupload . '/' . $file_name;

                // uploade to folder thumbnail
                $img = Image::make($image->getRealPath());
                $img->orientate()->fit($imgwidth, $imgHeight, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($path);

                // uploade to folder original
                $destinationPath = public_path('/images/products/original');
                $image->move($destinationPath, $file_name);

                $data_product['image'] = url('/').'/images/products/thumbnail/'.$file_name;

            }

            $product = Product::find($id);
            $product->update($data_product);

            return $product;

        }
        else
        {
            return [
                'status' => 'Permission denied to create',
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        // เช็คสิทธิ์ (role) ว่าเป็น admin (1) 
        $user = auth()->user();

        if($user->tokenCan("1")){
            return Product::destroy($id);
        }else{
            return [
                'status' => 'Permission denied to create'
            ];
        }
    }

    /**
     *  Search ชื่อจาก ฟอร์มค้นหา
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
    */
    public function search($keyword)
    {
        return Product::with('users','users')
                ->where('name','like','%'.$keyword.'%')
                ->orderBy('id','desc')
                ->paginate(25);
                // SELECT * FROM products INNER JOIN users 
                // ON (products.user_id=users.id) 
                // WHERE products.name like '%sam%' 
                // ORDER BY products.id DESC LIMIT 0,25
        }
                
}