/**
 * Created by Hoang Dai on 20/03/2017.
 */

function khoitaobangDATA_GROUP(id_bang, data, columns, column_count, column_group) {
    return $("#" + id_bang).DataTable({
        data: data,
        language: {
            decimal: '',
            emptyTable: "Không có dữ liệu trong bảng",
            info: "Đang xem _START_ tới _END_ của _TOTAL_ ",
            infoEmpty: "Đang xem 0 tới 0 của 0 ",
            infoFiltered: "(Đã lọc từ _MAX_ đối tượng)",
            lengthMenu: "Xem _MENU_ ",
            loadingRecords: "Đang tải...",
            processing: "Đang xử lí...",
            search: "Tìm kiếm:",
            zeroRecords: "Không tìm thấy bản ghi phù hợp",
            paginate: {
                first: "Đầu tiên",
                last: "Cuối cùng",
                next: "Tiếp",
                previous: "Trở lại"
            }
        },
        columns: columns,
        dom: "Bfrtip",
        select: true,
        buttons: [
            {
                extend: "copy",
                className: "btn-sm"
            },
            {
                extend: "csv",
                className: "btn-sm"
            },
            {
                extend: "excel",
                className: "btn-sm"
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm"
            },
            {
                extend: "print",
                className: "btn-sm"
            }
        ],
        pageLength: 15,
        responsive: true,
        columnDefs: [
            {"visible": false, "targets": column_group}
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;

            api.column(column_group, {page: 'current'}).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="' + column_count + '">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        },
        order: [[0, "desc"]]
    });
}

function khoitaobangDATA(id_bang, data, columns) {
    return $("#" + id_bang).DataTable({
        data: data,
        columns: columns,
        select: true,
        scrollY: "400px",
        scrollCollapse: true,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                className: "btn-sm"
            },
            {
                extend: "csv",
                className: "btn-sm"
            },
            {
                extend: "excel",
                className: "btn-sm"
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm"
            },
            {
                extend: "print",
                className: "btn-sm"
            }
        ],
        pageLength: 150,
        order: [[0, "desc"]]
    });
}

function khoitaobang(id_bang) {
    return $("#" + id_bang).DataTable({
        dom: "Bfrtip",
        select: true,
        buttons: [
            {
                extend: "copy",
                className: "btn-sm"
            },
            {
                extend: "csv",
                className: "btn-sm"
            },
            {
                extend: "excel",
                className: "btn-sm"
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm"
            },
            {
                extend: "print",
                className: "btn-sm"
            }
        ],
        pageLength: 15,
        responsive: true,
        order: [[0, "desc"]]
    });
}

function khoitaobangAjax(id_bang, ajaxURLData, dataColumn) {
    return $("#" + id_bang).DataTable({
        ajax: ajaxURLData,
        columns: dataColumn,
        fixedHeader: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                className: "btn-sm"
            },
            {
                extend: "csv",
                className: "btn-sm"
            },
            {
                extend: "excel",
                className: "btn-sm"
            },
            {
                extend: "pdfHtml5",
                className: "btn-sm"
            },
            {
                extend: "print",
                className: "btn-sm"
            }
        ],
        pageLength: 15,
        responsive: true,
        order: [[0, "desc"]]
    });
}


/**
 * Date / time formats often from back from server APIs in a format that you
 * don't wish to display to your end users (ISO8601 for example). This rendering
 * helper can be used to transform any source date / time format into something
 * which can be easily understood by your users when reading the table, and also
 * by DataTables for sorting the table.
 *
 * The [MomentJS library](http://momentjs.com/) is used to accomplish this and
 * you simply need to tell it which format to transfer from, to and specify a
 * locale if required.
 *
 * This function should be used with the `dt-init columns.render` configuration
 * option of DataTables.
 *
 * It accepts one, two or three parameters:
 *
 *     $.fn.dataTable.render.moment( to );
 *     $.fn.dataTable.render.moment( from, to );
 *     $.fn.dataTable.render.moment( from, to, locale );
 *
 * Where:
 *
 * * `to` - the format that will be displayed to the end user
 * * `from` - the format that is supplied in the data (the default is ISO8601 -
 *   `YYYY-MM-DD`)
 * * `locale` - the locale which MomentJS should use - the default is `en`
 *   (English).
 *
 *  @name datetime
 *  @summary Convert date / time source data into one suitable for display
 *  @author [Allan Jardine](http://datatables.net)
 *  @requires DataTables 1.10+
 *
 *  @example
 *    // Convert ISO8601 dates into a simple human readable format
 *    $('#example').DataTable( {
 *      columnDefs: [ {
 *        targets: 1,
 *        render: $.fn.dataTable.render.moment( 'Do MMM YYYYY' )
 *      } ]
 *    } );
 *
 *  @example
 *    // Specify a source format - in this case a unix timestamp
 *    $('#example').DataTable( {
 *      columnDefs: [ {
 *        targets: 2,
 *        render: $.fn.dataTable.render.moment( 'X', 'Do MMM YY' )
 *      } ]
 *    } );
 *
 *  @example
 *    // Specify a source format and locale
 *    $('#example').DataTable( {
 *      columnDefs: [ {
 *        targets: 2,
 *        render: $.fn.dataTable.render.moment( 'YYYY/MM/DD', 'Do MMM YY', 'fr' )
 *      } ]
 *    } );
 */


// UMD
(function (factory) {
    "use strict";

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], function ($) {
            return factory($, window, document);
        });
    }
    else if (typeof exports === 'object') {
        // CommonJS
        module.exports = function (root, $) {
            if (!root) {
                root = window;
            }

            if (!$) {
                $ = typeof window !== 'undefined' ?
                    require('jquery') :
                    require('jquery')(root);
            }

            return factory($, root, root.document);
        };
    }
    else {
        // Browser
        factory(jQuery, window, document);
    }
})
(function ($, window, document) {


    $.fn.dataTable.render.moment = function (from, to, locale) {
        // Argument shifting
        if (arguments.length === 1) {
            locale = 'en';
            to = from;
            from = 'YYYY-MM-DD';
        }
        else if (arguments.length === 2) {
            locale = 'en';
        }

        return function (d, type, row) {
            var m = window.moment(d, from, locale, true);

            // Order and type get a number value from Moment, everything else
            // sees the rendered value
            return m.format(type === 'sort' || type === 'type' ? 'x' : to);
        };
    };
});