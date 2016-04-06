// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    
    var _fieldCountLimit_ = 6;
    var _radioOptionsCountLimit_ = 100;
    var _templateNameLengthLimit_ = 10;
    var _templateFieldLengthLimit_ = 8;
    var _templateTotalLimit_ = 10;
    var _templateTypes_ = null;
    var _ON_TEMPLATE_ADD_ANIMATION_ = 'animated flash';

    return {
        initialize: function() {
            angular.module('reimApp', ['ng-sortable', 'ng-dropdown']).controller('ReportController', ["$http", "$scope", "$element", "$timeout",
                function($http, $scope, $element, $timeout) { 

                    $scope.bankFieldMap = {};

                    $scope.selectedMembers = [];
                    $scope.selectedConsumptions = [];
                    $scope.banks = [];
                    $scope.default_bank = null;
                    $scope.template = null;
                    $scope.report_status = 0;

                    $scope.originalReport = {
                        title: '',
                        selectedConsumptions: [],
                        selectedMembers: [],
                        extras: '[]'
                    };

                    function getTemplateData(id) {
                        return Utils.api('/template/get_template/'+id, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到模版');
                            }
                            $scope.template = angular.copy(rs['data']);
                            $scope.$apply();

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

                            var data = rs['data'];
                            $scope.originalReport.title = data['title'];

                            $scope.originalReport.selectedConsumptions = angular.copy(data['items']);
                            $scope.originalReport.selectedMembers = angular.copy(data['receivers']['managers']);

                            // fix me
                            modifyArrayByAll($scope.originalReport.selectedMembers, $scope.members);

                            $scope.originalReport.extras = JSON.parse(data['extras'] || '[]');

                            updatePageWithReportData()

                            $scope.$apply();
                        });
                    };

                    

                    function getCurrentUserBanks() {
                        return Utils.api('/users/get_current_user_banks', {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('个人银行数据出错');
                            }

                            $scope.banks = rs['banks'] || [];
                            $scope.default_bank = findOneInBanks(rs['default_bank'], rs['banks']);
                            if(!$scope.default_bank) {
                                if($scope.banks.length>0) {
                                    $scope.default_bank = $scope.banks[0];
                                }
                            }
                            $scope.$apply();

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

                    var dialogMemberSingleton = (function () {
                        var instance;
                     
                        function createInstance() {
                             
                            var dialog = new CloudDialog({
                                title: '选择审批人',
                                quickClose: true,
                                autoDestroy: false,
                                ok: function () {
                                    var selectedMembers = _.where($scope.members, {
                                        isSelected: true
                                    });
                                    $scope.selectedMembers = angular.copy(selectedMembers);
                                    $scope.$apply();
                                    this.close();
                                },
                                onShow: function () {
                                    for(var i=0;i<$scope.members.length;i++) {
                                        var item = $scope.members[i];
                                        item.isSelected = false;
                                    }
                                    for(var i=0;i<$scope.selectedMembers.length;i++) {
                                        var item = $scope.selectedMembers[i];
                                        Utils.updateArrayByQuery($scope.members, {id: item.id+''}, {
                                            isSelected: true
                                        })
                                    }
                                }
                            });

                            dialog.setContentWithElement($($element.find('.available-members')));
                       
                            return dialog;
                        }

                        return {
                            getInstance: function () {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();

                    var dialogConsumptionSingleton = (function () {
                        var instance;
                     
                        function createInstance() {
                             
                            var dialog = new CloudDialog({
                                title: '选择消费',
                                quickClose: true,
                                autoDestroy: false,
                                width: 500,
                                ok: function () {
                                    var selectedConsumptions = _.where($scope.consumptions, {
                                        isSelected: true
                                    });
                                    $scope.selectedConsumptions = angular.copy(selectedConsumptions);
                                    $scope.$apply();
                                    this.close();
                                },
                                onShow: function () {
                                    for(var i=0;i<$scope.consumptions.length;i++) {
                                        var item = $scope.consumptions[i];
                                        item.isSelected = false;
                                    }
                                    for(var i=0;i<$scope.selectedConsumptions.length;i++) {
                                        var item = $scope.selectedConsumptions[i];
                                        Utils.updateArrayByQuery($scope.consumptions, {id: item.id+''}, {
                                            isSelected: true
                                        })
                                    }

                                    setTimeout(function() {
                                        var $talbe = $('.available-consumptions table');
                                        $talbe.fixedHeaderTable({
                                            footer: false,
                                            cloneHeadToFoot: false,
                                            fixedColumn: false
                                        });
                                        $talbe.fixedHeaderTable('show');
                                    }, 16);

                                }
                            });

                            dialog.setContentWithElement($($element.find('.available-consumptions')));
                       
                            return dialog;
                        }

                        return {
                            getInstance: function () {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();

                    var dialogAddBankSingleton = (function () {
                        var instance;
                     
                        function createInstance() {
                             
                            var dialog = new CloudDialog({
                                title: '添加银行卡',
                                quickClose: true,
                                autoDestroy: false,
                                buttonAlign: 'right',
                                ok: function () {
                                    this.close();
                                },
                                cancel: function () {
                                    this.close();
                                }
                            });

                            dialog.setContentWithElement($($element.find('.bank-form')));
                       
                            return dialog;
                        }

                        return {
                            getInstance: function () {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();

                    function initDatetimepicker(selector) {
                        $(selector).datetimepicker({
                            language: 'zh-cn',
                            useCurrent: false,
                            format: 'YYYY-MM-DD',
                            // linkField: "dt",
                            linkFormat: "YYYY-MM-DD",
                            pickDate: true,
                            pickTime: false,
                            // minDate: ,
                            // maxDate: ,
                            showToday: true,
                            disabledDates: false,
                            enabledDates: false,
                            useStrict: false,
                            direction: "auto",
                            sideBySide: false,
                            daysOfWeekDisabled: false
                        }).on('dp.change', function(e){
                            $(selector).trigger('input');
                        });
                        $(selector).trigger('input');
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
                            getCurrentUserBanks(),
                            getTemplateData($element.find('.report').data('tid')),
                            getAvailableConsumptions(),
                            getMembers()
                        ).done(function () {
                            callback();
                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                        })
                    };

                    // main entry
                    getPageData(function () {
                        $scope.isLoaded = true;
                        $scope.$apply();
                        setTimeout(function () {
                            initDatetimepicker('.datatimepicker input');
                        }, 100);

                        (function tryMatchEdit() {
                            var router = new RouteRecognizer();
                            router.add([{path: "/reports/:type/:id"}]);
                            var matchers = router.recognize(location.pathname);
                            if(matchers.length>0) {
                                var m = matchers[0];
                                if(m.params['type']=='edit') {
                                    $scope.__edit__ = true;
                                    $scope.__report_id__ = m.params['id'];
                                    getReportData(m.params['id']);
                                }
                            }
                        })();
                    });

                    $scope.onTextLengthChange2 = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if(str.length>=_templateTotalLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $input.val(str);
                            }, 50);
                        }
                    }, 1000);

                    $scope.onTextLengthChange = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if(str.length>=_templateNameLengthLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $scope.title = str
                            }, 50);
                        }
                    }, 1000);


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


                    $scope.makeBankDropdown = {
                        itemFormat: function (item) {
                            if(!item.id) {
                                return {
                                    text: ''
                                }
                            }
                            return {
                                value: item['id'],
                                text: '尾号' + item.cardno.substr(-4)  + '-' + item.bankname || '--'
                            }
                        },
                        onChange: function(oldValue, newValue, item, columnData) {
                            var id = $(item).parents('.field-item').data('id');
                            var bank = findOneInBanks(newValue, $scope.banks);
                            $scope.bankFieldMap[id] = bank;
                        },
                        onInitValue: function (item, el) {
                            setTimeout(function () {
                                var id = $(el).parents('.field-item').data('id');
                                bank = findOneInBanks(item.value, $scope.banks);
                                $scope.bankFieldMap[id] = bank;
                            }, 100);
                        }
                    };

                    $scope.onAddBankCard = function (e) {
                        var dialog = dialogAddBankSingleton.getInstance();
                        dialog.showModal(); 
                    };

                    $scope.onAddApprovers = function (e) {
                        if(!$scope.members) {
                            return show_notify('正在加载数据......');
                        }

                        var dialog = dialogMemberSingleton.getInstance();

                        dialog.showModal();
                    };

                    $scope.onRemoveApprover = function (item) {
                        var index = _.findLastIndex($scope.selectedMembers, {
                            id: item.id + ''
                        });
                        var item = $scope.selectedMembers[index];
                        $scope.selectedMembers.splice(index, 1);
                        Utils.updateArrayByQuery($scope.members, {id: item.id+''}, {isSelected: false});
                    };

                    $scope.onSelectMember = function (item, e) {
                        item.isSelected = !item.isSelected;
                    };

                    $scope.onSelectConsumption = function (item, e) {
                        item.isSelected = !item.isSelected;
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

                    function updatePageWithReportData() {
                        $scope.title = $scope.originalReport['title'];
                        $scope.selectedConsumptions = angular.copy($scope.originalReport['selectedConsumptions']);
                        $scope.selectedMembers = angular.copy($scope.originalReport['selectedMembers']);

                        var oldConsumptions = angular.copy($scope.originalReport['selectedConsumptions']);
                        for(var i=0;i<oldConsumptions.length;i++) {
                            var item = oldConsumptions[i];
                            item.isSelected = true;
                            delete item.rid;
                            $scope.consumptions.unshift(item);
                        }

                        for(var i=0;i<$scope.selectedMembers.length;i++) {

                            var item = $scope.selectedMembers[i];
                            var index = _.findLastIndex($scope.members, {
                                id: item['id'] + ''
                            });
                            if(index>-1) {
                                $scope.members[index].isSelected = true;
                            }
                        }
                        (function (extras) {
                            extras = extras || [];
                            for(var i=0;i<extras.length;i++) {
                                var item = extras[i];
                                var itemType = item.type+'';
                                var id = item.id;

                                // 更新DOM
                                var $input = $('.field-item[data-id="' +id+ '"]');
                                if(itemType=='1') {
                                    $input.find('input').val(item.value);
                                }
                                if(itemType=='2') {
                                    $input.find('.text').text(item.value).removeClass('font-placeholder');
                                }
                                if(itemType=='3') {
                                    var date =  new Date(parseInt(item.value));
                                    $input.find('input').val(fecha.format(date, 'YYYY-MM-DD'));
                                }
                                if(itemType=='4') {
                                    var bankData = JSON.parse(item.value);
                                    bankData = findOneInBanks(bankData.cardno, $scope.banks, 'cardno');
                                    $scope.bankFieldMap[id] = bankData;
                                    $input.find('.text').text($scope.makeBankDropdown.itemFormat(bankData)['text']);
                                }
                            }
                        })($scope.originalReport.extras);
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