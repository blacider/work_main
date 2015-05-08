var pager_selector = "#grid-pager";
var grid_selector = "#grid-table";


function bind_event(){
    $('.tdetail').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/show/" + _id;
        });
    });
    $('.tdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/del/" + _id;
        });
    });
    $('.tedit').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "items/edit/" + _id;
        });
    });
}

jQuery(grid_selector).jqGrid({

    url: __BASE + 'items/listdata',
    //multiselect: true,
    mtype: "GET",
    datatype: "local",
    height: 250,
    colNames:['创建时间', '类别', '金额', '类型', '商家', '状态', '操作'],
    loadonce: true,
    //rownumbers: true, 
    caption: "消费列表",
    editurl: __BASE + 'items/save',
    datatype: "json",
    autowidth: true,
    hoverrows : true,

    colModel:[

    
    {name:'createdt', index:'createdt', width:120,editable: true,editoptions:{size:"20",maxlength:"30"}},
    {name:'type', index:'type', width:50,editable: true,editoptions:{size:"20",maxlength:"30"}},
    {name:'amount', index:'amount', width:150,editable: true,editoptions:{size:"20",maxlength:"30"}},
    {name:'cate_str', index:'cate_str', width:100,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'merchants', index:'merchants', width:120,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'status_str',index:'status_str', width:55, editable: false,editoptions: {size:"20", maxlength : "60"},unformat: aceSwitch},
    {name:'options',index:'options', width:55, editable: false,editoptions: {size:"20", maxlength : "60"},unformat: aceSwitch},
    ], 
    stateSave: true,
    loadComplete : function() {
        bind_event();
        var table = this;
        setTimeout(function(){
            styleCheckbox(table);
            updateActionIcons(table);
            updatePagerIcons(table);
            enableTooltips(table);
        }, 0);
    },


    //page: 1,
    width: 780,
    height: 380,
    rowNum: 10,
    scrollPopUp:true,
    scrollLeftOffset: "83%",
    info:     true,
    viewrecords : true,
    //viewrecords: true,
    scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
    emptyrecords: '没有费用', // the message will be displayed at the bottom 
    pager : pager_selector,

    });

    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
                edit: false,
        editicon : 'ace-icon fa fa-pencil blue',
        add: false,
        addicon : 'ace-icon fa fa-plus-circle purple',
        del: false,
        delicon : 'ace-icon fa fa-trash-o red',
        search: false,
        searchicon : 'ace-icon fa fa-search orange',
        refresh: false,
        refreshicon : 'ace-icon fa fa-refresh green',
        view: false,
        viewicon : 'ace-icon fa fa-search-plus grey',
            },
            {
                //edit record form
                //closeAfterEdit: true,
                //width: 700,
                recreateForm: true,
                beforeShowForm : function(e) {
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                        style_edit_form(form);
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
                        .wrapInner('<div class="widget-header" />')
                        style_edit_form(form);
                }
            },
            {
                //delete record form
                recreateForm: true,
                beforeShowForm : function(e) {
                    var form = $(e[0]);
                    if(form.data('styled')) return false;

                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
                        style_delete_form(form);

                    form.data('styled', true);
                },
                onClick : function(e) {
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
                    multipleSearch: true,
                    /**
                      multipleGroup:true,
                      showQuery: true
                      */
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function(e){
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
    )

$(document).ready(function () {
    $(grid_selector).jqGrid();
    $('.ui-jqdialog').remove();

});



