<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Image;

class AboutController extends Controller
{
    public function AboutPage(){
        //this home slide will be used to access our DB thats why its imported/used
        $aboutPage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }//end method
    

    public function UpdateAbout(request $request){

        $about_id = $request->id;

       if ($request->file('about_image')) {
        $image = $request->file('about_image');
         $name_gen = hexdec(uniqid()).'.'.$image ->
          getClientOriginalExtension();

          //use image maker to resize
          Image::make($image)->resize(523,605)->save('upload/home_about/'.$name_gen);
          //save in  DB
          $save_url = 'upload/home_about/'.$name_gen;

          //access our DB id
          About::findOrFail($about_id)->update([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,    
            'about_image' =>$save_url,

          ]);

          $notification = array(
            'message' => 'About Page Updated with Image Successfully',
            'alert-type' => 'success'
          );
        return redirect()->back()->with($notification);

       } else {

        About::findOrFail($about_id)->update([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,    
            
          ]);

          $notification = array(
            'message' => 'About Page Updated without Image Successfully',
            'alert-type' => 'success'
          );   
        return redirect()->back()->with($notification);

       }

    }//end Method

    public function HomeAbout(){
      $aboutPage = About::find(1);
        return view('frontend.about_page',  compact('aboutPage'));
    }//end Method
}
