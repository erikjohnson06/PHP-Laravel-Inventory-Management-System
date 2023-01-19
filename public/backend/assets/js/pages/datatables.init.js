jQuery(document).ready(function () {
    jQuery("#datatable").DataTable(
            {language: {
                    paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }});

    var a = jQuery("#datatable-buttons").DataTable(
            {lengthChange: !1,
                language: {
                    paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                },
                buttons: ["copy", "excel", "pdf", "colvis"]});

    //a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
    jQuery(".dataTables_length select").addClass("form-select form-select-sm"),
            jQuery("#selection-datatable").DataTable({
        select: {style: "multi"},
        language: {
            paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
        drawCallback: function () {
            jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }}),
            jQuery("#key-datatable").DataTable(
            {keys: !0,
                language: {
                    paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }}),
            //a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
            jQuery(".dataTables_length select").addClass("form-select form-select-sm"),
            jQuery("#alternative-page-datatable").DataTable(
            {pagingType: "full_numbers",
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                            jQuery(".dataTables_length select").addClass("form-select form-select-sm")
                }}),
            jQuery("#scroll-vertical-datatable").DataTable(
            {scrollY: "350px", scrollCollapse: !0, paging: !1,
                language: {
                    paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }}),
            jQuery("#complex-header-datatable").DataTable(
            {language: {
                    paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
                drawCallback: function () {
                    jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                            jQuery(".dataTables_length select").addClass("form-select form-select-sm")
                },
                columnDefs: [{visible: !1, targets: -1}]}),
            jQuery("#state-saving-datatable").DataTable({
        stateSave: !0,
        language: {
            paginate: {previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>"}},
        drawCallback: function () {
            jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                    jQuery(".dataTables_length select").addClass("form-select form-select-sm")
        }})
});