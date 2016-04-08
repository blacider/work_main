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

                    $scope.originalReport = {};

                    function getTemplateData(id) {
                        return Utils.api('/template/get_template/'+id, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到模版');
                            }
                        });
                    };

                    function getReportData(id) {
                        return Utils.api('/reports/detail/'+id, {}).done(function (rs) {
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
                            if(rs['status']<0) {
                                return show_notify('数据出错');
                            }
                        });
                    };

                    function getMembers() {
                        return Utils.api('/users/get_members', {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('数据出错');
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
                                className: 'theme-grey',
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
                                className: 'theme-grey',
                                width: 500,
                                ok: function () {
                                    var selectedConsumptions = _.where($scope.consumptions, {
                                        isSelected: true
                                    });
                                    $scope.selectedConsumptions = angular.copy(selectedConsumptions) || [];
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
                                className: 'theme-grey',
                                buttonAlign: 'right',
                                ok: function () {

                                    var account = this.$el.find('.account input').val();
                                    var cardNumber = this.$el.find('.card-number input').val();
                                    var subbranch = this.$el.find('.subbranch input').val();

                                    if(!account) {
                                        this.$el.find('.account input').focus();
                                        return false;
                                    }
                                    if(!cardNumber) {
                                        this.$el.find('.card-number input').focus();
                                        return false;
                                    }

                                    if(!$scope.selected_bankName) {
                                        this.$el.find('.bank-db-list .text').click();
                                        return false;
                                    }

                                    if($scope.selected_cardType===undefined) {
                                        this.$el.find('.card-type .text').click();
                                        return false;
                                    }

                                    if(!$scope.selected_province) {
                                        this.$el.find('.province .text').click();
                                        return false;
                                    }

                                    if(!$scope.selected_city) {
                                        this.$el.find('.city .text').click();
                                        return false;
                                    }
                                    if(!subbranch) {
                                        this.$el.find('.subbranch input').focus();
                                        return false;
                                    }

                                    var data = {
                                        bank_name: $scope.selected_bankName,
                                        bank_location: $scope.selected_province + $scope.selected_city,
                                        cardno: cardNumber,
                                        cardtype: $scope.selected_cardType,
                                        account: account,
                                        uid: window.__UID__,
                                        subbranch: subbranch,
                                        default: 0
                                    };

                                    var _this = this;
                                    Utils.api('/bank', {
                                        env: 'online',
                                        method: 'post',
                                        data: data
                                    }).done(function (rs) {
                                        if(rs['status']<=0) {
                                            return;
                                        }
                                        _this.close();
                                    });
                                },
                                cancel: function () {
                                    this.close();
                                },
                                onHide: function () {
                                    this.$el.find('.account input').val('');
                                    this.$el.find('.card-number input').val('');
                                    this.$el.find('.subbranch input').val('');

                                    this.$el.find('.bank-db-list .text').text('请选择银行').addClass('font-placeholder');
                                    this.$el.find('.card-type .text').text('请选择卡类型').addClass('font-placeholder');
                                    this.$el.find('.province .text').text('请选择省').addClass('font-placeholder');
                                    this.$el.find('.city .text').text('请选择市').addClass('font-placeholder');

                                }
                            });

                            getBankDB();
                            getProvince();

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
                            getTemplateData($element.find('.report').data('tid')),
                            getAvailableConsumptions(),
                            getMembers(),
                            getCurrentUserBanks()
                        ).done(function () {
                            callback.apply(null, arguments);
                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                        });
                    };
                    // main entry
                    getPageData(function (template, consumptions, members, banks) {
                        $scope.isLoaded = true;

                        if (template['status'] <= 0 || banks['status'] <= 0 || consumptions['status']<=0 || members['status']<=0) {
                            return;
                        }

                        $scope.banks = banks['banks'] || [];
                        $scope.default_bank = findOneInBanks(banks['default_bank'], banks['banks']);
                        if(!$scope.default_bank) {
                            if($scope.banks.length>0) {
                                $scope.default_bank = $scope.banks[0];
                            }
                        }

                        $scope.template = angular.copy(template['data']);

                        $scope.consumptions = consumptions['data'] || [];

                        var members = members['data'];

                        $scope.members = members['members'];

                        $scope.rankMap = arrayToMapWithKey('id', members['rankArray']);

                        $scope.levelMap = arrayToMapWithKey('id', members['levelArray']);

                        $scope.$apply();
                        
                        setTimeout(function () {
                            initDatetimepicker('.datatimepicker input');
                        }, 100);

                        // if edit will get the page data;
                        (function tryMatchEdit() {
                            var router = new RouteRecognizer();
                            router.add([{path: "/reports/:type/:id"}]);
                            var matchers = router.recognize(location.pathname);
                            if(matchers.length>0) {
                                var m = matchers[0];
                                if(m.params['type']=='edit') {
                                    $scope.__edit__ = true;
                                    $scope.__report_id__ = m.params['id'];
                                    getReportData(m.params['id']).done(function (rs) {
                                        if (rs['status']<=0){
                                            return show_notify('获取数据失败');
                                        }
                                        var data = rs['data'];
                                        $scope.originalReport = angular.copy(data);

                                        $scope.selectedConsumptions = data['items'];

                                        syncDatatToView();

                                        $scope.$apply();
                                    });
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

                    function getProvince() {
                        return Utils.api("/static/province.json", {
                            dataType: 'json'
                        }).done(function (rs) {
                            $scope.__PROVINCE_WITH_CITIES__ = rs;
                            $scope.$apply();
                        });
                    };

                    $scope.makeDropDownProvince = {
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.selected_province = newValue;

                            var cities = _.findWhere($scope.__PROVINCE_WITH_CITIES__, {
                                name: newValue
                            });

                            $scope.__CITIES__ = cities['city'];

                            $('.bank-form .city').find('.text').text('请选择城市').addClass('font-placeholder');
                            $('.bank-form .city').find('.option-list .item:contains(' +newValue+ ')').addClass('active').siblings().removeClass('active');

                            $scope.$apply();
                        }
                    };

                    $scope.makeDropDownCity = {
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.selected_city = newValue;
                        }
                    }

                    $scope.makeDropDownBankTypes = {
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.selected_cardType = $(item).data('value');
                        }
                    }
                                    
                    $scope.makeDropDownBankDB = {
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.selected_bankName = newValue
                        }
                    }

                    function getBankDB() {
                        return Utils.api('/bank/get_banks/0', {
                            dataType: 'json'
                        }).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('找不到数据');
                            }
                            var data = rs['data']['bank_dic'];
                            $scope.BAND_DB = data;
                            $scope.PREFIX_BANK_CODE = (function changeBankDataToMap() {
                                var bankMap = {};
                                for (var name in data) {
                                    var prefixArray = data[name];
                                    for (var i = 0; i < prefixArray.length; i++) {
                                        bankMap[prefixArray[i]] = name;
                                    }
                                }
                                return bankMap;
                            })(data);
                            $scope.$apply()
                        });
                    };

                    $scope.bankCardTypes = [
                        {value: 0, text: '借记卡'},
                        {value: 1, text: '信用卡'},
                        {value: 2, text: '其它'}
                    ];
                            
                    $scope.onBankNumberChange = function () {
                        var value = $scope.formBankNumber;
                        if (value.length < 6) {
                            return;
                        }
                        value = value.substring(0, 6);
                        var name = $scope.PREFIX_BANK_CODE[value];
                        if (name) {
                            $('.bank-form .bank-db-list').find('.text').text(name).removeClass('font-placeholder');
                        };
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

                    function syncDatatToView() {;
                        $scope.title = $scope.originalReport['title'];
                        $scope.selectedConsumptions = angular.copy($scope.originalReport['items']);
                        $scope.selectedMembers = angular.copy($scope.originalReport['receivers']['managers']);

                        var oldConsumptions = angular.copy($scope.originalReport['receivers']['managers']);
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
                            extras = JSON.parse(extras || '[]');
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

                    function syncDataModel(data) {
                        getReportData($scope.__report_id__).done(function (rs) {
                            if(rs['status']<=0) {
                                return ;
                            }
                            $scope.originalReport = rs['data'];
                        });
                    };

                    $scope.onCancel = function (e) {
                        syncDatatToView();
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
                                syncDataModel();
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
                            syncDataModel();
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
                                show_notify('提交成功');
                                $scope.report_status = 1;
                                syncDataModel();

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
                            syncDataModel();
                        });
                    };

                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型