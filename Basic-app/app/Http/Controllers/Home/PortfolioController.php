<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use App\Models\Portfolio;
use Illuminate\Support\Carbon;

class PortfolioController extends Controller
{
    public function AllPortfolio() {
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));

    }// end Method

    public function AddPortfolio(){
        return view('admin.portfolio.portfolio_add');

    }// end Method

    //when creating a post method, try and parse a request querry.
    public function StorePortfolio(request $request) {
        $request->validate([
            'portfolio_name' =>' Required',
            'portfolio_title' =>' Required',
            'portfolio_image' =>' Required',
        ],[
                                             //to infuse a custom message
       'portfolio_name.Required'=>'Portfolio Name is Required',  
       'portfolio_title.Required'=>'Portfolio Title is Required',    
      'portfolio_image.Required'=>'Portfolio Image is Required',                                  

        ]);

        $image = $request->file('portfolio_image');
         $name_gen = hexdec(uniqid()).'.'.$image ->
          getClientOriginalExtension();

          //use image maker to resize
          Image::make($image)->resize(1020,519)->save('upload/portfolioImages/'.$name_gen);
          //save in  DB
          $save_url = 'upload/portfolioImages/'.$name_gen;

          //access our DB id
          Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' =>$save_url,
            'created_at' => Carbon::now(),

          ]);

          $notification = array(
            'message' => 'Portfolio Inserted Successfully',
            'alert-type' => 'success'
          );
          return redirect()->route('all.Portfolio')->with($notification);

    }// end Method

    public function EditPortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit', compact('portfolio'));

    }//nd method

    public function UpdatePortfolio(request $request) {
        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')) {
         $image = $request->file('portfolio_image');
          $name_gen = hexdec(uniqid()).'.'.$image ->
           getClientOriginalExtension();
 
          //use image maker to resize
          Image::make($image)->resize(1020,519)->save('upload/portfolioImages/'.$name_gen);
          //save in  DB
          $save_url = 'upload/portfolioImages/'.$name_gen;

          //access our DB id
          Portfolio::findOrFail($portfolio_id)->update([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' =>$save_url,
           

          ]);
 
           $notification = array(
             'message' => 'Portfolio Updated with Image Successfully',
             'alert-type' => 'success'
           );
         return redirect()->route('all.Portfolio')->with($notification);
 
        } else {
 
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
              
               
    
              ]);
 
           $notification = array(
             'message' => 'Portfolio Updated without Image Successfully',
             'alert-type' => 'success'
           );   
           return redirect()->route('all.Portfolio')->with($notification);
 
        }
 
    }//end Method
    
    public function DeletePortfolio($id) {

        $portfolio =  Portfolio::findOrFail($id);
              $img =  $portfolio->portfolio_image;
              unlink($img);

              Portfolio::findOrFail($id)->delete();

              $notification = array(
                'message' => 'Portfolio Image Deleted Successfully',
                'alert-type' => 'success' 
              );
            return redirect()->back()->with($notification);


    }//end  Method
}
