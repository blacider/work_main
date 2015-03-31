$('document').ready(function(){
    //$('#module_image').click(function(){
    //    $("#desc").val($(this).data('desc'));
    //    $("#hgid").val($(this).data('id'));
    //    $('#module_thumb_image').modal();
    //});
    $('.module_image').click(function(){
        $("#desc").html("配图（宽x高): " + $(this).data('desc'));
        $("#hgid").val($(this).data('id'));
        $('#module_thumb_image').modal();
    });
});
