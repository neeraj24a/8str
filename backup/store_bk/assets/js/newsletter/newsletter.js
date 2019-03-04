$(document).ready(function(){
    $('body').on('click','.newsletter_status',function(){
        $(".loading").show();
        var id = $(this).data('id');
        var link = $(this);
         $.ajax({
            url: base_url + "/admin/NewsletterEmail/changeStatus",
            method: "POST",
            data: {'id': id},
            success: function(data) {
                link.html(data);
                $(".loading").hide();
            }
        })
    })
})