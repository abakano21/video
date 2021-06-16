<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function index()
    {
        $directory = storage_path()."/uploads/videos";
        $files = collect(array_diff(scandir($directory), array('..', '.')))->flatten();
        
        $updated = $files->transform(function($video) {
            return url('/').'/storage/converted/'.explode('.',$video)[0].'.m3u8';
        });
        
        return response()->json(['data' =>$updated], Response::HTTP_OK);
        
    }

    public function show($video)
    {
        $updated = url('/').'/storage/converted/'.explode('.',$video)[0].'.m3u8';        
        return response()->json($updated, Response::HTTP_OK);        
    }
}
