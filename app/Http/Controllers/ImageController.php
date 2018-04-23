<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Image;

class ImageController extends Controller
{
    //
    
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage()
    {
    	return view('resizeImage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImagePost(Request $request)
    {
        $image = $request->file('image');
//        $input['imagename'] = time().rand(1,20000).'.'.$image->getClientOriginalExtension();
//
//
//        $destinationPath = public_path('thumbnail');
//        $img = Image::make($image->getRealPath());
//
//        $img->resizeCanvas(100, 100)->save($destinationPath.'/'.$input['imagename']);
//
//        $destinationPath = public_path('/images');
//        $image->move($destinationPath, $input['imagename']);

        return $image->getClientOriginalName();
    }
}
