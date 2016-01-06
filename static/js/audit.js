var __MEMBER_DATA = null;

function show_modal(){
            $('#modal_next').modal('show');
}
function chose_others_zero(item) {
    //console.log(item);
    for (var item in getData) {
        if (item != undefined) {
            //console.log(getData[item]);
            $($('.chosen-select')[0]).find("option[value='"+getData[item]+"']").attr("selected",true);
            $($('.chosen-select')[0]).trigger("chosen:updated");
        }
    }
    $('#modal_next').modal('show');
}
function chose_others(_id) {
    $('#modal_next_').modal('hide');
    $('#rid').val(_id);
    $('#modal_next').modal('show');
}
var getData = {};
function bind_event(){
    $('.texport').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            console.log(_id);
            $('#report_id').val(_id);
        });
    });
    $('.tdetail').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            var _decision = $(this).data('decision');
            if(_decision != undefined)
            {
                location.href = __BASE + "reports/show/" + _id + "/" + _decision;
            }
            else
            {
                location.href = __BASE + "reports/show/" + _id;
            }
        });
    });
    $('.tpass').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            console.log("ehhhe");
            $.ajax({
                type:"GET",
                url:__BASE + "reports/check_permission",
                data: {
                    rid:_id
                },
                dataType: "json",
                success: function(data){
                    if (data['status'] > 0) {
                        getData = data['data'].suggestion;
                        if (data['data'].complete == 0) {
                            $('#rid').val(_id);
                            chose_others_zero(_id);
                        } else {
                            $('#rid_').val(_id);
                            if(close_directly == 0) {
                                $('#modal_next_').modal('show');
                            } else {
                                $('#permit_form').submit();
                            }
                        }
                    }
                }
            });
        });
    });
    $('.tdown').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            var chosen_id = [];
            chosen_id.push(_id);
            console.log(chosen_id);
            $.ajax({
                url:__BASE + "/bills/download_single_report",
                method:"post",
                dataType:"json",
                //data:{"chosenids":chosenids},
                data:{"chosenids":chosen_id},
                success:function(data){
                    location.href = data['url'];
                },
                error:function(a,b)
                {
                }
            });
        });
    });
    $('.tdeny').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            $('#div_id').val(_id);
            $('#comment_dialog').modal('show');
        });
    });
}

var selectRows = [];
var IF_SELECT_ALL = 0;
var FLAG = 1;
jQuery(grid_selector).jqGrid({
    url: __BASE + 'reports/listauditdata?filter=' + filter,
    mtype: "GET",
    datatype: "local",
    multiselect: can_export_excel,
    height: 250,
    colNames:['报销单ID', '报销单模板', '标题', '消费类型', '创建日期', '金额','消费条目数','发起人', '附件', '状态', '操作', ''],
    loadonce: true,
    //rownumbers: true, // show row numbers
    caption: "报销单列表",
    editurl: __BASE + 'reports/save',
    datatype: "json",
    loadtext: '',
    autowidth: true,

    viewsortcols : [true,'vertical',true],
    colModel:[
    {name:'id', index:'id', width:20,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'report_template', index:'report_template', width:40,editable: false,editoptions:{size:"20",maxlength:"50"}},
    {name:'title', index:'title', width:40,editable: false,editoptions:{size:"20",maxlength:"50"}},
    {name:'prove_ahead', index:'prove_ahead', width:40,editable: false,editoptions:{size:"20",maxlength:"50"},search:false},
    {name:'date_str', index:'date_str', width:50,editable: false,editoptions:{size:"20",maxlength:"50"},search:false},
    {name:'amount', index:'amount',sorttype: myCustomSort, width:50, formatter:'currency', formatoptions:{decimalPlaces: 2,thousandsSeparator:",",prefix:'￥'}, editable: true,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'item_count', index:'item_count', width:50,editable: false,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'author', index:'author', width:50,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'attachments', index:'attachments', width:18,editable: false,editoptions:{size:"15",maxlength:"20"}},
    {name:'status_str',index:'status_str', width:40, editable: false,editoptions: {size:"20", maxlength : "40",search:false}/*,unformat: aceSwitch*/},
    {name:'options',index:'options', width:40, editable: false,editoptions: {size:"20", maxlength : "50"},unformat: aceSwitch,search:false},
    { name : 'lastdt', index : 'lastdt', hidden:true , sortable : true,search:false}
    ],
    sortorder: "desc",
    sortorder: "desc",
    loadComplete : function(data) {
        if (data instanceof Array) {
            var IF_TEMPLATE = false;
            for (var i = 0; i < data.length; i++)
                if ("report_template" in data[i])
                    IF_TEMPLATE = true;
            if (!IF_TEMPLATE) {
                jQuery(grid_selector).jqGrid('hideCol','report_template');
                $(window).resize();
            }
        }
        jQuery.each(selectRows,function(index,row){
            jQuery(grid_selector).jqGrid('setSelection',row);
        });
        if (IF_SELECT_ALL) 
            $(".cbox").each(function(index, el) {
                $(".cbox")[index].checked = true;
            });
        bind_event();
        var table = this;
        this.p.lastSelected = lastSelected;
        setTimeout(function(){
            //styleCheckbox(table);
            updateActionIcons(table);
            updatePagerIcons(table);
            enableTooltips(table);
            if (FLAG) {
                doSearch();
                FLAG = 0;
            }
        }, 0);
    },
    onSelectAll : function(aRows, status) {
        if (status) {
            IF_SELECT_ALL = 1;
            var array_selectRows = jqgrid_choseall_plus(grid_selector);
            jQuery.each(array_selectRows,function(index,rowid){
                if (jQuery.inArray(rowid,selectRows) == -1) {
                    selectRows.push(rowid);
                }
            });
        } else {
            jQuery.each(aRows,function(index,rowid){
                selectRows.splice(jQuery.inArray(rowid,selectRows),1);
            });
            IF_SELECT_ALL = 0;
        }
    },
    onSelectRow : function(rowid, status) {
        if (status) {
            if (jQuery.inArray(rowid,selectRows) == -1) {
                selectRows.push(rowid);
            }
        } else {
            selectRows.splice(jQuery.inArray(rowid,selectRows),1);
        }
    },

    //page: 1,
    width: 780,
    height: 380,
    rowNum: 10,
    scrollPopUp:true,
    scrollLeftOffset: "83%",
    viewrecords: true,
    //scroll: 1, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
    emptyrecords: '没有数据', // the message will be displayed at the bottom
    pager : pager_selector,
    //viewsortcols: [true,'vertical',false],
    viewsortcols : [true,'vertical',true]

});

jQuery(grid_selector).jqGrid('navGrid', pager_selector, {
    //navbar options
    edit: false,
    closeAfterEdit: true,
    editicon : 'ace-icon fa fa-pencil blue',
    add: can_export_excel,
    addicon : 'ace-icon fa fa-file-excel-o',
    addtitle: '导出excel',
    addfunc : function(rowids, p){
        var form=$("<form>");
        form.attr("style","display:none");
        form.attr("target","");
        form.attr("method","post");
        form.attr("action", __BASE + "/reports/exports");
        var input1=$("<input>");
        input1.attr("type","hidden");
        input1.attr("name","ids");
        input1.attr("value", selectRows.join(','));
        $("body").append(form);
        form.append(input1);
        form.submit();
    },
    del: false,
    search: false,
    searchicon : 'ace-icon fa fa-search orange',
    refresh: false,
    refreshicon : 'ace-icon fa fa-refresh green',
    view: false,
    viewicon : 'ace-icon fa fa-search-plus grey',
},
{
    //edit record form
    closeAfterEdit: true,
    //width: 700,
    recreateForm: true,
    beforeShowForm : function(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
        //style_edit_form(form);
    }
},
{
    //new record form
    //width: 700,
    closeAfterAdd: true,
    recreateForm: true,
    viewPagerButtons: false,
    beforeShowForm : function(e) {
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
            .wrapInner('<div class="widget-header" />');
        //style_edit_form(form);
    }
},
{
    //delete record form
    recreateForm: true,
    beforeShowForm : function(e) {
        var form = $(e[0]);
        if(form.data('styled')) return false;

        form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />');
        //style_delete_form(form);

        form.data('styled', true);
    },
    onClick : function(e) {
        alert(1);
    }
},
{
    //search form
    recreateForm: true,
    afterShowSearch: function(e){
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            style_search_form(form);
    },
    afterRedraw: function(){
        style_search_filters($(this));
    }
    ,
},
{
    //view record form
    recreateForm: true,
    beforeShowForm: function(e){
        var form = $(e[0]);
        form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
    }
}
);

$(document).ready(function () {
    $(grid_selector).jqGrid();
    $('.ui-jqdialog').remove();

});

