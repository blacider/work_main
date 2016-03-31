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
                    $scope.originalReport = {};
                    $scope.selectedMembers = [];
                    $scope._selectedMembers = [];
                    $scope.selectedConsumptions = [];
                    $scope._selectedConsumptions = [];


                    function getReportData(id) {
                        return Utils.api('/template/get_template/'+id, {
                            data: {
                                id: id
                            }
                        }).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到模版');
                            }
                            $scope.template = angular.copy(rs['data']);
                            $scope.$apply();

                        });
                    };

                    function getReportData(id) {
                        return Utils.api('/reports/detail/'+id, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到数据');
                            }

                            $scope.$apply();
                        });
                    };

                    (function tryMatchEdit() {
                        var router = new RouteRecognizer();
                        router.add([{path: "/reports/:type/:id"}]);
                        var matchers = router.recognize(location.pathname);
                        if(matchers.length>0) {
                            var m = matchers[0];
                            if(m.params['type']=='edit') {
                                getReportData(m.params['id']);
                            }
                        }
                    })();

                    function getCurrentUserBanks() {
                        return Utils.api('/users/get_current_user_banks', {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('个人银行数据出错');
                            }

                            $scope.banks = rs['banks'];
                            $scope.default_bank = findOneInBanks(rs['default_bank'], rs['banks']);
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
                     
                        function createInstance(type) {
                             
                            var dialog = new CloudDialog({
                                title: '选择审批人',
                                quickClose: true,
                                autoDestroy: false,
                                ok: function () {
                                    $scope.selectedMembers = angular.copy($scope._selectedMembers);
                                    $scope.$apply();
                                    this.close();
                                },
                                cancel: function () {
                                    this.close();
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
                     
                        function createInstance(type) {
                             
                            var dialog = new CloudDialog({
                                title: '选择消费',
                                quickClose: true,
                                autoDestroy: false,
                                width: 500,
                                ok: function () {
                                    $scope.selectedConsumptions = angular.copy($scope._selectedConsumptions);
                                    $scope.$apply();
                                    this.close();
                                },
                                cancel: function () {
                                    this.close();
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
                            defaultDate: +new Date,
                            disabledDates: false,
                            enabledDates: false,
                            useStrict: false,
                            direction: "auto",
                            sideBySide: false,
                            daysOfWeekDisabled: false
                        }).on('dp.change', function(e){

                        });
                    };

                    function findOneInBanks(id, banks) {
                        banks || (banks=[]);
                        for(var i=0;i<banks.length; i++) {
                            var b = banks[i];
                            if(id == b['id']) {
                                return b;
                            }
                        }
                        return null;
                    };

                    function getPageData(callback) {
                        $.when(
                            getCurrentUserBanks(),
                            getReportData($element.find('.report').data('tid')),
                            getAvailableConsumptions(),
                            getMembers()
                        ).done(function () {
                            callback();

                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                            

                        })
                    };

                    // main entry
                    getPageData(function () {
                        setTimeout(function () {
                            initDatetimepicker('.datatimepicker input');
                        }, 1000);
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


                    $scope.makeBankDropdown = {
                        itemFormat: function (item) {
                            return {
                                value: item['id'],
                                text: '尾号' + item.cardno.substr(-4)  + '-' + item.bankname || '--'
                            }
                        },
                        onChange: function(oldValue, newValue, item, columnData) {
                            var id = $(item).parents('.field-item').data('id');

                            $scope.bankFieldMap[id] = findOneInBanks(newValue, $scope.banks);
                        },
                        onInitValue: function (item, el) {
                            setTimeout(function () {
                                var id = $(el).parents('.field-item').data('id');
                                $scope.bankFieldMap[id] = findOneInBanks(item.value, $scope.banks);
                            }, 100);
                        }
                    };

                    $scope.onTextLengthChange2 = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if(str.length>=_templateTotalLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $input.val(str);
                            }, 50);
                        }
                    }, 100);

                    $scope.onTextLengthChange = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if(str.length>=_templateNameLengthLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $scope.title = str
                            }, 50);
                        }
                    }, 100);

                    $scope.onAddApprovers = function (e) {
                        if(!$scope.members) {
                            return show_notify('正在加载数据......');
                        }

                        var dialog = dialogMemberSingleton.getInstance();

                        dialog.showModal();
                    };

                    $scope.onSelectMember = function (item, e) {
                        item.isSelected = !item.isSelected;
                        $scope._selectedMembers || ($scope._selectedMembers=[]);
                        if(item.isSelected) {
                            $scope._selectedMembers.push(item);
                        } else {
                            for(var i=0;i<$scope._selectedMembers.length;i++) {
                                var one = $scope._selectedMembers[i];
                                if(one['id'] == item.id) {
                                    $scope._selectedMembers.splice(i,1);
                                }
                            }
                        }
                    };

                    $scope.onSelectConsumption = function (item, e) {
                        item.isSelected = !item.isSelected;
                        $scope._selectedConsumptions || ($scope._selectedConsumptions=[]);
                        if(item.isSelected) {
                            $scope._selectedConsumptions.push(item);
                        } else {
                            for(var i=0;i<$scope._selectedConsumptions.length;i++) {
                                var one = $scope._selectedConsumptions[i];
                                if(one['id'] == item.id) {
                                    $scope._selectedConsumptions.splice(i,1);
                                }
                            }
                        }
                    };

                    $scope.onAddConsumptions = function (e) {
                        if(!$scope.consumptions) {
                            return show_notify('正在加载数据......');
                        }

                        var dialog = dialogConsumptionSingleton.getInstance();

                        dialog.showModal();
                    };

                    $scope.onCancel = function (e) {
                        // body...
                    };

                    function readReportData() {
                        var title = $scope.title;
                        var template_id = $element.find('.report').data('tid');
                        var template_type = $element.find('.report').data('type');

                        if(!title) {
                            $element.find('.report-title input').focus();
                            return show_notify('请添加报销单名');
                        }

                        var receiver_ids = $scope._selectedMembers.map(function (i) {
                            return i['id'];
                        });

                        if(receiver_ids.length<=0) {
                            show_notify('请选择审批人');
                            return null;
                        }

                        var item_ids = $scope._selectedConsumptions.map(function (i) {
                            return i['id'];
                        });

                        if(item_ids.length<=0) {
                            if(~~$scope.template['options']['allow_no_items']==0) {
                                show_notify('提交的报销单不能为空');
                                return null;
                            }
                        }

                        // extra is fields content
                        var inValidExtra = false;
                        var extra = $element.find('.field-item').map(function (i, item) {
                            var type = $(item).data('type');
                            var id = $(item).data('id');
                            var value = $(item).find('input').val() || $(item).find('.text').text();
                            var isRequired = ~~$(item).data('required');

                            if(isRequired && !value) {
                                $(item).find('input').focus();
                                $(item).find('.text').click();
                                inValidExtra = true;
                                return show_notify('请填写完整的信息');
                            }

                            var data = {
                                type: type,
                                id: id,
                                value: value
                            };

                            if(type+''=== '4') {
                                var bank = $scope.bankFieldMap[id];
                                if(isRequired && !bank) {
                                    inValidExtra = true;
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

                        if(inValidExtra) {
                            return null;
                        }

                        return {
                            title: title,
                            template_id: template_id,
                            template_type: template_type,
                            receiver_ids: receiver_ids.join(','),
                            item_ids: item_ids.join(','),
                            extra: extra
                        }  
                    };


                    $scope.onSave = function (e) {
                        var data = readReportData();
                        if(!data) {
                            return;
                        }

                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data,
                        }).done(function (rs) {
                            if(rs['status']<=0) {
                                return show_notify(rs['msg']);
                            }
                            show_notify('创建成功')
                        });
                    };

                    $scope.onSubmit = function (e) {
                        // body...
                    };

                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型