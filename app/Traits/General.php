<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait General
{

    public function createData(Request $request) : array {
        $hidden = ['_token','file'];
        $data = array_filter($request->all(), function ($key) use ($hidden) {
            return !in_array($key, $hidden);
        }, ARRAY_FILTER_USE_KEY);
        return $data;
    }

    public function imageUpload(Request $request,$path,$index){
        $image = $request->file('file');
        // Define a unique filename
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        // Store the image in the public disk (inside the 'uploads' directory)
        $image->move(public_path($path), $filename);
        $request->request->add([$index => $filename]);
    }
}