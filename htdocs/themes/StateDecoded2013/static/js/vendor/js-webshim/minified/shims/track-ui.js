jQuery.webshims.register("track-ui",function(b,i){var k=i.cfg.track,l={subtitles:1,captions:1,descriptions:1},j=i.mediaelement,n={update:function(a,g){if(a.activeCues.length){var c=a.displayedActiveCues,d=a.activeCues,e=!0,f=0,m=c.length;if(m!=d.length)e=!1;else for(;f<m;f++)if(c[f]!=d[f]){e=!1;break}if(!e){a.displayedActiveCues=a.activeCues;if(!a.trackDisplay)a.trackDisplay=b('<div class="cue-display"><span class="description-cues" aria-live="assertive" /></div>').insertAfter(g),this.addEvents(a,
g),i.docObserve();a.hasDirtyTrackDisplay&&g.triggerHandler("forceupdatetrackdisplay");this.showCues(a)}}else this.hide(a)},showCues:function(a){var g=b('<span class="cue-wrapper" />');b.each(a.displayedActiveCues,function(c,d){var e=b('<span class="cue-line"><span '+(d.id?'id="cue-id-'+d.id+'"':"")+' class="cue" /></span>').find("span").html(d.getCueAsHTML()).end();"descriptions"==d.track.kind?setTimeout(function(){b("span.description-cues",a.trackDisplay).html(e)},0):g.prepend(e)});b("span.cue-wrapper",
a.trackDisplay).remove();a.trackDisplay.append(g)},addEvents:function(a,b){if(k.positionDisplay){var c,d=function(c){if(a.displayedActiveCues.length||!0===c){a.trackDisplay.css({display:"none"});var d=b.getShadowElement();d.offsetParent();var c=d.innerHeight(),e=d.innerWidth(),d=d.position();a.trackDisplay.css({left:d.left,width:e,height:c-45,top:d.top,display:"block"});a.trackDisplay.css("fontSize",Math.max(Math.round(c/30),7));a.hasDirtyTrackDisplay=!1}else a.hasDirtyTrackDisplay=!0},e=function(){d(!0)};
b.on("updateshadowdom playerdimensionchange mediaelementapichange updatetrackdisplay updatemediaelementdimensions swfstageresize",function(){clearTimeout(c);c=setTimeout(d,0)});b.on("forceupdatetrackdisplay",e);e()}},hide:function(a){if(a.trackDisplay&&a.displayedActiveCues.length)a.displayedActiveCues=[],b("span.cue-wrapper",a.trackDisplay).remove(),b("span.description-cues",a.trackDisplay).empty()}};b.extend(b.event.customEvent,{updatetrackdisplay:!0,forceupdatetrackdisplay:!0});j.trackDisplay=
n;if(!j.createCueList){var o={getCueById:function(a){for(var b=null,c=0,d=this.length;c<d;c++)if(this[c].id===a){b=this[c];break}return b}};j.createCueList=function(){return b.extend([],o)}}j.getActiveCue=function(a,g,c,d){if(!a._lastFoundCue)a._lastFoundCue={index:0,time:0};if(Modernizr.track&&!k.override&&!a._shimActiveCues)a._shimActiveCues=j.createCueList();for(var e=0,f;e<a.shimActiveCues.length;e++)f=a.shimActiveCues[e],f.startTime>c||f.endTime<c?(a.shimActiveCues.splice(e,1),e--,f.pauseOnExit&&
b(g).pause(),b(a).triggerHandler("cuechange"),b(f).triggerHandler("exit")):"showing"==a.mode&&l[a.kind]&&-1==b.inArray(f,d.activeCues)&&d.activeCues.push(f);g=a.cues.length;for(e=a._lastFoundCue.time<c?a._lastFoundCue.index:0;e<g;e++){f=a.cues[e];if(f.startTime<=c&&f.endTime>=c&&-1==b.inArray(f,a.shimActiveCues))a.shimActiveCues.push(f),"showing"==a.mode&&l[a.kind]&&d.activeCues.push(f),b(a).triggerHandler("cuechange"),b(f).triggerHandler("enter"),a._lastFoundCue.time=c,a._lastFoundCue.index=e;if(f.startTime>
c)break}};!k.override&&Modernizr.track&&function(){var a,g=function(c){setTimeout(function(){a=!0;b(c).triggerHandler("updatetrackdisplay");a=!1},9)},c=function(c,e,f){var m="_sup"+f,h={prop:{}},j;h.prop[f]=function(){!a&&!k.override&&Modernizr.track&&g(b(this).closest("audio, video"));return j.prop[m].apply(this,arguments)};j=i.defineNodeNameProperty(c,e,h)};c("track","track","get");["audio","video"].forEach(function(a){c(a,"textTracks","get");c("nodeName","addTextTrack","value")})}();i.addReady(function(a,
g){b("video, audio",a).add(g.filter("video, audio")).each(function(){var a=b(this),d=function(){var b,d;if(!h||!g)if(h=a.prop("textTracks"),g=i.data(a[0],"mediaelementBase")||i.data(a[0],"mediaelementBase",{}),!g.displayedActiveCues)g.displayedActiveCues=[];if(h&&((d=a.prop("currentTime"))||0===d)){g.activeCues=[];for(var e=0,f=h.length;e<f;e++)b=h[e],"disabled"!=b.mode&&b.cues&&b.cues.length&&j.getActiveCue(b,a,d,g);n.update(g,a)}},e=function(a){clearTimeout(l);a&&"timeupdate"==a.type?(d(),setTimeout(e,
90)):l=setTimeout(d,9)},f=function(){a.off(".trackview").on("play.trackview timeupdate.trackview updatetrackdisplay.trackview",e)},g,h,l;if(!k.override&&Modernizr.track)a.on("mediaelementapichange trackapichange",function(){k.override||!Modernizr.track||a.is(".nonnative-api-active")?f():(h=a.prop("textTracks"),g=i.data(a[0],"mediaelementBase")||i.data(a[0],"mediaelementBase",{}),b.each(h,function(a,b){b._shimActiveCues&&delete b._shimActiveCues}),n.hide(g),a.unbind(".trackview"))});else f()})})});
