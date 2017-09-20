/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Component: Datatable
 * 
 */
var handleDataTableButtons = function() {
        "use strict";
        0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
            responsive: !0,
            paging:false,
            searching: false,
            buttons: false,
            info: false,
            "aoColumnDefs" : [ {
                "bSortable" : false,
                "aTargets" : [ "no-sort" ]
                } ],
            "scrollY":"calc(100vh - (188px + 48px))",
        })
    },
    TableManageButtons = function() {
        "use strict";
        return {
            init: function() {
                handleDataTableButtons()
            }
        }
    }();