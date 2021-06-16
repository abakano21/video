<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <title>Video</title>
    <link href="{{ asset('css/video-js.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/videojs-resolution-switcher-vjs7@1.0.0/videojs-resolution-switcher.css" rel="stylesheet">
</head>
<style>
    #pokoplayer {
        
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
    }

    /* Add some content at the bottom of the video/page */
    .content {
        position: fixed;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #f1f1f1;
        width: 100%;
        padding: 20px;
    }

    button:focus {
        outline: none;
        box-shadow: none;
    }

    video:focus {
        outline: none;
        box-shadow: none;
    }

    .video-js .vjs-duration,
    .vjs-no-flex .vjs-duration {
        display: block;
    }

    .video-js .vjs-current-time,
    .vjs-no-flex .vjs-current-time {
        display: block;
    }

    .video-js .vjs-remaining-time,
    .vjs-no-flex .vjs-current-time {
        display: none;
    }

    .vjs-live .vjs-time-control {
        display: block;
    }

    .vjs-time-divider {
        display: block;
    }

    .vjs-resolution-button .vjs-icon-placeholder:before {
        z-index: 2;
        opacity: 0;
    }

    .vjs-resolution-button-label {
        top: 50%;
        position: absolute;
        left: 30%;
    }
</style>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<body>
    <div class="container mx-auto px-4 mt-20 relative w-44 h-44" style="width: 60%;">
        <a class="p-2 text-blue-500" href="{{ url('/') }}">Home Page</a>

        <video-js id="pokoplayer" class="vjs-default-skin vjs-big-play-centered" controls preload="auto" data-setup='{"fluid": true}'>
        </video>
    </div>

    <script src="//vjs.zencdn.net/7.7.4/video.min.js"></script>
    <script src="{{ asset('js/poko.js') }}"></script>

    <script>
        videojs('pokoplayer', {
            "controls": true,
            "autoplay": true,
            "preload": "metadata",
            "width": "100%",
            "height": "auto",

            plugins: {
                videoJsResolutionSwitcher: {
                    default: 'auto',
                    dynamicLabel: true
                }
            }
        }, function() {
            var player = this;
            player.updateSrc([{
                    src: "{{ url('/') }}/converted/{{ $data['video'] }}_1_1000.m3u8",
                    type: 'application/x-mpegURL',
                    label: '4K',
                    res: '4K'
                },
                {
                    src: "{{ url('/') }}/converted/{{ $data['video'] }}_2_750.m3u8",
                    type: 'application/x-mpegURL',
                    label: 'FHD',
                    res: 'FHD'
                },
                {
                    src: "{{ url('/') }}/converted/{{ $data['video'] }}_0_500.m3u8",
                    type: 'application/x-mpegURL',
                    label: 'HD',
                    res: 'HD'
                }
            ])
        });
    </script>

</body>

</html>