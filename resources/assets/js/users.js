
$('#mGenerarSecret button').on('click', function (e) {
    $(this).attr('btnGenPass', true);
});

$("#mCreateUser").on("click","#btnGenPass",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget).find("form");
   var _delegate =$(e.delegateTarget)

   $.when(App.fnGenerarContrasenia($($form[0].txtPassword))).done(App.copyToClipboard("txtPassword"))

   console.log($form);
});

$("#mCreateUser").on('input','#txtPassword',function(e){
    e.preventDefault();

   if(!App.fnValidarContrasenia($(this).val())){
       $(this).addClass('is-invalid');
        return false;
   }
   else{
       $(this).removeClass('is-invalid').addClass('is-valid');
   }

});

//fnValidarContrasenia
