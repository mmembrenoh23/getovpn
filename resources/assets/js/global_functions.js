/**
* Author: Maria Membreño
* Desc: Archivo de funciones globales que se usan a lo largo de todo el proyecto, de manera que no se repitan
* en diferentes archivos js.
* Date: 27/01/2021
*/
/***********************************************************/
/************** CONFIGURACIONES **********************/
$('.modal').on('hidden.bs.modal', function (e) {
    $form= $(this).find("form");

    if($form){
      App.fnLimpiarInputs($form);
    }
})

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
/**************************************************************/

window.App={
    fnValidarForm : function ($form,not_valid=[]){

        var $_is_valid=false;
        var $_not_valid_field=false;

        try {

            $form.find("input").each(function(i, element){
                $(element).removeClass("is-invalid");
                $(element).parent().find(".invalid-feedback").remove();

                if(not_valid.length > 0){
                    $_not_valid_field = true;
                }
                var $flag = false;


                switch($(element)[0].type){
                    case "text":
                    case "file":
                    case "hide":
                         if($_not_valid_field){
                            for(var i in not_valid){
                                if($(element).attr('id') == not_valid[i]){
                                    $flag = true;
                                    break;
                                }
                            }
                        }


                        if(!$flag){
                            if($.trim($(element).val()) ==""){
                                $(element).addClass("is-invalid");
                                $(element).parent().append("<div class='invalid-feedback'>This field can't be Empty</div>");
                                $_is_valid=true;
                            }
                            else{
                                $(element).removeClass("is-invalid");
                                $(element).parent().find(".invalid-feedback").remove();
                            }
                        }

                        break;
                    case "password":


                        if($_not_valid_field){
                            for(var i in not_valid){
                                if($(element).attr('id') == not_valid[i]){
                                    $flag = true;
                                    break;
                                }
                            }
                        }

                         if(!$flag){

                            if(!window.App.fnValidarContrasenia($(element).val())){
                                $(element).addClass("is-invalid");
                                $(element).parent().append("<div class='invalid-feedback'>The password format is invalid</div>");
                                $_is_valid=true;
                            }else{
                                $(element).removeClass("is-invalid");
                                $(element).parent().find(".invalid-feedback").remove();
                            }
                        }
                        break;

                    case "email":
                        if(!window.App.ValidarCorreos($(element).val())){
                            $(element).addClass("is-invalid");
                            $(element).parent().append("<div class='invalid-feedback'>The  email format is invalid </div>");
                            $_is_valid=true;
                        }else{
                            $(element).removeClass("is-invalid");
                            $(element).parent().find(".invalid-feedback").remove();
                        }
                        break;
                    case "checkbox":
                    case "radio":
                        if(!$(element).is(":checked")){
                            $(element).addClass("is-invalid");
                            $(element).parent().append("<div class='invalid-feedback'>You need check an option</div>");
                            $_is_valid=true;
                        }
                        else{
                            $(element).removeClass("is-invalid");
                            $(element).parent().find(".invalid-feedback").remove();
                        }
                        break;
                }

            });

        } catch (error) {
            toastr.error(error.message);
        }

        return $_is_valid;
    },

    fnGenerarContrasenia: function($_input1){
        var contrasenia="";
        var cadena="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@$!%*?&#.-_";
        var app_=this;
        contrasenia=app_.GenerarConstrasenia(cadena);
        $_input1.val(contrasenia);
    },

    GenerarConstrasenia : function($_val){
       $_val = $_val.shuffle();
        var result = '';
        app_=this;

        for (var i = 10; i > 0; --i){
            result +=$_val.charAt(Math.floor(Math.random() * $_val.length));
        }
        if(!app_.fnValidarContrasenia(result)){
            app_.GenerarConstrasenia($_val);
        }
        return result;
    },

    ValidarCorreos : function($_correo){
        var _email_check = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

        if(!( _email_check.test( $_correo))){
            return false;
        }
        return true;
    },
    fnValidarContrasenia : function($_contrasenia){
        var _contrasenia = /^[A-Za-z\d$@$!%*?&#.$($)$-$_]{8,15}$/;

        if(_contrasenia.test($_contrasenia))
            return true;
        return false;
    },

    /**
    * funcion para copiar
    */
    copyToClipboard : function($_input){

        try{
            // Crea un campo de texto "oculto"
             var aux = document.createElement("input");

           // Asigna el contenido del elemento especificado al valor del campo

           if(document.getElementById($_input).nodeName === "INPUT")
           {
             aux.setAttribute("value", document.getElementById($_input).value);
           }
           else{
             aux.setAttribute("value", document.getElementById($_input).innerHTML);
           }

          // Añade el campo a la página
          document.body.appendChild(aux);

          // Selecciona el contenido del campo
          aux.select();

          aux.focus();

          // Copia el texto seleccionado
          document.execCommand("copy");

          // Elimina el campo de la página
          document.body.removeChild(aux);

           toastr.success("The data was copied!");

        }
        catch($e){
            toastr.error($e.message);
        }

    }
    ,
    fnLimpiarInputs:function($_form){
        $_form.find("input").each(function(i, element){

            switch($(element)[0].type){
                case "text":
                case "password":
                case "email":
                case "file":
                case "hide":
                    $(element).val("");
                    break;
                case "checkbox":
                case "radio":
                    $(element).prop('checked',false);
                    break;
            }

        });

       if($_form.find("select").length > 0)
            $_form.find("select").prop("disabled", false).val(null).trigger('change');

        if($_form.find("textarea").length > 0)
            $_form.find("textarea").val("");
    },

    _urlToSend:"",

    _data:null,

    _method:"",

    _esMultipart:false,

    _dataType:"",
    _is_simple:false,

    _beforeSend:null,
    cache:false,
    contentType: false,
    processData: false,
    /*
    * Metodo para enviar informacion a la url
    */
    fnSendData : function() {

        var app_ = this;

        if (!jQuery.isEmptyObject(app_._beforeSend)) {
            app_.spinner.show(app_._beforeSend);
        }

        if(app_._esMultipart){
            return $.ajax({
                type:app_._method,
                url: app_._urlToSend,
                data: app_._data,
                cache:false,
                contentType: false,
                processData: false
            });
        }

        if(app_._is_simple){
            console.log(app_._urlToSend,
                    app_._method,
                    app_._data,
                    app_._dataType);
              return $.ajax({
                    url: app_._urlToSend,
                    type: app_._method,
                    data: app_._data,
                    dataType : app_._dataType,

                }).always(function(){
                    if (!jQuery.isEmptyObject(app_._beforeSend)) {
                        app_.spinner.hide(app_._beforeSend);
                    }

                });
        }

       return $.ajax({
            url: app_._urlToSend,
            type: app_._method,
            data: app_._data,
            contentType:false,
             cache: false,
             processData:false,
             dataType : app_._dataType,

        }).always(function(){
            if (!jQuery.isEmptyObject(app_._beforeSend)) {
                app_.spinner.hide(app_._beforeSend);
            }
        });
    },
    spinner:{
        show:function(_element){
            _element.css("text-align", "center")
                    .css("position", "relative")
                    .prepend('<div id="_overload"><i class="fa fa-spinner"></i></div>');

            _element.find("#_overload")
                    .css({
                        "z-index": 999999,
                        "position": "absolute",
                        "width":" 100%",
                        "padding": "5%",
                        "height":"100%",
                        "top":"0",
                        "left":"0",
                        "background-color":'rgba(255,255,255,0.4)'
                    })
        },

        hide:function(_element){
            _element.find("#_overload").remove();
        }
    },

    confi_data_table:{
        /*  {
          "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        } */
        "language": {
            searchPlaceholder: "Buscar",
            "sProcessing": "Process...",
            "sLengthMenu": "Mostrar _MENU_ registros",
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
                "sPrevious": "Before"
            },
            "oAria": {
                "sSortAscending": ": Activate to sort the column in ascending order",
                "sSortDescending": ": Activate to sort the column in descending order"
            }
        }
    },
    fnUnloadTable: function (oTable) {
        if (oTable != null) {
            oTable.fnClearTable()
            oTable.fnDraw();
            oTable.fnDestroy();
            oTable.empty();
        }
    },
    setDatatable:function($_table){
        return $_table.DataTable(App.confi_data_table);
    }

}


//para hacer aleatorio en una cadena en especial para usarse en la generacion de contraseña
//referencia https://stackoverflow.com/questions/3943772/how-do-i-shuffle-the-characters-in-a-string-in-javascript
String.prototype.shuffle = function () {
    var a = this.split(""),
        n = a.length;

    for(var i = n - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = a[i];
        a[i] = a[j];
        a[j] = tmp;
    }
    return a.join("");
}

/**
 *
 * @param settings
 * @param helpPage
 * @param message
 */
$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
    toastr.success(message);
}
