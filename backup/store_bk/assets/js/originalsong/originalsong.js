
$(document).ready(function(){
    $('#original_genre').change(function(){
        $(".loading").show();
        var genre_id = $('#original_genre').val();
        $.ajax({
            url : base_url+"/admin/originalsong/GetSubgenre",
            data : {'genre_id' : genre_id},
            method : "POST",
            success : function(data){
                $("#original_subgenre").html(data);
                 $('.loading').hide();
            }
        })
    })
})