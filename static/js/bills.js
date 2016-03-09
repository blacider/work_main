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

function bind_event(){
    $('.tdetail').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "reports/show/" + _id;
        });
    });
    $('.tapprove').each(function(){
        $(this).click(function(){
            if(confirm("确认已经付款吗？") == true){
            var _id = $(this).data('id');
            location.href = __BASE + "bills/marksuccess/" + _id + "/0";
            }
        });
    });
    $('.tdeny').each(function(){
        $(this).click(function(){
            if(confirm("确认取消付款吗？") == true){
            var _id = $(this).data('id');
            location.href = __BASE + "bills/marksuccess/" + _id + "/1";
            }
        });
    });
    /*
    $('.tdel').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "reports/del/" + _id;
        });
    });
    */
    $('.tedit').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "reports/edit/" + _id;
        });
    });
    $('.texport').each(function(){
    	$(this).click(function(){
	    var _id = $(this).data('id');
	    $('#report_id').val(_id);
	});
    });
}

var selectRows = [];    
var IF_SELECT_ALL = 0;
try{

var keyword = $('#globalSearchText').val();
keyword = encodeURIComponent(keyword);
var dept = $('select[name=gids]').val();
var startdate = $('#date-timepicker1').val();
var enddate = $('#date-timepicker2').val();

var query = {
  keyword: keyword,
  dept: dept,
  startdate: startdate,
  enddate: enddate
}
    
jQuery(grid_selector).jqGrid({
    url: __BASE + 'bills/listdata/' + __STATUS +'?'+ $.param(query),
    mtype: "GET",
    datatype: "local",
    height: 250,
    multiselect: true,
    loadtext: '',
    colNames:['报销单ID', '报销单模板', '提交日期','报销单名', '消费类型', '条目数', '提交者', '金额', '附件', '状态', '操作' , '部门'],
    loadonce: true,
    caption: "费用审计",
    editurl: __BASE + 'bills/save',
    datatype: "json",
    autowidth: true,
    hoverrows : true,

    colModel:[
    {name:'id', index:'id', width:30,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'report_template', index:'report_template', width:60,editable: false,editoptions:{size:"20",maxlength:"50"}},
    {name:'date_str', index:'date_str', width:60,editable: false,editoptions:{size:"20",maxlength:"60"},search:false},
    {name:'title', index:'title', width:40,editable: false,editoptions:{size:"20",maxlength:"40"}},
    {name:'prove_ahead', index:'prove_ahead', width:50,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'item_count', index:'item_count', width:30,editable: false,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'nickname', index:'nickname', width:50,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'amount',sorttype: myCustomSort,formatter: function(value, options, row) {
        if(row['item_count'] == 0) {
            return '无消费';
        } else {
            return formatMoney(value);
        }
    }, formatoptions:{decimalPlaces: 2,thousandsSeparator:",",prefix:'￥'}, index:'amount', width:50,editable: true,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'attachments',index:'attachments', width:22, editable: true,edittype:"select",editoptions: {size:"20",maxlength:"30",value:"4:通过;3:拒绝"},unformat: aceSwitch,search:false},
    {name:'status_str',index:'status_str', width:40, editable: true,edittype:"select",editoptions: {value:"4:通过;3:拒绝"},unformat: aceSwitch,search:false},
    {name:'options',index:'options', width:50, editable: true,edittype:"select",editoptions: {size:"20",maxlength:"50",value:"4:通过;3:拒绝"},unformat: aceSwitch,search:false},
    {name:'ugs', index:'ugs', width:50,editable: false,editoptions:{size:"20",maxlength:"30"},hidden:true},


    ], 
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
    viewsortcols : [true,'vertical',true],
    rowNum: 10,
    scrollPopUp:true,
    scrollLeftOffset: "83%",
    viewrecords: true,
    scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
    emptyrecords: '没有账单', // the message will be displayed at the bottom 
    pager : pager_selector,

    });
}catch(e) {
    alert(e);
}

try{
    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
            {   //navbar options
                edit: false,
        editicon : 'ace-icon fa fa-pencil blue',
        add: true,
        addicon : 'ace-icon fa fa-database',
        addtitle: '导出U8',
        addfunc : function(rowids, p){
           var rowid = $(grid_selector).jqGrid('getGridParam','selarrrow');
            var form=$("<form>");//定义一个form表单
            form.attr("style","display:none");
            form.attr("target","");
            form.attr("method","post");
            form.attr("action", __BASE + "/reports/export_u8");
            //form.attr("action", __BASE + "/reports/exports");
            var input1=$("<input>");
            input1.attr("type","hidden");
            input1.attr("name","ids");
            input1.attr("value", selectRows.join(','));
            $("body").append(form);//将表单放置在web中
            form.append(input1);
            form.submit();//表单提交
        },
        del: true,
        delicon : 'ace-icon fa fa-file-excel-o',
        deltitle: '导出excel',
        delfunc : function(rowids, p){
            var form=$("<form>");//定义一个form表单
            form.attr("style","display:none");
            form.attr("target","");
            form.attr("method","post");
            //form.attr("action", __BASE + "/reports/export_u8");
            form.attr("action", __BASE + "/reports/exports");
            var input1=$("<input>");
            input1.attr("type","hidden");
            input1.attr("name","ids");
            input1.attr("value", selectRows.join(','));
            $("body").append(form);//将表单放置在web中
            form.append(input1);
            form.submit();//表单提交
        },
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

.navButtonAdd(pager_selector,{
    caption:"",
    title:"下载选中报销单",
    buttonicon:"ace-icon fa fa-download blue" ,
    onClickButton:function() {
//TODO
//         chosenids = $(grid_selector).jqGrid('getGridParam','selarrrow');
        // if (chosenids.length == 0) {
         if (selectRows.length == 0) {
            alert("请选择报销单!");
            return;
         }
       	$.ajax({
		url:__BASE + "/bills/download_report",
		method:"post",
		dataType:"json",
		//data:{"chosenids":chosenids},
		data:{"chosenids":selectRows},
		success:function(data){
		location.href = data['url'];
		},
		error:function(a,b)
		{
		}
	}); 	
    } 
	 });
} catch(e) {
    alert(e);
}

$(document).ready(function () {
    $(grid_selector).jqGrid();
    $('.ui-jqdialog').remove();

});

// new logic
(function () {
    $(window).on('resize', function () {
        var width = window.innerWidth;
        var respWidth = 1400
        if($('#dataSelect_').length==0) {
            respWidth = 1200;
        }
        if(width<respWidth) {
            $('#breadcrumbs').height(100);
            $('#searchBox').css({
                top: 100
            })
        } else {
            $('#breadcrumbs').height(51);
            $('#searchBox').css({
                top: 58
            })
        }
    });
    setTimeout(function() {
        $(window).trigger('resize');
    }, 1000)
})()



