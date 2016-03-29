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

                    function getReportData(id) {
                        return Utils.api('/template/get_template/'+id, {
                            data: {
                                id: id
                            }
                        }).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到模版');
                            }
                            $scope.originalData = rs['data'];

                            $scope.report = angular.copy(rs['data']);
                            $scope.$apply();

                        });
                    };

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
                                ok: function () {
                                    $scope.selectedMembers = $scope._selectedMembers;
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
                            getReportData($element.find('.report').data('id')),
                            getAvailableConsumptions(),
                            getMembers()
                        ).done(function () {
                            callback();

                            $scope.selectedMembers = [];
                            $scope._selectedMembers = [];
                            $scope.selectedConsumptions = [];
                            $scope._selectedConsumptions = [];

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
                            var id = newValue;
                            $scope.bankFieldMap[id] = findOneInBanks(id, $scope.banks);
                        },
                        onInitValue: function (item) {
                            var id = item.value;
                            $scope.bankFieldMap[id] = findOneInBanks(id, $scope.banks);
                        }
                    };

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
                        
                    };

                    $scope.onCancel = function (e) {
                        // body...
                    };

                    $scope.onSave = function (e) {
                        var item_ids = $scope._selectedConsumptions.map(function (i) {
                            return i[id];
                        });
                        var title = $scope.title;
                        var receiver_ids = $scope._selectedMembers.map(function (i) {
                            return i[id];
                        });

                        var cc = [];
                        var template_id = $element.find('.report').data('id');

                        // extra is fields content
                        var extra = $element.find('.field-item').map(function (i, item) {
                            var type = $(item).data('type');
                            var id = $(item).data('id');
                            var value = $(item).find('input').val();
                            var data = {
                                type: type,
                                id: id,
                                value: value
                            };
                            if(type+''=== '4') {
                                var bank = $scope.bankFieldMap[id];
                                data['value'] = JSON.stringify({
                                    "account": bank['account'],
                                    "cardno": bank['cardno'],
                                    "bankname": bank['bankname'],
                                    "bankloc": bank['bankloc'],
                                    "subbranch": bank['subbranch']
                                });
                            }
                            return data;
                        });

                        Utils.api('/reports/create', {
                            data: {
                                item_ids: item_ids,
                                title: title,
                                cc: cc,
                                template_id: template_id,
                                extra: extra,
                            }
                        }).done(function (rs) {
                            
                        })
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