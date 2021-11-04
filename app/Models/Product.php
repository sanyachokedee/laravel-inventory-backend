<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'user_id'
    ];

    /**
     * Relationship to Users
     */
    public function users()
    {
        // มาจาก 
        // SELECT *
        // FROM products
        // INNER JOIN users
        // ON products.user_id = users.id;
        // return $this->belongsTo('App\Models\User','user_id');  // ที่ userไม่ได้ระบุว่าเป็น id เพราะถือว่าถ้าเป็น id ก็รู้กัน
        return $this->belongsTo('App\Models\User','user_id')->select(['id','fullname','avatar']); // เอาเฉพาะ field ที่ต้องการ

    }
}