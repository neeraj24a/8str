$(document).ready(function() {
    $("#player-instance").jPlayer({
        ready: function() {
            $(this).jPlayer("setMedia", {
                mp3: base_url+"/assets/uploads/original/hip-hop/Kalimba.mp3",
                oga: "http://www.jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
            });
        },
        swfPath: "/js",
        supplied: "mp3, oga"
    });

});