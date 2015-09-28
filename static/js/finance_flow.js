//niu.splice(niu.indexOf(5),1)
function show_modal(){
            $('#modal_next').modal('show');
}
function chose_others_zero(item,nextId) {
    //console.log(item);
    for (var item in getData) {
        if (item != undefined) {
            //console.log(getData[item]);
            $($('.chosen-select')[0]).find("option[value='"+getData[item]+"']").attr("selected",true);
            $($('.chosen-select')[0]).trigger("chosen:updated");
        }
    }
    $('#modal_next').modal('show');
    console.log(nextId);
    if(nextId.length)
    {
            $('#modal_managers').val(nextId[0]).prop('selected',true);
            $('#modal_managers').trigger('chosen:updated');
    }
    else
    {
            $('#mypass').attr('disabled',true).trigger('chosen:updated');
    }
            $('#modal_managers').attr('disabled',true).trigger('chosen:updated');
}
function chose_others(_id) {
    $('#modal_next_').modal('hide');
    $('#rid').val(_id);
    $('#modal_next').modal('show');
}
function bind_event(){
    $('.tdetail').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "reports/show/" + _id;
        });
    });
    $('.tapprove').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            $.ajax({
                type:"GET",
                url:__BASE + "bills/report_finance_permission/" + _id,
                data: {
                    rid:_id
                },
                dataType: "json",
                success: function(data){
                    if (data['status'] > 0) {
                        getData = data['data'].suggestion;
                        if (data['data'].complete == 0) {
                            $('#rid').val(_id);
                            chose_others_zero(_id,data['data'].suggestion);
                        } else {
                            $('#rid_').val(_id);
                            $('#modal_next_').modal('show'); 
                        }
                    }
                }
            });
        });

//        $(this).click(function(){
 //           $('#modal_next_').show(); 
//            if(confirm("确认已经付款吗？") == true){
//            var _id = $(this).data('id');
//            location.href = __BASE + "bills/marksuccess/" + _id + "/0";
//            }
//        });
    });
    /*
    $('.tdeny').each(function(){
        $(this).click(function(){
            if(confirm("确认取消付款吗？") == true){
            var _id = $(this).data('id');
            location.href = __BASE + "bills/marksuccess/" + _id + "/1";
        $(this).click(function(){
            var _id = $(this).data('id');
            $('#div_id').val(_id);
            $('#comment_dialog').modal('show');
        });
            }
        });
    });
    */
    $('.tdeny').each(function() {
        $(this).click(function(){
            var _id = $(this).data('id');
            $('#div_id').val(_id);
            $('#comment_dialog').modal('show');
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

try{
    var FLAG = 1;
jQuery(grid_selector).jqGrid({
    url: __BASE + 'bills/listfinance/' + __STATUS,
    mtype: "GET",
    datatype: "local",
    height: 250,
    multiselect: true,
    loadtext: '',
    colNames:['报告ID', '提交日期','报告名', '条目数', '提交者', '金额', '状态', '操作','部门'],
    loadonce: true,
    caption: "费用审计",
    editurl: __BASE + 'bills/save',
    datatype: "json",
    autowidth: true,
    hoverrows : true,

    colModel:[
    {name:'id', index:'id', width:100,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'date_str', index:'date_str', width:100,editable: false,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'title', index:'title', width:90,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'item_count', index:'item_count', width:50,editable: false,editoptions:{size:"20",maxlength:"30"},search:false},
    {name:'nickname', index:'nickname', width:50,editable: false,editoptions:{size:"20",maxlength:"30"}},
    {name:'amount',index:'amount', sorttype: myCustomSort,width:70, editable: false,editoptions: {size:"20",maxlength:"30"},formatter:'currency', formatoptions:{decimalPlaces: 2,thousandsSeparator:",",prefix:'￥'},unformat: aceSwitch,search:false},
    {name:'status_str',index:'status_str', width:70, editable: true,edittype:"select",editoptions: {value:"4:通过;3:拒绝"},unformat: aceSwitch,search:false},
    {name:'options',index:'options', width:70, editable: true,edittype:"select",editoptions: {value:"4:通过;3:拒绝"},unformat: aceSwitch,search:false},
    {name:'ugs', index:'ugs', width:50,editable: false,editoptions:{size:"20",maxlength:"30"},hidden:true},


    ], 
    loadComplete : function() {
        jQuery.each(selectRows,function(index,row){
            jQuery(grid_selector).jqGrid('setSelection',row);
        });
        bind_event();
        var table = this;
        setTimeout(function(){
            //styleCheckbox(table);
            updateActionIcons(table);
            updatePagerIcons(table);
            enableTooltips(table);
            if (FLAG) {
                doSearch();
                //$("#globalSearch").click();
                FLAG = 0;
            }
        }, 0);
    },
    onSelectAll : function(aRows, status) {
        if (status) {
            jQuery.each(aRows,function(index,rowid){
                if (jQuery.inArray(rowid,selectRows) == -1) {
                    selectRows.push(rowid);
                }
            });
        } else {
            jQuery.each(aRows,function(index,rowid){
                selectRows.splice(jQuery.inArray(rowid,selectRows),1);
            });
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
        delicon : 'ace-icon fa fa-print',
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
    title:"下载选中报告",
    buttonicon:"ace-icon fa fa-download blue" ,
    onClickButton:function() {
//TODO
//         chosenids = $(grid_selector).jqGrid('getGridParam','selarrrow');
        // if (chosenids.length == 0) {
         if (selectRows.length == 0) {
            alert("请选择报告!");
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
	 })
.navButtonAdd(pager_selector,{
    caption:"",
    title:__STATUS == 2 ? "支付选中报告" : "",
    buttonicon:__STATUS == 2 ? "ace-icon fa fa-check green" : "",
    onClickButton:__STATUS == 2 ? function() {
         // chosenids = $(grid_selector).jqGrid('getGridParam','selarrrow');
         chosenids = selectRows;
         if (chosenids.length == 0) {
            alert("请选择报告!");
            return;
         }
         $('#modal-table').modal().css({
             width:'auto',
             'margin-left':function () {
                 return -(($(this).width() - $('#modal-table').width) / 2);
             }
         });
        _part = chosenids.join('/');
        var _part_url = __BASE + 'bills/listdata_new/' + __STATUS + '/' + _part;
  
        $(grid_selector_new).jqGrid('GridUnload');
        jQuery(grid_selector_new).jqGrid({  
            url: _part_url,
            mtype: "GET",
            datatype: "local",
            height: 250,
            multiselect: false, 
            loadtext: '',
            colNames:['提交日期','报告名', '条目数', '提交者', '金额', '状态', '操作'],
            loadonce: true,
            caption: "费用审计",
            editurl: __BASE + 'bills/save',
            datatype: "json",
            autowidth: true,
            shrinkToFit:false,
            hoverrows : true,
            colModel:[
            {name:'date_str', index:'date_str', width:150,editable: false,editoptions:{size:"20",maxlength:"30"}},
            {name:'title', index:'title', width:90,editable: false,editoptions:{size:"20",maxlength:"30"}},
            {name:'item_count', index:'item_count', width:70,editable: false,editoptions:{size:"20",maxlength:"30"}},
            {name:'nickname', index:'nickname', width:70,editable: false,editoptions:{size:"20",maxlength:"30"}},
            {name:'amount',index:'amount', sorttype: myCustomSort,width:70, editable: false,editoptions: {size:"20",maxlength:"30"},unformat: aceSwitch},
            {name:'status_str',index:'status_str', width:70, editable: true,edittype:"select",editoptions: {value:"4:通过;3:拒绝"},unformat: aceSwitch},
            {name:'options',index:'options', width:60, editable: true,edittype:"select",editoptions: {value:"4:通过;3:拒绝"},unformat: aceSwitch},
            ], 
            loadComplete : function() {
                bind_event();
                var table = this;
                setTimeout(function(){
                    updateActionIcons(table);
                    updatePagerIcons(table);
                    enableTooltips(table);
                }, 0);      
            },
            width: 780,
            height: 380,
            viewsortcols : [true,'vertical',true],
            rowNum: 10,
            scrollPopUp:true,
            scrollLeftOffset: "83%",
            viewrecords: true,
            scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
            emptyrecords: '没有账单', // the message will be displayed at the bottom 
        });

    $(grid_selector_new).jqGrid();  
    } : null,
    position:"last"
});
} catch(e) {
    alert(e);
}

$(document).ready(function () {
    $(grid_selector).jqGrid();
    $('.ui-jqdialog').remove();

});



