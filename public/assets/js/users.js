App.confi_data_table ={
            "bPaginate": true,
            "bSortable": false,
            "fnHeaderCallback": function (nHead, aData, iStart, iEnd, aiDisplay) {
                $(nHead).addClass("bg-primary").find("th").addClass("white");

            },
            "fnRowCallback":function( nRow, aData, iDisplayIndex ){
                $(nRow).on("click","#btnEdit",function(e){
                    e.preventDefault();
                    var _route = $(this).data('route');
                    var _route_update=$(this).data('route_update');
                    $("#mEditUser").find("#frmEdit").attr('action',_route_update);
                    var _form = $("#mEditUser").find("#frmEdit");

                    try {
                        App._urlToSend=_route;
                        App._data=null;
                        App._method="GET";

                        $.when(App.fnSendData()).done(function($_result){
                            try {
                                _form.find("#txtFirstNameE").val($_result.first_name);
                                _form.find("#txtLastNameE").val($_result.last_name);
                                _form.find("#txtEmailE").val($_result.email);
                            } catch (error) {
                                toastr.error(error.message);
                            }
                        }).fail(function(errorThrown){
                            var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                                toastr.error(message);
                        });

                    } catch (error) {
                        toastr.error(error.message);
                    }

                }).on("click","#btnDelete",function(e){
                    e.preventDefault();
                    var _route = $(this).data('route');
                    console.log(_route)
                     swal({
                            title: 'Are you sure?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, inactive it!'
                        }).then(function () {


                            try {
                                App._urlToSend=_route;

                                var _formData = new FormData();
                                _formData.append("_method","DELETE");
                                App._data=_formData;
                                App._method="POST";

                                $.when(App.fnSendData()).done(function($_result){
                                    try {
                                        if($_result.error == 1){
                                            toastr.error($_result.message);
                                        }
                                        else{
                                            swal($_result.title, $_result.message, 'success')
                                            setTimeout(() => {
                                                    window.location="/config/users";
                                            }, 3000);
                                        }

                                    } catch (error) {
                                        toastr.error(error.message);
                                    }

                                });

                            } catch (error) {
                                toastr.error(error.message);

                            }


                        }).catch(swal.noop)
                })
            },
            "language": {
                searchPlaceholder: "Search ...",
                "sProcessing": "Process...",
                "sLengthMenu": "Show _MENU_ records",
                "sZeroRecords": "There's data to result",
                "sEmptyTable": "There's records availables",
                "sInfo": "Show record of _START_ to _END_ total _TOTAL_ record",
                "sInfoEmpty": "Show records of 0 to 0 of 0 records",
                "sInfoFiltered": "(Filter total of _MAX_ records)",
                "sInfoPostFix": "",
                "sSearch": "",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Loading...",
                "oPaginate": {
                    "sFirst": "First",
                    "sLast": "Last",
                    "sNext": "Next",
                    "sPrevious": "Previous"
                },
                "oAria": {
                    "sSortAscending": ": Activate to sort the column in ascending order",
                    "sSortDescending": ": Activate to sort the column in descending order"
                }
            },
            "order":[0,'desc'],
           "ordering": true,
           "paging": true,
           //"searching": { "regex": true },
            "sDom":'<"top"l>rt<"bottom"ip>',

        };

App.setDatatable($("#tbUsers"));

$('#mCreateUser button').on('click', function (e) {
    $(this).attr('btnGenPass', true);
});

$('#mEditUser button').on('click', function (e) {
    $(this).attr('btnGenPass', true);
});

$("#mCreateUser").on("click","#btnSave",function(e){
    e.preventDefault();
  // var $form= $(e.delegateTarget).find("form");
   var _form =$(e.delegateTarget).find("form");

   var _route= _form.attr('action');

    try {
        if(App.fnValidarForm(_form)){
            return false;
        }

        App._urlToSend=_route;
        var _formData = new FormData(document.getElementById(_form.attr('id')));
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
                        window.location="/config/users";
                   }, 2500);
                }

            } catch (error) {
                toastr.error(error.message);
            }
         }).fail(function(errorThrown){
              var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
         });
    } catch (error) {
        toastr.error(error.message);
    }

}).on("click","#btnGenPass",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget).find("form");
   var _delegate =$(e.delegateTarget)


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
});

$("#mEditUser").on("click","#btnSave",function(e){
    e.preventDefault();
  // var $form= $(e.delegateTarget).find("form");
  console.log(e.delegateTarget);
   var _form =$(e.delegateTarget).find("form");

   var _route= _form.attr('action');

    try {
        if(App.fnValidarForm(_form, not_valid=["txtPasswordE"])){
            return false;
        }

        App._urlToSend=_route;
        var _formData = new FormData(document.getElementById(_form.attr('id')));
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
                        window.location="/config/users";
                   }, 2500);
                }

            } catch (error) {
                toastr.error(error.message);
            }
         }).fail(function(errorThrown){
              var message=errorThrown.responseJSON.errors+" "+errorThrown.responseJSON.message;
                toastr.error(message);
         });
    } catch (error) {
        toastr.error(error.message);
    }

}).on("click","#btnGenPass",function(e){
    e.preventDefault();
   var $form= $(e.delegateTarget).find("form");

   $.when(App.fnGenerarContrasenia($($form[0].txtPasswordE))).done(function(){
       App.copyToClipboard("txtPasswordE");
   })

}).on('input','#txtPasswordE',function(e){
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
        $(e.delegateTarget).find('#txtPasswordE').each(function() {
             $("<input type='password' />").attr({ name: this.name, value: this.value, id:this.id, class:this.classList }).insertBefore(this);
        }).remove();
    }
});


