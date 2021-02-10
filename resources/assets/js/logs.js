var $TablLogApp= null, $TablLogFile= null;

App.confi_data_table ={
            "bPaginate": true,
            "bSortable": false,
            "fnHeaderCallback": function (nHead, aData, iStart, iEnd, aiDisplay) {
                $(nHead).addClass("bg-primary").find("th").addClass("white");
                columnas_ = [];
                //console.log(aData);
                $(nHead).find("th").each(function (i) {
                    columnas_.push({ id: i, nombre: $(this)[0].innerHTML})
                    console.log($(this), i);
                })
            },mark: true,
            columns: [
               { "mData": "id", "bSortable": true, "sTitle": "#" },
               { "mData": "action", "bSortable": false, "sTitle": "Action" },
               { "mData": "window", "bSortable": false, "sTitle": "Window" },
               { "mData": "fullname", "bSortable": false, "sTitle": "User" },
               { "mData": "message", "bSortable": false, "sTitle": "Message" },
               { "mData": "date", "bSortable": false, "sTitle": "Date" }],
            "language": {
                searchPlaceholder: "Search ...",
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
                    "sPrevious": "Previous"
                },
                "oAria": {
                    "sSortAscending": ": Activate to sort the column in ascending order",
                    "sSortDescending": ": Activate to sort the column in descending order"
                }
            },
            "order":[1,'desc'],
           "serverSide": true,
           "processing": true,
           "ordering": false,
           "paging": true,
           //"searching": { "regex": true },
            "sDom":'<"top"l>rt<"bottom"ip>',

        };

App.confi_data_table.ajax=$(".log-app").data("log_app_route");
console.log(App.confi_data_table)
$TablLogApp = App.setDatatable($("#tbLogApp"));
//OS','browser','device','ip','server_file.name','server_file.owner'
App.confi_data_table ={
            "bPaginate": true,
            "bSortable": false,
            "fnHeaderCallback": function (nHead, aData, iStart, iEnd, aiDisplay) {
                $(nHead).addClass("bg-primary").find("th").addClass("white");
                columnas_ = [];
                //console.log(aData);
                $(nHead).find("th").each(function (i) {
                    columnas_.push({ id: i, nombre: $(this)[0].innerHTML})
                    console.log($(this), i);
                })
            },mark: true,
            columns: [
                    { "mData": "id", "bSortable": true, "sTitle": "#" },
                    { "mData": "OS", "bSortable": true, "sTitle": "Operative System" },
                    { "mData": "ip", "bSortable": true, "sTitle": "IP" },
                    { "mData": "device", "bSortable": true, "sTitle": "Device" },
                    { "mData": "browser", "bSortable": true, "sTitle": "Browser" },
                    { "mData": "name", "bSortable": true, "sTitle": "File name" },
                    { "mData": "fullname", "bSortable": true, "sTitle": "User" },
                    { "mData": "date", "bSortable": true, "sTitle": "Date" },
                ],
            "language": {
                searchPlaceholder: "Search ...",
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
                    "sPrevious": "Previous"
                },
                "oAria": {
                    "sSortAscending": ": Activate to sort the column in ascending order",
                    "sSortDescending": ": Activate to sort the column in descending order"
                }
            },
            "order":[1,'desc'],
           "serverSide": true,
           "processing": true,
           "ordering": false,
           "paging": true,
           //"searching": { "regex": true },
            "sDom":'<"top"l>rt<"bottom"ip>',

        };

App.confi_data_table.ajax=$(".log-file").data("log_file_route");
$TablLogFile = App.setDatatable($("#tbLogFile"));



 /* if (oTable != null) {
        oTable.destroy();
    }
    $args = $_args;
    $('#tbtCheques').css('width', "100%");

    oTable = $('#tbtCheques').DataTable($_args); */
