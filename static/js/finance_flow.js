
function chose_others_zero(item, suggestion) {
	$("#modal_next").find('#modal_managers').val(suggestion).trigger("chosen:updated");
	$('#modal_next').modal('show');
}

function approve_report(id) {
	$.ajax({
		type: "GET",
		url:  "/bills/report_finance_permission/" + id,
		data: {
			rid: id
		},
		dataType: "json",
		success: function(data) {
			if (data['status'] > 0) {
				if (data['data'].complete == 0) {
					$('#rid').val(id);
					chose_others_zero(id, data['data'].suggestion);
				} else {
					$('#rid_').val(id);
					$('#modal_next_').modal('show');
				}
			}
		}
	});
	$('.tdown').each(function() {
        $(this).click(function() {
            var _id = $(this).data('id');
            var chosen_id = [];
            chosen_id.push(_id);
            $.ajax({
                url: __BASE + "/bills/download_report",
                method: "post",
                dataType: "json",
                //data:{"chosenids":chosenids},
                data: {
                    "chosenids": chosen_id
                },
                success: function(data) {
                    location.href = data['url'];
                },
                error: function(a, b) {}
            });
        });
    });
}

var selectRows = [];
var IF_SELECT_ALL = 0;

var keyword = $('#globalSearchText').val();
keyword = encodeURIComponent(keyword);
var dept = $('select[name=gids]').val();
var submit_startdate = $('#date-timepicker1').val();
var submit_enddate = $('#date-timepicker2').val();
var approval_startdate = $('#date-timepicker3').val();
var approval_enddate = $('#date-timepicker4').val();

var query = {
	keyword: keyword,
	dept: dept,
	submit_startdate: submit_startdate,
	submit_enddate: submit_enddate,
	approval_startdate: approval_startdate,
	approval_enddate: approval_enddate
}
try {
	jQuery(grid_selector).jqGrid({
		url: __BASE + 'bills/finance_by_status/' + __STATUS + '?' + $.param(query),
		mtype: "GET",
		datatype: "local",
		height: 250,
		multiselect: true,
		loadtext: '',
		colNames: ['报销单ID', '报销单模板', '提交日期', '报销单名', '类型', '条目数', '提交者', '金额', '附件', '状态', '审批日期', '操作', '部门', '报销单模板ID'],
		loadonce: true,
		caption: "费用审计",
		editurl: __BASE + 'bills/save',
		datatype: "json",
		autowidth: true,
		hoverrows: true,
		colModel: [{
			name: 'id',
			index: 'id',
			width: 45,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			}
		}, {
			name: 'report_template',
			index: 'report_template',
			width: 70,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "50"
			}
		}, {
			name: 'date_str',
			index: 'date_str',
			width: 110,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
			search: false
		}, {
			name: 'title',
			index: 'title',
			width: 90,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			}
		}, {
			name: 'prove_ahead',
			index: 'prove_ahead',
			width: 60,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			}
		}, {
			name: 'item_count',
			index: 'item_count',
			width: 40,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
			search: false
		}, {
			name: 'nickname',
			index: 'nickname',
			width: 50,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			}
		}, {
			name: 'amount',
			index: 'amount',
			sorttype: myCustomSort,
			width: 70,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
			formatter: 'currency',
			formatoptions: {
				decimalPlaces: 2,
				thousandsSeparator: ",",
				prefix: '￥'
			},
			unformat: aceSwitch,
			search: false
		}, {
			name: 'attachments',
			index: 'attachments',
			width: 34,
			editable: true,
			edittype: "select",
			editoptions: {
				size: "30",
				maxlength: "40",
				value: "4:通过;3:拒绝"
			},
			unformat: aceSwitch,
			search: false
		}, {
			name: 'status_str',
			index: 'status_str',
			width: 70,
			editable: true,
			edittype: "select",
			editoptions: {
				value: "4:通过;3:拒绝"
			},
			unformat: aceSwitch,
			search: false
		}, {
			name: "approvaldt_str",
			index: "approvaldt_str",
			width: 100,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
			search: false,
			hidden: (__STATUS != 2)
		}, {
			name: 'options',
			index: 'options',
			width: 70,
			editable: true,
			edittype: "select",
			editoptions: {
				value: "4:通过;3:拒绝"
			},
			unformat: aceSwitch,
			search: false
		}, {
			name: 'ugs',
			index: 'ugs',
			width: 50,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
			hidden: true
		}, {
			name: 'template_id',
			index: 'template_id',
			width: 50,
			editable: false,
			editoptions: {
				size: "20",
				maxlength: "30"
			},
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
			jQuery.each(selectRows, function(index, row) {
				jQuery(grid_selector).jqGrid('setSelection', row);
			});
			if (IF_SELECT_ALL) $(".cbox").each(function(index, el) {
				$(".cbox")[index].checked = true;
			});

			var table =  this;
			setTimeout(function() {
				//styleCheckbox(table);
				updateActionIcons(table);
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},
		onSelectAll: function(aRows, status) {
			if (status) {
				IF_SELECT_ALL = 1;
				var array_selectRows = jqgrid_choseall_plus(grid_selector);
				jQuery.each(array_selectRows, function(index, rowid) {
					if (jQuery.inArray(rowid, selectRows) == -1) {
						selectRows.push(rowid);
					}
				});
			} else {
				selectRows = [];
				IF_SELECT_ALL = 0;
			}
		},
		onSelectRow: function(rowId, status, e) {
			var $target = $(e.target || e.toElement);
			if($target.hasClass('tdetail')) {
				var row = $(this).jqGrid ('getRowData', rowId);
				var arr = $(this).jqGrid ('getGridParam', rowId);
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
				location.href = "/reports/edit/" + rowId;
				return
			}

			if($target.hasClass('tdeny')) {
				$('#div_id').val(rowId);
				$('#comment_dialog').modal('show');
			}

			if (status) {
				if (jQuery.inArray(rowId, selectRows) == -1) {
					selectRows.push(rowId);
				}
			} else {
				selectRows.splice(jQuery.inArray(rowId, selectRows), 1);
			}
		},
		//page: 1,
		width: 780,
		height: 380,
		viewsortcols: [true, 'vertical', true],
		rowNum: 10,
		scrollPopUp: true,
		scrollLeftOffset: "83%",
		viewrecords: true,
		scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
		emptyrecords: '没有账单', // the message will be displayed at the bottom 
		pager: pager_selector,
	});
} catch (e) {
	alert(e);
}
try {
	jQuery(grid_selector).jqGrid('navGrid', pager_selector, { //navbar options
		edit: false,
		editicon: 'ace-icon fa fa-pencil blue',
		add: true,
		addicon: 'ace-icon fa fa-database',
		addtitle: '导出U8',
		addfunc: function(rowids, p) {
			var rowid = $(grid_selector).jqGrid('getGridParam', 'selarrrow');
			var form = $("<form>"); //定义一个form表单
			form.attr("style", "display:none");
			form.attr("target", "");
			form.attr("method", "post");
			form.attr("action", __BASE + "/reports/export_u8");
			//form.attr("action", __BASE + "/reports/exports");
			var input1 = $("<input>");
			input1.attr("type", "hidden");
			input1.attr("name", "ids");
			input1.attr("value", selectRows.join(','));
			$("body").append(form); //将表单放置在web中
			form.append(input1);
			form.submit(); //表单提交
		},
		del: true,
		delicon: 'ace-icon fa fa-file-excel-o',
		deltitle: '导出excel',
		delfunc: function(rowids, p) {
			var form = $("<form>"); //定义一个form表单
			form.attr("style", "display:none");
			form.attr("target", "");
			form.attr("method", "post");
			//form.attr("action", __BASE + "/reports/export_u8");
			form.attr("action", __BASE + "/reports/exports");
			var input1 = $("<input>");
			input1.attr("type", "hidden");
			input1.attr("name", "ids");
			input1.attr("value", selectRows.join(','));
			$("body").append(form); //将表单放置在web中
			form.append(input1);
			form.submit(); //表单提交
		},
		search: false,
		searchicon: 'ace-icon fa fa-search orange',
		refresh: false,
		refreshicon: 'ace-icon fa fa-refresh green',
		view: false,
		viewicon: 'ace-icon fa fa-search-plus grey',
	}, {
		//edit record form
		//closeAfterEdit: true,
		//width: 700,
		recreateForm: true,
		beforeShowForm: function(e) {
			var form = $(e[0]);
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_edit_form(form);
		}
	}, {
		//new record form
		//width: 700,
		closeAfterAdd: true,
		recreateForm: true,
		viewPagerButtons: false,
		beforeShowForm: function(e) {
			var form = $(e[0]);
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_edit_form(form);
		}
	}, {
		//delete record form
		recreateForm: true,
		beforeShowForm: function(e) {
			var form = $(e[0]);
			if (form.data('styled')) return false;
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_delete_form(form);
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
		multipleSearch: true,
		/**
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
	}).navButtonAdd(pager_selector, {
		caption: "",
		title: "下载选中报销单",
		buttonicon: "ace-icon fa fa-download blue",
		onClickButton: function() {
			//TODO
			//         chosenids = $(grid_selector).jqGrid('getGridParam','selarrrow');
			// if (chosenids.length == 0) {
			if (selectRows.length == 0) {
				alert("请选择报销单!");
				return;
			}
			$.ajax({
				url: __BASE + "/bills/download_report",
				method: "post",
				dataType: "json",
				//data:{"chosenids":chosenids},
				data: {
					"chosenids": selectRows
				},
				success: function(data) {
					location.href = data['url'];
				},
				error: function(a, b) {}
			});
		}
	});
	var pathName = window.location.pathname.split('/');
	var method = pathName[2];
	if (method == 'finance_flow')
		jQuery(grid_selector).navButtonAdd(pager_selector, {
			caption: "",
			title: "结束选中报销单",
			buttonicon: "ace-icon fa fa-check green",
			onClickButton: function() {
				// chosenids = $(grid_selector).jqGrid('getGridParam','selarrrow');
				chosenids = selectRows;
				if (chosenids.length == 0) {
					alert("请选择报销单!");
					return;
				}
				$('#modal-table-finish').modal().css({
					width: 'auto',
					'margin-left': function() {
						return -(($(this).width() - $('#modal-table-flow').width) / 2);
					}
				});
				_part = chosenids.join('|');
				var _part_url = __BASE + 'bills/get_finance_report_by_ids?ids=' + _part;
				$(grid_selector_finish).jqGrid('GridUnload');
				jQuery(grid_selector_finish).jqGrid({
					url: _part_url,
					mtype: "GET",
					datatype: "local",
					height: 250,
					multiselect: false,
					loadtext: '',
					colNames: ['提交日期', '报销单名', '条目数', '提交者', '金额', '状态', '操作'],
					loadonce: true,
					caption: "费用审计",
					editurl: __BASE + 'bills/save',
					datatype: "json",
					autowidth: true,
					shrinkToFit: false,
					hoverrows: true,
					colModel: [{
						name: 'date_str',
						index: 'date_str',
						width: 150,
						editable: false,
						editoptions: {
							size: "20",
							maxlength: "30"
						}
					}, {
						name: 'title',
						index: 'title',
						width: 90,
						editable: false,
						editoptions: {
							size: "20",
							maxlength: "30"
						}
					}, {
						name: 'item_count',
						index: 'item_count',
						width: 70,
						editable: false,
						editoptions: {
							size: "20",
							maxlength: "30"
						}
					}, {
						name: 'nickname',
						index: 'nickname',
						width: 70,
						editable: false,
						editoptions: {
							size: "20",
							maxlength: "30"
						}
					}, {
						name: 'amount',
						index: 'amount',
						sorttype: myCustomSort,
						width: 70,
						editable: false,
						editoptions: {
							size: "20",
							maxlength: "30"
						},
						unformat: aceSwitch
					}, {
						name: 'status_str',
						index: 'status_str',
						width: 70,
						editable: true,
						edittype: "select",
						editoptions: {
							value: "4:通过;3:拒绝"
						},
						unformat: aceSwitch
					}, {
						name: 'options',
						index: 'options',
						width: 60,
						editable: true,
						edittype: "select",
						editoptions: {
							value: "4:通过;3:拒绝"
						},
						unformat: aceSwitch
					}, ],
					loadComplete: function() {
						bind_event();
						var table = this;
						setTimeout(function() {
							updateActionIcons(table);
							updatePagerIcons(table);
							enableTooltips(table);
						}, 0);
					},
					unformat: aceSwitch
				}, ],
				loadComplete: function() {
					var table = this;
					setTimeout(function() {
						updateActionIcons(table);
						updatePagerIcons(table);
						enableTooltips(table);
					}, 0);
				},
				width: 780,
				height: 380,
				viewsortcols: [true, 'vertical', true],
				rowNum: 10,
				scrollPopUp: true,
				scrollLeftOffset: "83%",
				viewrecords: true,
				scroll: 0, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
				emptyrecords: '没有账单', // the message will be displayed at the bottom 
			});
			$(grid_selector_finish).jqGrid();
		},
		position: "last"
	});
} catch (e) {
	alert(e);
}
$(document).ready(function() {
	$(grid_selector).jqGrid();
	$('.ui-jqdialog').remove();
});


// new logic
(function() {
	$(window).on('resize', function() {
		var width = window.innerWidth;
		var respWidth = 1400
		if ($('#dataSelect_').length == 0) {
			respWidth = 900;
		}
		if (width < respWidth) {
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