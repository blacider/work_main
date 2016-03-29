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
                    $scope.fieldTypeArray = [
                        {value:1, text: 'djsjf的飞机开始 '},
                        {value:1, text: 'djsjf的飞机开始 '},
                        {value:1, text: 'djsjf的飞机开始 '},
                        {value:1, text: 'djsjf的飞机开始 '}
                    ];

                    function getReportData(id) {
                        Utils.api('/template/get_template/'+id, {
                            data: {
                                id: id
                            }
                        }).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notifiy('找不到模版');
                            }
                            $scope.originalData = rs['data'];

                            $scope.report = angular.copy(rs['data']);
                            $scope.$apply();

                        });
                    };

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
                            icons: {
                                1: '/static/img/mod/template/icon/triangle@2x.png'
                            },
                            useStrict: false,
                            direction: "auto",
                            sideBySide: false,
                            daysOfWeekDisabled: false
                        }).on('dp.change', function(e){

                        });
                    };

                    function getCurrentUserBanks() {
                        Utils.api('/users/get_current_user_banks', {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notifiy('个人银行数据出错');
                            }

                            $scope.banks = rs['banks'];
                            $scope.default_bank = findDefaultBank(rs['default_bank'], rs['banks']);
                            $scope.$apply();

                        });
                    };

                    function findDefaultBank(id, banks) {
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
                            getReportData($element.find('.report').data('id'))
                        ).done(function () {
                            callback();
                        })
                    };

                    // main entry
                    getPageData(function () {
                        setTimeout(function () {
                            initDatetimepicker('.datatimepicker input');
                        }, 1000);
                    });


                    $scope.makeBankDropdown = {
                        itemFormat: function (item) {
                            return {
                                value: item['id'],
                                text: '尾号' + item.cardno.substr(-4)  + '-' + item.bankname || '--'
                            }
                        },
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.$apply(function() {
                                columnData['type'] = newValue;
                                columnData['name'] = '';
                                delete columnData['id'];
                                var type = columnData['type'];
                                if(type==2) {
                                    if(!columnData['property']) {
                                        columnData['property'] = {};
                                    }
                                    if(!columnData['property']['options']) {
                                        columnData['property']['options'] = ['', ''];
                                    }
                                }
                                if(type==4) {
                                    if(!columnData['property']) {
                                        columnData['property'] = {};
                                    }
                                    if(!columnData['property']['bank_account_type']) {
                                        columnData['property']['bank_account_type'] = 0;
                                    }
                                }
                            })
                        }
                    }

                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型