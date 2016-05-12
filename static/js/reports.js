formatMoney = function(str, places, symbol, thousand, decimal) {
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : "￥";
    thousand = thousand || ",";
    decimal = decimal || ".";
    var number = parseFloat(str),
        negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
};
try {
    jQuery(grid_selector).jqGrid({
        url: '/reports/listdata',
        multiselect: false,
        mtype: "GET",
        datatype: "local",
        height: 250,
        colNames:['报销单ID', '报销单模板', '标题', '类型',  '创建日期', '金额','消费条目数', '附件', '状态', '操作', '报销单模板ID'],
        loadonce: true,
        caption: "报销单列表",
        editurl: '/reports/save',
        datatype: "json",
        viewsortcols: [true, 'vertical', true],
        autowidth: true,
        loadtext: '',
        colModel: [{
            name: 'id',
            index: 'id',
            width: 30,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "30"
            }
        }, {
            name: 'report_template',
            index: 'report_template',
            width: 50,
            editable: false,
            editoptions: {
                size: "30",
                maxlength: "50"
            }
        }, {
            name: 'title',
            index: 'title',
            width: 50,
            editable: false,
            editoptions: {
                size: "30",
                maxlength: "50"
            },
            search: true
        }, {
            name: 'prove_ahead',
            index: 'prove_ahead',
            width: 40,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "50"
            },
            search: false
        }, {
            name: 'date_str',
            index: 'date_str',
            width: 50,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "30"
            },
            search: false
        }, {
            name: 'amount',
            sorttype: myCustomSort,
            formatter: function(value, options, row) {
                if (row['item_count'] == 0) {
                    return '无消费';
                } else {
                    return formatMoney(value);
                }
            },
            formatoptions: {
                decimalPlaces: 2,
                thousandsSeparator: ",",
                prefix: '￥'
            },
            index: 'amount',
            width: 50,
            editable: true,
            editoptions: {
                size: "20",
                maxlength: "30"
            },
            search: false
        }, {
            name: 'item_count',
            index: 'item_count',
            width: 40,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "40"
            },
            search: false
        }, {
            name: 'attachments',
            index: 'attachments',
            width: 19,
            editable: false,
            editoptions: {
                size: "15",
                maxlength: "20"
            },
            search: false
        }, {
            name: 'status_str',
            index: 'status_str',
            width: 40,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "30"
            } /*,unformat: aceSwitch*/ ,
            search: false
        }, {
            name: 'options',
            index: 'options',
            width: 40,
            editable: false,
            editoptions: {
                size: "20",
                maxlength: "40"
            },
            unformat: aceSwitch,
            search: false
        }, {
            name: 'template_id',
            index: 'template_id',
            hidden: true
        }],
        loadComplete: function(data) {
            if (data instanceof Array) {
                var IF_TEMPLATE = false;
                for (var i = 0; i < data.length; i++)
                    if ("report_template" in data[i]) IF_TEMPLATE = true;
                if (!IF_TEMPLATE) {
                    jQuery(grid_selector).jqGrid('hideCol', 'report_template');
                    $(window).resize();
                }
            }
            var table = this;
            setTimeout(function() {
                //styleCheckbox(table);
                updateActionIcons(table);
                updatePagerIcons(table);
                enableTooltips(table);
            }, 0);
        },
        searchoptions: {
            sopt: ["eq", "ne", "lt", "le", "gt", "ge", "nu", "nn", "in", "ni"]
        },

        onSelectRow: function(rowId, status, e) {
            var $target = $(e.target || e.toElement);
            var row = $(this).jqGrid ('getRowData', rowId);
            var arr = $(this).jqGrid ('getGridParam', rowId);
            if($target.hasClass('tdetail')) {
                return location.href = '/reports/show/' + row.id + '?tid='+row.template_id;
            }

            if($target.hasClass('tapprove')) {
                approve_report(rowId);
                return
            }

            if($target.hasClass('texport')) {
                $('#report_id').val(rowId);
                return
            }

            if($target.hasClass('tedit')) {
                location.href = "/reports/edit/" + rowId  + '?tid='+row.template_id;
                return
            }

            if($target.hasClass('tdeny')) {
                $('#div_id').val(rowId);
                $('#comment_dialog').modal('show');
            }

            if($target.hasClass('tdel')) {
                if (confirm('是否确认删除此报销单？')) {
                    var _id = $(this).data('id');
                    location.href =  "/reports/del/" + rowId;
                }
            }

            if($target.hasClass('tconfirm')) {
                if (confirm('是否确认删除此报销单？')) {
                    if (confirm('确认已收款？')) {
                        $.ajax({
                            url: "/reports/confirm_success",
                            method: 'post',
                            dataType: 'json',
                            data: {
                                'rid': rowId
                            },
                            success: function(data) {
                                location.href = __BASE + "/reports";
                            },
                            error: function(a, b, c) {}
                        });
                    }
                }
            }

            if($target.hasClass('tdown')) {
                $.ajax({
                    url: "/bills/download_report",
                    method: "post",
                    dataType: "json",
                    data: {
                        "chosenids": [rowId]
                    },
                    success: function(data) {
                        location.href = data['url'];
                    },
                    error: function(a, b) {}
                });
            }
        },
        width: 780,
        height: 380,
        rowNum: 10,
        scrollPopUp: true,
        scrollLeftOffset: "83%",
        viewrecords: true,
        //scroll: 1, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
        emptyrecords: '没有数据', // the message will be displayed at the bottom
        pager: pager_selector,
        //viewsortcols: [true,'vertical',false],
        viewsortcols: [true, 'vertical', true]
    });
    jQuery(grid_selector).jqGrid('navGrid', pager_selector, { //navbar options
        edit: false,
        closeAfterEdit: true,
        editicon: 'ace-icon fa fa-pencil blue',
        add: false,
        addicon: 'ace-icon fa fa-plus-circle purple',
        del: false,
        delicon: 'ace-icon fa fa-trash-o red',
        search: false,
        searchicon: 'ace-icon fa fa-search orange',
        refresh: false,
        refreshicon: 'ace-icon fa fa-refresh green',
        view: false,
        viewicon: 'ace-icon fa fa-search-plus grey',
    }, {
        //edit record form
        closeAfterEdit: true,
        //width: 700,
        recreateForm: true,
        beforeShowForm: function(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
            //style_edit_form(form);
        }
    }, {
        //new record form
        //width: 700,
        closeAfterAdd: true,
        recreateForm: true,
        viewPagerButtons: false,
        beforeShowForm: function(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
            //style_edit_form(form);
        }
    }, {
        //delete record form
        recreateForm: true,
        beforeShowForm: function(e) {
            var form = $(e[0]);
            if (form.data('styled')) return false;
            form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
            //style_delete_form(form);
            form.data('styled', true);
        },
        onClick: function(e) {
            alert(1);
        }
    }, {
        //search form
        recreateForm: true,
        afterShowSearch: function(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            style_search_form(form);
        },
        afterRedraw: function() {
            style_search_filters($(this));
        },
        /**
                      multipleSearch: true,
                      multipleGroup:true,
                      showQuery: true
                      */
    }, {
        //view record form
        recreateForm: true,
        beforeShowForm: function(e) {
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
        }
    })
} catch (e) {}
$(document).ready(function() {
    try {
        $(grid_selector).jqGrid();
        $('.ui-jqdialog').remove();
    } catch (e) {}
});

function submit_check() {
    canGetPostData().done(function(data) {
        if (!data) {
            return
        }
        $.ajax({
            type: 'POST',
            url: __BASE + "reports/check_submit",
            data: data,
            dataType: 'json',
            success: function(data) {
                if (data.status > 0 && data.data.complete > 0) {
                    do_post();
                } else {
                    var suggest = data.data.suggestion;
                    var _names = [];
                    $(suggest).each(function(idx, value) {
                        $('#receiver option').each(function(_idx, _val) {
                            var _value = $(_val).attr('value');
                            var desc = $(_val).html();
                            if (_value == value) {
                                _names.push(desc);
                            }
                        });
                    });
                    $('#hidden_receiver').val(suggest.join(','));
                    $('#label_receiver').html(_names.join(','));
                    $('#modal_next').modal('show');
                }
                return false;
            }
        });
    })
}
