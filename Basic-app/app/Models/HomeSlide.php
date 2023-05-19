<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    use HasFactory;

    //by using guarded it make all fills to be nullable and it also represent all fillable in one line
    protected $guarded = [];

    //here is a separated fillable as against the protected guarded above in one line
    // protected $fillable = [
    //     'title',
    //     'short_title',
    //     'home_slide',
    //     'video_url',
    // ];
}
