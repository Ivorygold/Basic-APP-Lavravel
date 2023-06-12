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

    public function EditBlog($id) {
      $blogs = Blog::findOrFail($id);
      $categories = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blog.blogs_edit', compact('blogs','categories'));

    }//end method

    public function UpdateBlog(Request $request) {
    //access the DB
    $blog_id = $request->id;

    if ($request->file('blog_image')) {
        $image = $request->file('blog_image');
        $name_gen = hexdec(uniqid()).'.'.$image ->
         getClientOriginalExtension();

        //use image maker to resize
        Image::make($image)->resize(430, 327)->save('upload/blogImages/'.$name_gen);
        //save in  DB
        $save_url = 'upload/blogImages/'.$name_gen;

        //access our DB id
        Blog::findOrFail($blog_id)->update([
          'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' =>$save_url,
            'updated_at' => Carbon::now(),


        ]);

        $notification = array(
          'message' => 'Blog Post Updated with Image Successfully',
          'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);

    } else {

      Blog::findOrFail($blog_id)->update([
          'blog_category_id' => $request->blog_category_id,
          'blog_title' => $request->blog_title,
          'blog_tags' => $request->blog_tags,
          'blog_description' => $request->blog_description,

          ]);

        $notification = array(
          'message' => 'Blog Post Updated without Image Successfully',
          'alert-type' => 'success'
        );
        return redirect()->route('all.blog')->with($notification);


    }
}//end method

public function DeleteBlog($id) {

  $blogs =  Blog::findOrFail($id);
              $img = $blogs->blog_image;
              unlink($img);

              Blog::findOrFail($id)->delete();

              $notification = array(
                'message' => 'Blog Image Deleted Successfully',
                'alert-type' => 'success' 
              );
            return redirect()->back()->with($notification);

}//end method

public function BlogDetails($id) {

  $allBlogs = Blog::latest()->limit(5)->get();
  $categories = BlogCategory::orderBy('blog_category','ASC')->get();
  $blogs = Blog::findOrFail($id);
  return view('frontend.blog_details', compact('blogs','allBlogs','categories'));

}//end method

public function CategoryBlog($id) {
  //when our blog_category_id match our request id then get blog category related data

  $CategoryBlogPost = Blog::where('blog_category_id',$id)->orderBy('id','DESC')->get();
  $allBlogs = Blog::latest()->limit(5)->get();
  $categories = BlogCategory::orderBy('blog_category','ASC')->get();
  $categoryName = BlogCategory::findOrFail($id);
  return view('frontend.cat_blog_details',compact('CategoryBlogPost','allBlogs','categories','categoryName'));

}//end method

public function HomeBlog() {

  $allBlogs = Blog::latest()->paginate(2);
  $categories = BlogCategory::orderBy('blog_category','ASC')->get();
  return view('frontend.blog',compact('allBlogs','categories'));

}//end method


    
}
