var pager_selector = "#grid-pager";
var grid_selector = "#grid-table";

function bind_event(){
    $('.tdetail').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "groups/show/" + _id;
        });
    });
    $('.tdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "members/delgroup/" + _id;
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

    url: __BASE + 'members/listgroup',
    multiselect: true,
    mtype: "GET",
    height: 250,
    colNames:['组名称','创建时间', '操作'],
    loadonce: true,
    rownumbers: false, // show row numbers
    caption: "公司员工",
    editurl: __BASE + 'groups/save',
    datatype: "json",
    autowidth: true,

    colModel:[
    {name:'name', index:'name', width:150,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'createdt',index:'admin', width:70, editable: false ,edittype:"select",editoptions: {value:"1:管理员;0:员工"},unformat: aceSwitch},
    {name:'options',index:'options', width:70, editable: false},
    ], 
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
    height: 370,
    rowNum: 10,
    scrollPopUp:true,
    scrollLeftOffset: "83%",
    viewrecords: true,
    scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
    //emptyrecords: 'Scroll to bottom to retrieve new page', // the message will be displayed at the bottom 
    //pager : pager_selector,

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
                    multipleSearch: true,
            },
            {
                recreateForm: true,
                beforeShowForm: function(e){
                    var form = $(e[0]);
                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                }
            }
    );
function move_list_items(sourceid, destinationid)
{
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
}


$(document).ready(function () {
    $(grid_selector).jqGrid();
    $('.ui-jqdialog').remove();
    var lst = $(grid_selector).closest("div.ui-jqgrid-view").find("div.ui-jqgrid-hdiv table.ui-jqgrid-htable tr.ui-jqgrid-labels > th.ui-th-column > div.ui-jqgrid-sortable").last();
    //$('<button>').addClass('btn btn-success btn-xs').html('<i class="ace-icon fa fa-plus bigger-110 icon-only"></i>').appendTo(lst).button({ icons: { primary: "fa fa-plus " }, text: false });

    $(lst).click(function (e) {
        location.href = __BASE + "groups/add"
    });

});



