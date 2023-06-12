<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function Home(){
        return view('frontend.index');
}//end method
}
