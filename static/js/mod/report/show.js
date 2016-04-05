// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    return {
        initialize: function() {
            angular.module('reimApp', []).controller('ReportController', ["$http", "$scope", "$element", "$timeout",
                function($http, $scope, $element, $timeout) { 

                	var report_id = (function() {
                		var router = new RouteRecognizer();
                    	router.add([{path: "/reports/show/:id"}]);
                    	var matchers = router.recognize(location.pathname);
                    	var id = 0;
                    	if(matchers.length>0) {
                    	    var match = matchers[0];
                    	    id = match.params['id'];
                    	}
                    	return id;
                	})();

                    $scope.bankFieldMap = {};

                    $scope.selectedMembers = [];
                    $scope.selectedConsumptions = [];
                    $scope.banks = [];
                    $scope.default_bank = null;
                    $scope.template = null;
                    $scope.report_status = 0;

                    function getTemplateData() {
                    	var query = Utils.queryString(location.search);
                        return Utils.api('/template/get_template/'+query.tid, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到模版');
                            }
                        });
                    };

                    function modifyArrayByAll(arr, all) {
                        for(var i=0;i<arr.length;i++) {
                            var item = arr[i];
                            var index = _.findLastIndex(all, {
                                id: item.id + ''
                            });
                            if(index>-1) {
                                var one = all[index];
                                var cur = arr[i];
                                cur['rank_id'] = one['rank_id'];
                                cur['apath'] = one['apath'];
                                cur['level_id'] = all['level_id'];
                                cur['gid'] = all['gid'];
                            }
                        }
                    };

                    function getReportData(id) {
                        return Utils.api('/reports/detail/'+id, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到数据');
                            }
                        });
                    };

                    function getReportFlow(id) {
                        return Utils.api('/reports/get_report_flow_v2/'+id, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到数据');
                            }
                        });
                    };

                    function getCurrentUserBanks() {
                        return Utils.api('/users/get_current_user_banks', {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('个人银行数据出错');
                            }
                        });
                    };

                    function getAvailableConsumptions() {
                        return Utils.api('/reports/get_available_consumptions', {}).done(function (rs) {
                            $scope.consumptions = rs['data'] || [];
                            // $scope.consumptions = $scope.consumptions.splice(0, 10);
                            $scope.$apply();

                        });
                    };

                    function getMembers() {
                        return Utils.api('/users/get_members', {}).done(function (rs) {
                            var data = rs['data'];
                            $scope.members = data['members'] || [];

                            $scope.rankMap = arrayToMapWithKey('id', data['rankArray']);

                            $scope.levelMap = arrayToMapWithKey('id', data['levelArray']);

                            $scope.$apply();
                        });
                    };

                    function arrayToMapWithKey(key, arr) {
                        var rs = {};
                        for (var i = arr.length - 1; i >= 0; i--) {
                            var item = arr[i];
                            rs[item[key]] = item;
                        }
                        return rs;
                    };

                    function findOneInBanks(id, banks, pro) {
                        banks || (banks=[]);
                        pro || (pro='id');
                        for(var i=0;i<banks.length; i++) {
                            var b = banks[i];
                            if(id == b[pro]) {
                                return b;
                            }
                        }
                        return null;
                    };

                    function getPageData(callback) {
                        $.when(
                            getTemplateData(),
                            getReportData(report_id),
                            getCurrentUserBanks(),
                            getReportFlow(report_id),
                            getMembers()
                        ).done(function () {
                            callback.apply(null, arguments);
                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                        })
                    };

                    function toMapByKey(arr, itemFormat, pro) {
                    	var rs = {};
                    	itemFormat || (itemFormat=function(i) {return i;});
                    	pro || (pro='id');
                    	for(var i=0;i<arr.length;i++) {
                    		var item = arr[i];
                    		rs[item[pro]] = itemFormat(item);
                    	}
                    	return rs;
                    }

                    function bankItemFormat(item) {
                        if(!item.id) {
                            return {
                                text: ''
                            }
                        }
                        return {
                            value: item['id'],
                            text: '尾号' + item.cardno.substr(-4)  + '-' + item.bankname || '--'
                        }
                    }
                    // main entry
                    getPageData(function (template, report, banks, flow, members) {
                        $scope.isLoaded = true;

                        if(report['status']<=0 || template['status']<=0 || banks['status']<=0) {
                        	return;
                        }

                        var reportData = report['data'];
                        var extras = toMapByKey(JSON.parse(reportData['extras']), function(item) {
                        	var itemType = item.type + '';
                        	if(itemType+''=='4') {
                        		var bankData = JSON.parse(item.value);
	                            bankData = findOneInBanks(bankData.cardno, banks.banks, 'cardno');
	                            item.value = bankItemFormat(bankData)['text'];
                        		return item;
                        	}
                        	if(itemType=='3') {
                        		var date =  new Date(parseInt(item.value));
                        		item.value = fecha.format(date, 'YYYY-MM-DD');
                        	}
                        	return item;
                        });

                        $scope.report = report['data'];

                        $scope.selectedMembers = angular.copy(report['data']['receivers']['managers']);

                        // fix me
                        modifyArrayByAll($scope.selectedMembers, members.data.members);

						$scope.template = angular.copy(template['data']);

						$scope.extras = extras;
						$scope.flow = _.groupBy(flow['data']['data'], function(item) {
							if(['-1', '0'].indexOf(item['ticket_type'])>-1) {
								return '业务阶段';
							} else if(['1'].indexOf(item['ticket_type'])>-1) {
								return '财务阶段';
							}
						});

						$scope.submitter = _.where(members.data.members, {
							id: report['data']['uid']
						})[0];

                        $scope.$apply();
                       
                    });


                    $scope.formatMember = function (m) {
                        // {{levelMap[m.level_id]['name'] || '未知级别'}}－{{rankMap[m.rank_id]['name'] || '未知职位'}}
                        var rankMap = $scope.rankMap;
                        var rank = rankMap[m.rank_id] || {};
                        // console.log(m.d , rankMap[m.rank_id]['name'])
                        if(m.d && rank['name']) {
                            return m.d + '-' + rankMap[m.rank_id]['name'];
                        } else {
                            var rank = rankMap[m.rank_id] || {};
                            return m.d || rank['name'] || '';
                        }
                    };

                    $scope.onAddConsumptions = function (e) {
                        if(!$scope.consumptions) {
                            return show_notify('正在加载数据......');
                        }

                        var dialog = dialogConsumptionSingleton.getInstance();

                        dialog.showModal();
                    };

                    function readReportData() {
                        var title = $scope.title;
                        var template_id = $element.find('.report').data('tid');
                        var template_type = $element.find('.report').data('type');

                        if(!title) {
                            $element.find('.report-title input').focus();
                            return show_notify('请添加报销单名');
                        }

                        var receiver_ids = $scope.selectedMembers.map(function (i) {
                            return i['id'];
                        });

                        if(receiver_ids.length<=0) {
                            show_notify('请选择审批人');
                            return null;
                        }

                        var item_ids = $scope.selectedConsumptions.map(function (i) {
                            return i['id'];
                        });

                        if(item_ids.length<=0) {
                            if(~~$scope.template['options']['allow_no_items']==0) {
                                show_notify('提交的报销单不能为空');
                                return null;
                            }
                        }

                        // extras is fields content
                        var inValidExtras = false;
                        var extras = $element.find('.field-item-list .field-item').map(function (i, item) {
                            var type = $(item).data('type') + '';
                            var id = $(item).data('id');
                            var value = $(item).find('input').val() || $(item).find('.text').text();
                            var isRequired = ~~$(item).data('required');

                            if(isRequired && !value) {
                                $(item).find('input').focus();
                                $(item).find('.text').click();
                                inValidExtras = true;
                                return show_notify('请填写完整的信息');
                            }

                            var data = {
                                type: type,
                                id: id,
                                value: value
                            };

                            if(type=='3') {
                                data['value'] = +(new Date(value));
                            }

                            if(type=== '4') {
                                var bank = $scope.bankFieldMap[id];
                                if(isRequired && !bank) {
                                    inValidExtras = true;
                                    show_notify('必填银行卡项目不能为空');
                                    return null
                                }
                                data['value'] = JSON.stringify({
                                    "account": bank['account'],
                                    "cardno": bank['cardno'],
                                    "bankname": bank['bankname'],
                                    "bankloc": bank['bankloc'],
                                    "subbranch": bank['subbranch']
                                });
                            }
                            return data;
                        }).toArray();

                        if(inValidExtras) {
                            return null;
                        }

                        return {
                            title: title,
                            template_id: template_id,
                            template_type: template_type,
                            receiver_ids: receiver_ids.join(','),
                            item_ids: item_ids.join(','),
                            extras: extras
                        }  
                    };

                    $scope.onCancel = function (e) {
                        updatePageWithReportData();
                    };

                    // 首次创建，其次保存
                    $scope.onSave = function (e) {
                        var data = readReportData();

                        if(!data) {
                            return;
                        }

                        data['status'] = 0;
                        
                        if($scope.__edit__ || $scope.__report_id__) {

                            Utils.api('/reports/update_v2', {
                                method: 'post',
                                data: $.extend({}, data, {id: $scope.__report_id__})
                            }).done(function (rs) {
                                if(rs['status']<=0) {
                                    return show_notify(rs['msg']);
                                }
                                show_notify('保存成功');
                                $scope.report_status = 1;
                                $scope.originalReport = angular.copy(data);
                            });
                            return
                        }

                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data
                        }).done(function (rs) {
                            if(rs['status']<=0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('保存成功');
                            $scope.__report_id__ = rs['data']['id'];
                            $scope.originalReport = angular.copy(data);
                        });
                    };

                    $scope.onSubmit = function (e) {
                        var data = readReportData();

                        if(!data) {
                            return;
                        }

                        data['status'] = 1;
                        
                        if($scope.__edit__ || $scope.__report_id__) {

                            Utils.api('/reports/update_v2', {
                                method: 'post',
                                data: $.extend({}, data, {id: $scope.__report_id__})
                            }).done(function (rs) {
                                if(rs['status']<=0) {
                                    return show_notify(rs['msg']);
                                }
                                show_notify('保提交成功存成功');
                                $scope.report_status = 1;
                                $scope.originalReport = angular.copy(data);
                            });
                            return
                        }

                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data,
                        }).done(function (rs) {
                            if(rs['status']<=0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('提交成功');
                            $scope.originalReport = angular.copy(data);
                        });
                    };

                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型