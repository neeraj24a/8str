function setcookie(name, value, expires, path, domain, secure) {
    var today = new Date;
    today.setTime(today.getTime()),
    expires && (expires = 1e3 * expires * 60 * 60 * 24);
    var expires_date = new Date(today.getTime() + expires);
    document.cookie = name + "=" + escape(value) + (expires ? ";expires=" + expires_date.toGMTString() : "") + (path ? ";path=" + path : "") + (domain ? ";domain=" + domain : "") + (secure ? ";secure" : "")
}
function getcookie(name) {
    var start = document.cookie.indexOf(name + "=")
      , len = start + name.length + 1;
    if (!start && name != document.cookie.substring(0, name.length))
        return null;
    if (-1 == start)
        return null;
    var end = document.cookie.indexOf(";", len);
    return -1 == end && (end = document.cookie.length),
    unescape(document.cookie.substring(len, end))
}
function jplayer_responsive() {
    $(".jPlayer[class!=audioPlayer] object").each(function() {
        var width = $(this).width();
        $(this).height(width / 1.778)
    })
}
!function($) {
    $.fn.plyr = function(extras) {
        var options = {};
        try {
            options = JSON.parse($(this).find(".playerData").text())
        } catch (err) {}
        var player = $(this)
          , settings = $.extend(extras, options)
          , HTMLContent = $('<div class="playerScreen">\t\t\t<div id="unique-container-' + generateID(1) + '" class="jPlayer-container"></div>\t\t\t<a tabindex="1" href="#" class="video-play"><div class="play-icon"><i class="icon-play-circle"></i></div></a>\t\t\t</div>\t\t\t<div class="controls">\t\t\t<div class="control-set left">\t\t\t<a tabindex="1" href="#" class="play smooth"><i class="icon-play"></i></a>\t\t\t<a tabindex="1" href="#" class="pause smooth"><i class="icon-pause"></i></a>\t\t\t</div>\t\t\t<div class="control-set right-volume">\t\t\t<a tabindex="1" href="#" class="mute smooth"><i class="icon-volume"></i></a>\t\t\t<a tabindex="1" href="#" class="unmute smooth"><i class="icon-mute"></i></a>\t\t\t</div>\t\t\t<div class="volume-block">\t\t\t<div class="volume-control"><div class="volume-value"></div></div>\t\t\t</div>\t\t\t<div class="control-set right">\t\t\t<a href="#" tabindex="1" class="fullscreen smooth"><i class="icon-fullscreen"></i></a>\t\t\t<a href="#" tabindex="1" class="smallscreen smooth"><i class="icon-fullscreen-exit"></i></a>\t\t\t</div>\t\t\t<div class="progress-block">\t\t\t<div class="timer current"></div>\t\t\t<div class="timer duration"></div>\t\t\t<div class="jp-progress"><div class="seekBar"><div class="playBar"></div></div></div>\t\t\t</div></div>');
        $(this).find(".playerData").remove(),
        $(this).append(HTMLContent);
        var supplied = new Array;
        $.each(settings.media, function(key, value) {
            "poster" != key && supplied.push(key)
        });
        var formats = supplied.join(", ")
          , cVolume = getcookie("jplayer-volume");
        options = {
            ready: function(event) {
                event.jPlayer.status.noVolume && $(player).find(".controls .progress-block").css({
                    margin: "0 10px 0 45px"
                }),
                $(this).jPlayer("setMedia", settings.media),
                null != settings.autoplay && $(this).jPlayer("play")
            },
            swfPath: "skin/jquery.jplayer.swf",
            supplied: formats,
            solution: "html, flash",
            volume: null != cVolume ? cVolume : "0.5",
            smoothPlayBar: !1,
            keyEnabled: !0,
            remainingDuration: !1,
            toggleDuration: !1,
            errorAlerts: !1,
            warningAlerts: !1,
            size: {
                width: "100%",
                height: "auto"
            },
            cssSelectorAncestor: "#" + $(player).attr("id"),
            cssSelector: {
                videoPlay: ".video-play",
                play: ".play",
                pause: ".pause",
                seekBar: ".seekBar",
                playBar: ".playBar",
                mute: ".right-volume .mute",
                unmute: ".right-volume .unmute",
                volumeBar: ".volume-control",
                volumeBarValue: ".volume-control .volume-value",
                currentTime: ".timer.current",
                duration: ".timer.duration",
                fullScreen: ".fullscreen",
                restoreScreen: ".smallscreen",
                gui: ".controls",
                noSolution: ".noSolution"
            },
            error: function(event) {
                event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET && $(this).jPlayer("setMedia", settings.media).jPlayer("play")
            },
            play: function() {
                $(player).find(".playerScreen .video-play").stop(!0, !0).fadeOut(150),
                $(this).on("click", function() {
                    $(this).jPlayer("pause")
                }),
                $(this).jPlayer("pauseOthers"),
                jplayer_responsive()
            },
            pause: function() {
                $(player).find(".playerScreen .video-play").stop(!0, !0).fadeIn(350),
                $(this).unbind("click")
            },
            ended: function() {
                $(this).jPlayer("setMedia", settings.media)
            },
            volumechange: function(event) {
                setcookie("jplayer-volume", event.jPlayer.options.volume)
            },
			destroy: function() {
				$(this).jPlayer('destroy');
			}
        },
        $(player).find(".volume-block").on("mousedown", function() {
            return parent = $(player).find(".volume-block"),
            $(player).find(".volume-block").on("mousemove", function(e) {
                $(player).find(".volume-control .volume-value").css({
                    width: e.pageX - $(parent).offset().left
                });
                var total = $(player).find(".volume-control").width();
                return $(player).find(".jPlayer-container").jPlayer("option", "muted", !1),
                $(player).find(".jPlayer-container").jPlayer("option", "volume", (e.pageX - $(parent).offset().left) / total),
                !1
            }),
            !1
        }),
        $(player).find(".jp-progress").on("mousedown", function() {
            return parent = $(player).find(".jp-progress .seekBar"),
            $(player).find(".jp-progress").on("mousemove", function(e) {
                var total = $(player).find(".jp-progress .seekBar").width()
                  , perc = (e.pageX - $(parent).offset().left) / total * 100;
                return $(player).find(".jp-progress .seekBar .playBar").css({
                    width: perc + "%"
                }),
                $(player).find(".jPlayer-container").jPlayer("playHead", perc),
                !1
            }),
            !1
        }),
        $(document).on("mouseup", function() {
            $(".jp-progress, .volume-block").unbind("mousemove")
        }),
        $.extend(options, settings),
        $(this).find(".jPlayer-container").jPlayer(options),
        $(window).on("resize", jplayer_responsive)
    }
}(jQuery);
var globalIdCounter = 0;
function generateID(baseStr) {
    return baseStr + globalIdCounter++
}
