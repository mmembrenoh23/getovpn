$("#btnBack").on("click",function(e){
    e.preventDefault();

    window.location = $(this).data('route');

});

$('#mGenerarSecret button').on('click', function (e) {
    $(this).attr('reload', true);
});

var route_secret="";

$(".file-list").on("click","#btnGenerarSecret",function(e){
    e.preventDefault();
    route_secret = $(this).data('route');
    $form=  $('#mGenerarSecret').find("form");

    if($form){
        App.fnLimpiarInputs($form);
    }
})
.on("click","#btnGetLink",function(e){
    e.preventDefault();

    var route = $(this).data('route');
    try {
        App._urlToSend=route;
        App._data=null;
        App._method="GET";

         $.when(App.fnSendData())
            .done(function($_resultado) {
                if($_resultado.error === 0){
                    toastr.success($_resultado.message);
                    $("body").append("<div id='download-link'>"+ $_resultado.url_download + "</div>")
                    $.when(App.copyToClipboard("download-link")).done(function(){
                         $("body").find("#download-link").remove();
                    });
                }
                else{
                    toastr.error($_resultado.message);
                }
            }).fail(function(errorThrown){
                 var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
            });

    } catch (error) {
        toastr.error(error.message);
    }
});


$("#mGenerarSecret").on("click","#reload",function(e){
    e.preventDefault();

    try {
        App._urlToSend=route_secret;
        App._data=null;
        App._method="GET";

         $.when(App.fnSendData())
            .done(function($_resultado) {
                if($_resultado.error === 0){
                    $("#mGenerarSecret").find("#Secret").val($_resultado.secret);
                    toastr.success($_resultado.message);
                    $.when(App.copyToClipboard("Secret")).done(function(){
                        // $("body").find("#key-secret").remove();
                    });
                }
                else{
                    toastr.error($_resultado.message);
                }
            }).fail(function(errorThrown){
                 var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
            });

    } catch (error) {
        toastr.error(error.message);
    }
})
