jQuery(document).ready(function ( $ ) {	
    $("#deepi_modal_close").click(function(){
        $("#deepi_container_style_modal").fadeOut();
    })
    $("#deepi_logo_btn").click(function(){
        $("#deepi_container_style_modal").fadeIn();
        $("#deepi_container_style_modal").css('display','flex');
    })

});