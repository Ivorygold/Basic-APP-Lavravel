<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = [];

    //to create a relationship between id's of different tables in our DB
    public function category() {
        //using this, belongTo and class keyword to match the appropriate id
        return $this->belongsTo(BlogCategory::class,'blog_category_id','id');
    }
}
