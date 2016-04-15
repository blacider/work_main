// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    
    var _templateNameLengthLimit_ = 10;

    var _defaultTemplateName_ ='未命名报销单模板';

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
                    $scope.default_avatar = '/static/img/mod/report/default-avatar.png';

                    $scope.originalReport = {
                        receivers: {}
                    }

                    function getTemplateData(id) {

                        if(!id) {
                            var def = $.Deferred();
                            def.resolve({
                                status: 1,
                                data: {
                                    name: _defaultTemplateName_,
                                    config: [],
                                    type: [0]
                                }
                            });
                            return def.promise();
                        }

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

                    function getAvailableConsumptions(uid) {
                        return Utils.api('/items/1/60/'+uid, {
                            env: 'online'
                        }).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('数据出错');
                            }
                        });
                    };

                    function getCategories() {
                        return Utils.api('/common/0', {
                            env: 'online'
                        }).done(function (rs) {
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
                    }

                    function getReportUserProfile(uid) {
                        return Utils.api('/users/get_user_profile/' + uid, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('数据出错');
                            }
                        });
                    }
 
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
                                buttonAlign: 'right',
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
                                },
                                okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                                cancel: function () {
                                    this.close()
                                },
                                cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png',
                            });

                            $($element.find('.available-members .stop-parent-scroll')).on('mousewheel', function (e) {
                                var event = e.originalEvent,
                                d = event.wheelDelta || -event.detail;
                                console.log(d);
                                this.scrollTop += d *-1;
                                e.preventDefault();
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
                                buttonAlign: 'right',
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
                                },
                                buttons: [
                                    {
                                        align: 'left',
                                        text: '新建消费',
                                        iconUrl: '/static/img/mod/report/24/btn-consumption@2x.png',
                                        handler: function () {
                                            window.location =  '/items/newitem';
                                        }
                                    }
                                ],
                                okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                                cancel: function () {
                                    this.close()
                                },
                                cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png',
                            });

                            $($element.find('.available-consumptions .stop-parent-scroll')).on('mousewheel', function (e) {
                                var event = e.originalEvent,
                                d = event.wheelDelta || -event.detail;
                                console.log(d);
                                this.scrollTop += d *-1;
                                e.preventDefault();
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

                    function tryMatchEdit() {
                        var router = new RouteRecognizer();
                        router.add([{path: "/reports/:type/:id"}]);
                        var matchers = router.recognize(location.pathname);
                        if(matchers.length>0) {
                            var m = matchers[0];
                            if(m.params['type']=='edit') {

                                $scope.__edit__ = true;
                                $scope.__report_id__ = m.params['id'];
                                return getReportData(m.params['id']).done(function (rs) {
                                    if (rs['status']<=0){
                                        return show_notify('获取数据失败');
                                    }
                                });
                            }
                        } 
                        var def = $.Deferred();
                        def.resolve();
                        return def.promise();
                    };

                    function getPageData(callback) {
                        // 1.如果是编辑报销单，当前用户可能是审批人，应该获取提交者的信息，而不是审批人的信息
                        // 2.如果是添加报销单，就比较简单
                        // 3.这里考虑一下先根据router type 获取报销单数据比较靠谱

                        // if edit will get the page data;
                        tryMatchEdit().done(function (rs) {
                            var report_uid = window.__UID__;
                            if($scope.__edit__) {
                                if (rs['status']<=0) {
                                    callback.call(null, rs);
                                    return show_notify('获取数据失败');
                                }
                                $scope.originalReport = rs.data;

                               
                                var report_uid = rs['data']['uid'];
                            }

                            $.when(
                                getTemplateData($element.find('.report').data('tid')),
                                getAvailableConsumptions(report_uid),
                                getMembers(),
                                getReportUserProfile(report_uid),
                                getCategories()
                            ).done(function () {
                                callback.apply(null, arguments);
                                // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                            });
                        })

                        
                    };
                    // main entry
                    // getPageData(function (template, consumptions, members, banks, superior_id) {
                    getPageData(function (template, consumptions, members, profile, category) {

                        $scope.isLoaded = true;

                        if (template['status'] <= 0 || profile['status'] <= 0 || consumptions['status']<=0) {
                            return;
                        }

                        var profileData = profile['data'];

                        $scope.banks = profileData['banks'] || [];

                        $scope.default_bank = _.find($scope.banks, {
                            id: profileData['credit_card']
                        });


                        var categoryArray = category['data']['categories'];

                        $scope.categoryMap = arrayToMapWithKey('id', categoryArray);

                        $scope.report_user_name = profileData['nickname'];

                        _.each($scope.banks, function (item) {
                            item.report_user_name =  $scope.report_user_name;
                        });

                        if(!$scope.default_bank) {
                            if($scope.banks.length>0) {
                                $scope.default_bank = $scope.banks[0];
                            }
                        }
                        setTimeout(function () {

                            $scope.banks.unshift({
                                text: '无',
                                id: -1
                            });

                            $scope.$apply();

                        }, 100);

                        $scope.template = angular.copy(template['data']);
                        if(!$scope.template.name) {
                            $scope.template.name = _defaultTemplateName_;
                        }

                        if(!$scope.__edit__) {
                            // set breadca name
                            $('.breadcrumb li:last').text('新建' + $scope.template.name);
                        }

                        $scope.consumptions = consumptions['data']['data'] || [];

                        var members = members['data'];

                        $scope.members = members['members'];

                        $scope.selectedMembers = _.map($scope.originalReport['receivers']['managers'], function (item) {
                            return _.find($scope.members, {
                                id: item.id + ''
                            });
                        });


                        $scope.superior = _.find($scope.members, {
                            id: profileData['manager_id']
                        });

                        if($scope.__edit__) {
                            syncDatatToView();
                        }

                        $scope.$apply();
                        
                        setTimeout(function () {
                            initDatetimepicker('.datatimepicker input');
                        }, 100);
                    });

                    $scope.searchImmediate = function (keywords) {
                        return function( item ) {

                            delete item.multi_property_matcher;

                            if(!keywords) {
                                return true;
                            }

                            if(item.nickname.indexOf(keywords)>=0) {
                                item.multi_property_matcher = 0
                                return true;
                            }
                            if(item.phone.indexOf(keywords)>=0) {
                                item.multi_property_matcher = item.phone
                                return true;
                            }
                            if(item.email.indexOf(keywords)>=0) {
                                item.multi_property_matcher = item.email
                                return true;
                            }

                            return false;
                        };
                    };

                    $scope.onTextLengthChange2 = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if(str.length>=_templateNameLengthLimit_) {
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

                    $scope.makeBankDropdown = {
                        itemFormat: function (item) {
                            if(!item || !item.id) {
                                return {
                                    text: ''
                                }
                            }
                            if(item.id==-1) {
                                return {
                                    value: -1,
                                    text: '无'
                                }
                            }

                            return {
                                value: item['id'],
                                text:  [item.report_user_name, '-', '尾号' + item.cardno.substr(-4), '-', item.bankname].join('') || '--'
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
                    };

                    $scope.onSelectMember = function (item, e) {
                        item.isSelected = !item.isSelected;
                    };

                    $scope.has_select_consumption = true;
                    $scope.has_deselect_consumption = false

                    $scope.onSelectConsumption = function (item, e) {
                        item.isSelected = !item.isSelected;
                        var unSelectedItem = _.filter($scope.consumptions, function (item) {
                            if(!item.isSelected) {
                                return true;
                            }
                        });
                        if(unSelectedItem.length>0) {
                            $scope.has_select_consumption = true;
                            $scope.has_deselect_consumption = false;
                        }
                    };
                    $scope.onSelectAllConsumptions = function (e) {
                        _.each($scope.consumptions, function (item) {
                            item.isSelected = true;
                        });
                        $scope.has_select_consumption = false;
                        $scope.has_deselect_consumption = true;
                    };
                    $scope.onDeselectAllConsumptions = function (e) {
                        _.each($scope.consumptions, function (item) {
                            item.isSelected = false;
                        });
                        $scope.has_select_consumption = true;
                        $scope.has_deselect_consumption = false;
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
                                if(!bank) {
                                    bank = {};
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

                    // 特别注意当extras 为空的时候怎么同步数据
                    function syncDatatToView() {;
                        $scope.title = $scope.originalReport['title'];
                        $scope.selectedConsumptions = angular.copy($scope.originalReport['items']) || [];
                        $scope.selectedMembers = angular.copy($scope.originalReport['receivers']['managers']) || [];

                        var oldConsumptions = angular.copy($scope.selectedConsumptions);
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
                            // 通过 field来遍历
                            var extrasMap = arrayToMapWithKey('id', extras);
                            $element.find('.field-item-list .field-item').map(function (i, item) {
                                var itemType = $(item).data('type')+'';
                                var id = $(item).data('id');
                                var itemData = extrasMap[id];

                                // 更新DOM
                                var $input = $('.field-item[data-id="' +id+ '"]');
                                if(itemType=='1') {
                                    if(!itemData) {
                                        $input.find('input').val('');
                                        return
                                    }
                                    $input.find('input').val(itemData.value);
                                }
                                if(itemType=='2') {
                                    if(!itemData) {
                                        $input.find('.text').text('请选择').addClass('font-placeholder');
                                        return
                                    }
                                    $input.find('.text').text(itemData.value).removeClass('font-placeholder');
                                }
                                if(itemType=='3') {
                                    try {
                                        var date =  new Date(parseInt(itemData.value));
                                        $input.find('input').val(fecha.format(date, 'YYYY-MM-DD'));
                                    } catch(e) {
                                        $input.find('input').val('');
                                    }
                                }
                                if(itemType=='4') {
                                    if(!itemData) {
                                        $input.find('.text').text('请选择').addClass('font-placeholder');
                                        return
                                    }
                                    var bankData = JSON.parse(itemData.value);
                                    bankData = findOneInBanks(bankData.cardno, $scope.banks, 'cardno');
                                    $scope.bankFieldMap[id] = bankData;
                                    $input.find('.text').text($scope.makeBankDropdown.itemFormat(bankData)['text']);
                                }
                            });
                        })($scope.originalReport.extras);
                    };

                    function syncDataModel() {
                        getReportData($scope.__report_id__).done(function (rs) {
                            if(rs['status']<=0) {
                                return ;
                            }
                            $scope.originalReport = rs['data'];
                        });
                    };

                    $scope.dateFormat = function(date, formatter) {
                        formatter || (formatter = 'YYYY-MM-DD hh:mm:ss');
                        if (date instanceof Date == false) {
                            date = new Date(parseInt(date * 1000));
                        }
                        return fecha.format(date, formatter);
                    }

                    $scope.onCancel = function (e) {
                        return window.location.href = '/reports/index';
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
                                    return show_notify(rs['data']['msg']);
                                }
                                show_notify('保存成功');
                                return window.location.href = '/reports/index';
                            });
                            return
                        }

                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data
                        }).done(function (rs) {
                            if(rs['status']<=0) {
                                return show_notify(rs['data']['msg']);
                            }
                            show_notify('保存成功');
                            $scope.__report_id__ = rs['data']['id'];
                            return window.location.href = '/reports/index';
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
                                    return show_notify(rs['data']['msg']);
                                }
                                window.location.href = "/reports";
                            });
                            return
                        }

                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data,
                        }).done(function (rs) {
                            if(rs['status']<=0) {
                                return show_notify(rs['data']['msg']);
                            }
                            show_notify('提交成功');
                            window.location.href = "/reports";
                        });
                    };

                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型