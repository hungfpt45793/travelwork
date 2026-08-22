@extends('site.layout_site.site')
@section('type_meta', 'website')

@section('show_css')
    <link rel="stylesheet" type="text/css" href="/public/assets/css/sitebar.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/side_bar_job.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/tab_filter.css"/>
    <link rel="stylesheet" type="text/css" href="/public/assets/web/css/post.css"/>
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">

@endsection

@section('content')

<video
    id="vid1"
    class="video-js vjs-default-skin"
    controls
    autoplay
    width="640" height="264"
    data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v=LiH-SdyPn4A&t=12s"}] }'
  >
  </video>

@endsection
@section('show_js')
<script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>
<script src="/public/assets/js/youtube.js"></script>
@endsection