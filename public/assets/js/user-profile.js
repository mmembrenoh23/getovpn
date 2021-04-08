$("#frmPassword").on("click","#btnSave",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget);
   console.log($form, $(this))
    var _route= $form.attr('action');

    try {
        if(App.fnValidarForm($form)) {
            return false;
        }

        App._urlToSend=_route;
        var _formData = new FormData(document.getElementById($form.attr('id')));
        App._data=_formData;
        App._method="POST";

         $.when(App.fnSendData()).done(function($_result){
            try {
                if($_result.error == 1){
                     toastr.error($_result.message);
                }
                else{
                    toastr.success($_result.message);
                   setTimeout(() => {
                        window.location=window.location.href;
                   }, 2500);
                }

            } catch (error) {
                toastr.error(error.message);
            }
         }).fail(function(errorThrown){
              var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
         });
    }
    catch (error) {
        toastr.error(error.message);
    }

})
.on("click","#btnGenPass",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget);
   console.log($form)
   $.when(App.fnGenerarContrasenia($($form[0].txtPassword))).done(App.copyToClipboard("txtPassword"))

}).on('input','#txtPassword',function(e){
    e.preventDefault();

   if(!App.fnValidarContrasenia($(this).val())){
       $(this).addClass('is-invalid');
        return false;
   }
   else{
       $(this).removeClass('is-invalid').addClass('is-valid');
   }

}).on("click","#btnSeePass",function(e){
    e.preventDefault();
    var $password = $(e.delegateTarget).find("txtPassword");
  // console.log(e.delegateTarget,e);
    //ft-eye-off
    var $button=$(this).find("button");
    var $icon=$(this).find("button").find("i");

    if($button.hasClass("btn-success")){
        $button.removeClass("btn-success").addClass("btn-warning");
        $icon.removeClass("ft-eye-off").addClass("ft-eye");

        $(e.delegateTarget).find('input:password').each(function() {
             $("<input type='text' />").attr({ name: this.name, value: this.value, id:this.id, class:this.classList }).insertBefore(this);
        }).remove();
    }
    else{
        $button.addClass("btn-success").removeClass("btn-warning");
        $icon.addClass("ft-eye-off").removeClass("ft-eye");
        $(e.delegateTarget).find('#txtPassword').each(function() {
             $("<input type='password' />").attr({ name: this.name, value: this.value, id:this.id, class:this.classList }).insertBefore(this);
        }).remove();
    }
})

$("#frmUserProfile").on("click","#btnSave",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget);
   console.log($form, $(this))
    var _route= $form.attr('action');

    try {
        if(App.fnValidarForm($form)) {
            return false;
        }

        App._urlToSend=_route;
        var _formData = new FormData(document.getElementById($form.attr('id')));
        App._data=_formData;
        App._method="POST";

         $.when(App.fnSendData()).done(function($_result){
            try {
                if($_result.error == 1){
                     toastr.error($_result.message);
                }
                else{
                    toastr.success($_result.message);
                   setTimeout(() => {
                        window.location=window.location.href;
                   }, 2500);
                }

            } catch (error) {
                toastr.error(error.message);
            }
         }).fail(function(errorThrown){
              var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
         });
    }
    catch (error) {
        toastr.error(error.message);
    }

});

