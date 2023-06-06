<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
;
use Illuminate\Support\Carbon;
use Image;

class BlogController extends Controller
{
    public function AllBlog() {

        $blogs = Blog::latest()->get();
        return view('admin.blog.blogs_all', compact('blogs'));

    }// end method

    public function AddBlog() {
        //to get the blog category from a different database table, we import the model first, declare a variable the access te table using its unique name.
        
        $categories = BlogCategory::orderBy('blog_category','ASC')->get();

        //parse the  fetched data above in our add blogs page using compact.
        return view('admin.blog.blogs_add',compact('categories')) ;

    }// end method

    public function StoreBlog(Request $request) {
        $request->validate([
            'blog_category_id' =>' Required',
            'blog_title' =>' Required',
            'blog_image' =>' Required',
            'blog_tags' =>' Required',
        ],[
                                             //to infuse a custom message
       'blog_category_id.Required'=>'blog id Name is Required',  
       'blog_title.Required'=>'blog Title is Required',    
      'blog_image.Required'=>'blog Image is Required',    
      'blog_tags.Required'=>'blog tag is Required',                                 

        ]);

        $image = $request->file('blog_image');
         $name_gen = hexdec(uniqid()).'.'.$image ->
          getClientOriginalExtension();

          //use image maker to resize
          Image::make($image)->resize(430,327)->save('upload/blogImages/'.$name_gen);
          //save in  DB
          $save_url = 'upload/blogImages/'.$name_gen;

          //access our DB id
          Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' =>$save_url,
            'created_at' => Carbon::now(),

          ]);

          $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success'
          );
          return redirect()->route('all.blog')->with($notification);


    }// end method
    
}
