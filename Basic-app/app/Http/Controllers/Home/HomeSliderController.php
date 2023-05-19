<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\Request;
use Image;

class HomeSliderController extends Controller
{
    public function HomeSlider(){
        //this home slide will be used to access our DB thats why its imported/used
        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all', compact('homeslide'));
    }
    //end method

    public function UpdateSlider(request $request){

        $slide_id = $request->id;

       if ($request->file('home_slide')) {
        $image = $request->file('home_slide');
         $name_gen = hexdec(uniqid()).'.'.$image ->
          getClientOriginalExtension();

          //use image maker to resize
          Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);
          //save in  DB
          $save_url = 'upload/home_slide/'.$name_gen;

          //access our DB id
          HomeSlide::findOrFail($slide_id)->update([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'video_url' => $request->video_url,
            'home_slide' =>$save_url,

          ]);

          $notification = array(
            'message' => 'Home Slide Updated with Image Successfully',
            'alert-type' => 'success'
          );
        return redirect()->back()->with($notification);

       } else {

        HomeSlide::findOrFail($slide_id)->update([
            'title' => $request->title,
            'short_title' => $request->short_title,
            'video_url' => $request->video_url,
          ]);

          $notification = array(
            'message' => 'Home Slide Updated without Image Successfully',
            'alert-type' => 'success'
          );   
        return redirect()->back()->with($notification);

       }

    }//end Method
}
