<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Carbon;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory() {
        //access the data base
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogcategory'));

    }//end Method

    public function AddBlogCategory() {
        return view('admin.blog_category.blog_category_add');
    }//end Method

    public function StoreBlogCategory(request $request) {

        $request->validate([
            'blog_category' =>' Required',
           
        ],[
                                             //to infuse a custom message
       'blog_category.Required'=>'Blog Category Name is Required',  
       
        ]);

        
          //access our DB id
          BlogCategory::insert([
            'blog_category' => $request->blog_category,
            'created_at' => Carbon::now(),

          ]);

          $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
          );
          return redirect()->route('all.blog.category')->with($notification);

    }//end Method

    public function EditBlogCategory($id){
        $blogcategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogcategory'));

    }//end Method

    public function UpdateBlogCategory(Request $request, $id) {

        //access our DB id
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
            'updated_at' => Carbon::now(),

          ]);

          $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
          );
          return redirect()->route('all.blog.category')->with($notification);

    }//end Method

    public function DeleteBlogCategory($id) {
       
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
          'message' => 'Blog Category Deleted Successfully',
          'alert-type' => 'success' 
        );
          return redirect()->back()->with($notification);


    }//end Method

}