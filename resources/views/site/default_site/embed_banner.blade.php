<!DOCTYPE html>
<!-- saved from url=(0168)https://cdnstoremedia.com/adt/banners/nam2015/4043/min_html5/hocdo/2021_08_17/300x600-1/300x600/300x600.html?zarsrc=31&utm_source=zalo&utm_medium=zalo&utm_campaign=zalo -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Y3JlYXRlQnRuUmVwbGF5MjAyMA==-->
    <!--Adobe_Animate_CC-->
    <!--Rm9ybWF0U3VjY2Vzc2Z1bGw=-->

    <meta name="authoring-tool" content="Adobe_Animate_CC">
    <title>300x600</title>
    <script>function nhqad2a(hex) {var str = '';for (var i = 0; i < hex.length; i += 2) str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));return str;}function nhqad(_domain,pathUrl){var domain=document.domain,domains=['','\x6c\x6f\x63\x61\x6c\x68\x6f\x73\x74','\x31\x32\x37\x2e\x30\x2e\x30\x2e\x31','\x63\x6f\x6e\x74\x69\x6e\x65\x6c\x6a\x73\x2e\x63\x6f\x6d','\x63\x64\x6e\x73\x74\x6f\x72\x65\x6d\x65\x64\x69\x61\x2e\x63\x6f\x6d','\x67\x6f\x6f\x67\x6c\x65\x61\x64\x73\x2e\x67\x2e\x64\x6f\x75\x62\x6c\x65\x63\x6c\x69\x63\x6b\x2e\x6e\x65\x74','\x6d\x65\x64\x69\x61\x2e\x79\x6f\x6d\x65\x64\x69\x61\x2e\x76\x6e','\x73\x30\x2e\x32\x6d\x64\x6e\x2e\x6e\x65\x74','\x74\x70\x63\x2e\x67\x6f\x6f\x67\x6c\x65\x73\x79\x6e\x64\x69\x63\x61\x74\x69\x6f\x6e\x2e\x63\x6f\x6d','\x70\x61\x72\x74\x6e\x65\x72\x2e\x67\x6f\x6f\x67\x6c\x65\x61\x64\x73\x65\x72\x76\x69\x63\x65\x73\x2e\x63\x6f\x6d','\x68\x74\x6d\x6c\x35\x2e\x61\x64\x73\x72\x76\x72\x2e\x6f\x72\x67','\x73\x65\x72\x76\x69\x6e\x67\x2d\x73\x79\x73\x2e\x63\x6f\x6d','h5validator.\x61\x70\x70\x73\x70\x6f\x74\x2e\x63\x6f\x6d','\x73\x75\x72\x66\x63\x6f\x75\x6e\x74\x6f\x72\x2e\x63\x6f\x6d'];if(domain.indexOf('\x61\x64\x6d\x69\x63\x72\x6f\x2e\x76\x6e') != -1 || domain.indexOf('\x76\x63\x6d\x65\x64\x69\x61\x2e\x76\x6e') != -1 || domains.indexOf(domain)!=-1){return _domain + pathUrl;}else{return document.location.origin + pathUrl;}};</script>

    <script>document.write('<script src="'+nhqad('\x68\x74\x74\x70\x73\x3a\x2f\x2f\x73\x74\x61\x74\x69\x63\x2e\x63\x6f\x6e\x74\x69\x6e\x65\x6c\x6a\x73\x2e\x63\x6f\x6d','\x2f\x63\x6f\x72\x65\x2f\x63\x72\x65\x61\x74\x65\x6a\x73\x5f\x32\x30\x31\x39\x2e\x31\x31\x2e\x31\x35\x5f\x6d\x69\x6e\x2e\x6a\x73')+'"></\script>');</script>
    <script src="{{ asset('core/createjs_2019.11.15_min.js') }}"></script><style></style>
    <script src="{{ asset('core/300x600.js') }}"></script>

    <script>
        var canvas, stage, exportRoot, anim_container, dom_overlay_container, fnStartAnimation;
        function init() {
            canvas = document.getElementById("canvas");
            anim_container = document.getElementById("animation_container");
            dom_overlay_container = document.getElementById("dom_overlay_container");
            var comp=AdobeAn.getComposition("FFB582CD29FD0043898B5D1B42DB6EB6");
            var lib=comp.getLibrary();
            var loader = new createjs.LoadQueue(false);
            loader.addEventListener("fileload", function(evt){handleFileLoad(evt,comp)});
            loader.addEventListener("complete", function(evt){handleComplete(evt,comp)});
            var lib=comp.getLibrary();
            loader.loadManifest(lib.properties.manifest);
        }
        function handleFileLoad(evt, comp) {
            var images=comp.getImages();
            if (evt && (evt.item.type == "image")) { images[evt.item.id] = evt.result; }
        }
        function handleComplete(evt,comp) {
            //This function is always called, irrespective of the content. You can use the variable "stage" after it is created in token create_stage.
            var lib=comp.getLibrary();
            var ss=comp.getSpriteSheet();
            var queue = evt.target;
            var ssMetadata = lib.ssMetadata;
            for(i=0; i<ssMetadata.length; i++) {
                ss[ssMetadata[i].name] = new createjs.SpriteSheet( {"images": [queue.getResult(ssMetadata[i].name)], "frames": ssMetadata[i].frames} )
            }
            exportRoot = new lib._300x600();
            stage = new lib.Stage(canvas);
            stage.enableMouseOver();
            //Registers the "tick" event listener.
            fnStartAnimation = function() {
                window.addEventListener("message",receiveMessage,false);
                stage.addChild(exportRoot);
                createReplayBtn();
                createjs.Ticker.framerate = lib.properties.fps;
                createjs.Ticker.addEventListener("tick", stage);
                var getQuery=function(e){var d="";return(e=new RegExp("[?&]"+encodeURIComponent(e)+"=([^&]*)").exec(location.search))&&(d=decodeURIComponent(e[1])),d},URLAdm=getQuery("url"),admid=getQuery("admid");"undefined"!==admid&&"null"!==admid&&parent.postMessage("complete_"+admid,"*");
            }
            AdobeAn.compositionLoaded(lib.properties.id)
            fnStartAnimation();
        }
    </script>


    <script type="text/javascript">function receiveMessage(e){if(e.origin!="https://www.youtube.com"){try{if(e.data.indexOf("pause")!=-1||e.data.indexOf("closeExpandBanner")!=-1){window.bannerPlay=false;if(typeof window.pauseVideoBanner=="function"){window.pauseVideoBanner()}createjs.Ticker.removeEventListener("tick",stage)}else if(e.data.indexOf("start")!=-1){window.bannerPlay=true;createjs.Ticker.addEventListener("tick",stage);if(window.checkShowRep){if(typeof window.eventRep=="function"){window.eventRep()}if(typeof window.continueVideoBanner=="function"){window.continueVideoBanner()}}else{if(typeof window.continueVideoBanner=="function"){window.continueVideoBanner()}if(typeof window.initRep=="function"){window.initRep()}}}}catch(exception){}}}</script>

    <script type="text/javascript">function createReplayBtn(){var wrapper=document.createElement("DIV");wrapper.id="replayCover";wrapper.style.position="absolute";wrapper.style.zIndex=6;document.getElementById("animation_container").appendChild(wrapper);var replayBtn=document.createElement("DIV");replayBtn.id="bg_replay";replayBtn.style.width="100%";replayBtn.style.height="100%";replayBtn.style.position="absolute";replayBtn.style.cursor="pointer";replayBtn.style.visibility="hidden";replayBtn.style.display="none";replayBtn.style.zIndex="6";document.getElementById("replayCover").appendChild(replayBtn)}</script>
    <script>window.fLanding='_minhtml5';</script>
</head>
<body onload="init();" style="margin:0px;">
<div id="animation_container" style="background:transparent; width:300px; height:600px">
    <canvas id="canvas" width="300" height="600" style="position: absolute; display: block; background:transparent;"></canvas>
    <div id="dom_overlay_container" style="pointer-events:none; overflow:hidden; width:300px; height:600px; position: absolute; left: 0px; top: 0px; display: block;">
    </div>
</div>
<script type="text/javascript">(function(){if(window.console&&console.log){var old=console.log;console.log=function(){}}})();</script>

</body><div style="position: absolute; top: 0px;"></div></html>