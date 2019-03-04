
$(document).ready(function(){
    $('#remix_genre').change(function(){
        $(".loading").show();
        var genre_id = $('#remix_genre').val();
        $.ajax({
            url : base_url+"/admin/remix/GetSubgenre",
            data : {'genre_id' : genre_id},
            method : "POST",
            success : function(data){
                $("#remix_subgenre").html(data);
                 $('.loading').hide();
            }
        })
    })
})