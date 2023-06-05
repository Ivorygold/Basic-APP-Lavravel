<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Carbon;
use Image;

class BlogController extends Controller
{
    public function AllBlog() {

        $blogs = Blog::latest()->get();
        return view('admin.blog.blogs_all', compact('blogs'));

    }// end method

    public function AddBlog() {
        return view('admin.blog.blogs_add');

    }// end method
    
}
