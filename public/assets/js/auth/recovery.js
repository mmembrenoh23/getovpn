$("#frmRecovery").on("submit",function(e){
    e.preventDefault();

    var route = $(this).attr("action");
    console.log(route);
})
