<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 120); 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoController extends Controller
{
    public function welcome()
    {
        $data = [];
        $directory = storage_path()."/uploads/videos";
        if(is_dir($directory)) {
            $data['files'] = array_diff(scandir($directory), array('..', '.'));
        }
        return view('welcome', compact('data'));
    }
    
    public function store()
    {
        // Store video
        $videoId = Str::uuid();
        $file = request()->file('file');
        Storage::putFileAs('videos', request()->file('file'), "${videoId}.{$file->extension()}");

        $lowFormat  = (new X264('aac'))->setKiloBitrate(500);
        $midFormat = (new X264('aac'))->setKiloBitrate(750);
        $highFormat = (new X264('aac'))->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open("videos/{$videoId}.{$file->extension()}")
            ->exportForHLS()
            ->addFormat($lowFormat, function (HLSVideoFilters $filters) {
                $filters->resize(1280, 720);
            })
            ->addFormat($highFormat)
            ->addFormat($midFormat)
            ->onProgress(function ($progress) {
                // $this->info("Progress: {$progress}%");
            })
            ->toDisk('public')
            ->save("converted/${videoId}.m3u8");
        
        return redirect(url('/'));
    }

    public function show($video)
    {
        $data['video'] = explode('.',$video)[0];
        return view('video', compact('data'));
    }
}
