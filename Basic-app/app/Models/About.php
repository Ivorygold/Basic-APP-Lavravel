<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    //when we use protected $guarded, we dont need to individually declare our table names to be migrated
    protected $guarded = [];
}
