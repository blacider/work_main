(function() {
    var _templateNameLengthLimit_ = 10;
    var _defaultTemplateName_ = '未命名报销单模板';
    return {
        initialize: function() {
            angular.module('reimApp', ['ng-sortable', 'ng-dropdown', 'historyMembers']).controller('ReportController', ["$http", "$scope", "$element", "$timeout", "$sce", "historyMembersManagerService",
                function($http, $scope, $element, $timeout, $sce, historyMembersManager) {
                    $scope.bankFieldMap = {};
                    $scope.radioFieldMap = {};
                    $scope.selectedMembers = [];
                    $scope.selectedMembersCC = [];
                    $scope.selectedConsumptions = [];
                    $scope.banks = [];
                    $scope.default_bank = null;
                    $scope.template = null;
                    $scope.default_avatar = '/static/img/mod/report/default-avatar.png';
                    $scope.originalReport = {
                        receivers: {}
                    };

                    function getTemplateData(id) {
                        if (!id) {
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
                        return Utils.api('/template/get_template/' + id, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到模版');
                            }
                        });
                    };

                    function getReportData(id) {

                        var def = $.Deferred();
                        Utils.api('/reports/detail/' + id, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                def.resolve(rs);
                                return  show_notify('找不到数据');
                            }
                            if(rs['data'].has_snapshot) {
                                getReportSnapshotData(id).done(function (sn) {

                                    $scope.snapshot = sn['data'];
                                    $scope.$apply();

                                    def.resolve(rs, sn);

                                });
                            } else {
                                return def.resolve(rs);
                            }
                        });
                        return def.promise();
                    };

                    function getReportSnapshotData(id) {
                        return Utils.api('/report/'+id+'/snapshot', {
                            env: 'online'
                        }).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到数据');
                            }
                        });
                    };

                    function getAvailableConsumptions() {
                        return Utils.api('/sync/0', {
                            env: 'online'
                        }).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('数据出错');
                            }
                        });
                    };

                    function checkSubmit(data) {
                        /** data = {
                            iids
                            manager_ids
                            template_id
                            extras
                        }
                        */
                        return Utils.api('/check_submit_flow', {
                            method: 'post',
                            env: 'online',
                            data: data
                        }).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('数据出错');
                            }
                        });
                    };

                    function getMembers() {
                        return Utils.api('/users/get_members', {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('数据出错');
                            }
                        });
                    }

                    function getReportUserProfile(uid) {
                        return Utils.api('/users/get_user_profile/' + uid, {}).done(function(rs) {
                            if (rs['status'] < 0) {
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
                    var dialogMemberSingleton = (function() {
                        var instance;

                        function createInstance() {
                            var dialog = new CloudDialog({
                                title: '选择审批人',
                                quickClose: true,
                                autoDestroy: false,
                                buttonAlign: 'right',
                                className: 'theme-grey',
                                ok: function() {
                                    var selectedMembers = _.where($scope.members, {
                                        isSelected: true
                                    });

                                    var history = _.where($scope.suggestionMembers, {
                                        isSelected: true
                                    });

                                    if(history) {
                                        // 去重复
                                        _.each(history, function (item, index) {
                                            var one = _.find(selectedMembers, {
                                                id: item.id
                                            });
                                            if(!one) {
                                                selectedMembers.unshift(one);
                                            }
                                        })
                                    }

                                    // 这个_CONFIG_就说明要用选抄送的或者别的逻辑，其实就是区别抄送和审核人
                                    if (this._CONFIG_ && this._CONFIG_['ok']) {
                                        this._CONFIG_['ok'](selectedMembers);
                                        this.close();
                                        return
                                    }
                                    $scope.selectedMembers = angular.copy(selectedMembers);
                                    // 如果有members 中选中了superior 被选中，然后视图中也存在，就把selectedMembers中的干掉
                                    if ($scope.superior) {
                                        var index = _.findIndex($scope.selectedMembers, {
                                            id: $scope.superior.id
                                        });
                                        if (index >= 0) {
                                            $scope.selectedMembers.splice(index, 1);
                                        }
                                    }
                                    $scope.$apply();
                                    this.close();
                                },
                                onShow: function() {
                                    var selectedMembers = $scope.selectedMembers;
                                    if (this._CONFIG_ && this._CONFIG_['selectedMembers']) {
                                        selectedMembers = this._CONFIG_['selectedMembers'];
                                    }

                                    // 不在members 中展示history members
                                    // 重置顺便过滤
                                    for (var i = 0; i < $scope.members.length; i++) {
                                        var item = $scope.members[i];
                                        item.isSelected = false;
                                        delete item['_IN_SUG_'];
                                        var one = _.find($scope.suggestionMembers, {
                                            id: item.id
                                        });
                                        if(one) {
                                            item['_IN_SUG_'] = true;
                                        }
                                    }

                                    for (i = 0; i < $scope.suggestionMembers.length; i++) {
                                        item = $scope.suggestionMembers[i];
                                        item.isSelected = false;
                                    }

                                    for (var i = 0; i < selectedMembers.length; i++) {
                                        var item = selectedMembers[i];
                                        Utils.updateArrayByQuery($scope.members, {
                                            id: item.id + ''
                                        }, {
                                            isSelected: true
                                        });
                                        Utils.updateArrayByQuery($scope.suggestionMembers, {
                                            id: item.id + ''
                                        }, {
                                            isSelected: true
                                        })
                                    }

                                    if ($scope.superior && !this._CONFIG_) {
                                        var one = _.find($scope.members, {
                                            id: $scope.superior.id + ''
                                        });
                                        one.isSelected = true;
                                    }
                                },
                                onHide: function() {
                                    delete this._CONFIG_;
                                },
                                okIcon: true,
                                cancel: function() {
                                    this.close()
                                },
                                cancelIcon: true
                            });
                            dialog.setContentWithElement($($element.find('.available-members')));
                            return dialog;
                        }
                        return {
                            getInstance: function() {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();
                    var dialogConsumptionSingleton = (function() {
                        var instance;

                        function createInstance() {



                            var dialog = new CloudDialog({
                                title: '选择消费',
                                quickClose: true,
                                autoDestroy: false,
                                buttonAlign: 'right',
                                className: 'theme-grey dialog-consumption',
                                width: 500,
                                ok: function() {
                                    var selectedConsumptions = _.where($scope.consumptions, {
                                        isSelected: true
                                    });
                                    $scope.selectedConsumptions = angular.copy(selectedConsumptions) || [];
                                    $scope.$apply();
                                    this.close();
                                },
                                onShow: function() {
                                    for (var i = 0; i < $scope.consumptions.length; i++) {
                                        var item = $scope.consumptions[i];
                                        item.isSelected = false;
                                    }
                                    for (i = 0; i < $scope.selectedConsumptions.length; i++) {
                                        var item = $scope.selectedConsumptions[i];
                                        var one = _.find($scope.consumptions, {
                                            id: item.id
                                        });
                                        if(one) {
                                            one.isSelected = true;
                                        }
                                    }
                                    setTimeout(function () {
                                        $(window).trigger('resize');
                                    })
                                },
                                buttons: [{
                                    align: 'left',
                                    text: '新建消费',
                                    className: 'btn-consumption',
                                    icon: true,
                                    handler: function() {
                                        window.location = '/items/newitem';
                                    }
                                }],
                                okIcon: true,
                                cancel: function() {
                                    this.close()
                                },
                                cancelIcon: true
                            });

                            if($scope.is_approver) {
                                dialog.removeButtonByIndex(0);
                            }

                            dialog.setContentWithElement($($element.find('.available-consumptions')));
                            return dialog;
                        }
                        return {
                            getInstance: function() {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();
                    var dialogAddBankSingleton = (function() {
                        var instance;

                        function createInstance() {
                            var dialog = new CloudDialog({
                                title: '添加银行卡',
                                quickClose: true,
                                autoDestroy: false,
                                className: 'theme-grey',
                                buttonAlign: 'right',
                                ok: function() {
                                    var _this = this;
                                    var account = this.$el.find('.account input').val();
                                    var cardNumber = this.$el.find('.card-number input').val();
                                    var subbranch = this.$el.find('.subbranch input').val();
                                    if (!account) {
                                        this.$el.find('.account input').focus();
                                        return false;
                                    }
                                    if (!cardNumber || cardNumber.length <= 6) {
                                        this.$el.find('.card-number input').focus();
                                        return false;
                                    }
                                    if (!$scope.selected_bankName) {
                                        setTimeout(function(e) {
                                            _this.$el.find('.bank-db-list .text').click();
                                        }, 70);
                                        return false;
                                    }
                                    if ($scope.selected_cardType === undefined) {
                                        setTimeout(function(e) {
                                            _this.$el.find('.card-type .text').click();
                                        }, 70);
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
                                        'default': 0
                                    };
                                    Utils.api('/bank', {
                                        env: 'online',
                                        method: 'post',
                                        data: data
                                    }).done(function(rs) {
                                        
                                        if (rs['status'] <= 0) {
                                            return;
                                        }

                                        var b = {
                                            'account': data['account'],
                                            'bankloc': data['bank_location'],
                                            'bankname': data['bank_name'],
                                            'cardno': data['cardno'],
                                            'cardtype': data['cardtype'],
                                            'id': rs['data']['id'],
                                            'subbranch': data['subbranch'],
                                            'uid': data['uid']
                                        };
                                        
                                        $scope.banks.push(b);
                                        $scope.$apply();
                                        _this.close();
                                    });
                                },
                                cancel: function() {
                                    this.close();
                                },
                                onHide: function() {
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
                            getInstance: function() {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();

                    function initDatetimepicker(selector) {

                        // $.fn.datetimepicker.dates['en'] = {
                        //     days: ["日", "一", "二", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                        //     daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                        //     daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
                        //     months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        //     monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        //     today: "Today"
                        // };

                        $(selector).datetimepicker({
                            language: 'zh-CN',
                            format: 'yyyy-mm-dd',
                            minView: 'month',
                            maxView: 'month',
                            todayBtn: true,
                            todayHighlight: true,
                            autoclose: true
                        }).on('changeDate', function(e) {
                            var date = e.date;
                            $(this).val(fecha.format(date, 'YYYY-MM-DD'));
                        });
                        $(selector).parent().find('.icon').click(function(e) {
                            $(e.currentTarget).parent().find('input').trigger('focus');
                        });
                    };

                    function findOneInBanks(id, banks, pro) {
                        banks || (banks = []);
                        pro || (pro = 'id');
                        for (var i = 0; i < banks.length; i++) {
                            var b = banks[i];
                            if (id == b[pro]) {
                                return b;
                            }
                        }
                        return null;
                    };

                    function tryMatchEdit() {
                        var router = new RouteRecognizer();
                        router.add([{
                            path: "/reports/:type/:id"
                        }]);
                        var matchers = router.recognize(location.pathname);
                        if (matchers.length > 0) {
                            var m = matchers[0];
                            if (m.params['type'] == 'edit') {
                                $scope.__edit__ = true;
                                $scope.__report_id__ = m.params['id'];
                                return getReportData(m.params['id']).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify('获取数据失败');
                                    }

                                    $scope.report = rs['data'];

                                });
                            }
                        }
                        var def = $.Deferred();
                        def.resolve();
                        return def.promise();
                    };

                    $scope.getItemsAmount = function (arr) {
                        var amount = 0;
                        _.each(arr, function(item) {
                            var a = parseFloat(item.amount);
                            amount += a;
                        });
                        amount = amount.toFixed(2);
                        return amount;
                    };
                    

                    function getPageData(callback) {
                        // 1.如果是编辑报销单，当前用户可能是审批人，应该获取提交者的信息，而不是审批人的信息
                        // 2.如果是添加报销单，就比较简单
                        // 3.这里考虑一下先根据router type 获取报销单数据比较靠谱
                        // if edit will get the page data;
                        tryMatchEdit().done(function(rs) {
                            var report_uid = window.__UID__;
                            if ($scope.__edit__) {
                                if (rs['status'] <= 0) {
                                    callback.call(null, rs);
                                    return show_notify('获取数据失败');
                                }
                                $scope.originalReport = rs.data;
                                $scope.report = rs.data;
                                // 已经提交了的
                                if ($scope.report.status == 1) {
                                    // window.location.href = '/reports/index';
                                }
                                var report_uid = rs['data']['uid'];
                            }
                            $.when(getTemplateData($element.find('.report').data('tid')), getAvailableConsumptions(report_uid), getMembers(), getReportUserProfile(report_uid)).done(function() {
                                callback.apply(null, arguments);
                                // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                            });
                        })
                    };
                    // main entry
                    // getPageData(function (template, consumptions, members, banks, superior_id) {
                    getPageData(function(template, consumptions, members, profile) {
                        $scope.isLoaded = true;
                        if (template['status'] <= 0 || profile['status'] <= 0 || consumptions['status'] <= 0) {
                            return;
                        }
                        var profileData = profile['data'];
                        $scope.banks = profileData['banks'] || [];
                        if ($scope.banks.length > 0) {
                            $scope.banks.unshift({
                                text: '其它',
                                id: -1
                            });
                        }
                        $scope.default_bank = _.find($scope.banks, {
                            id: profileData['credit_card']
                        });
                       
                        $scope.template = angular.copy(template['data']);
                        if (!$scope.template.name) {
                            $scope.template.name = _defaultTemplateName_;
                        }

                        $scope.consumptions = consumptions['data']['items'] || [];

                        var members = members['data'];
                        $scope.members = members['members'];
                        $scope.suggestionMembers = historyMembersManager.getArray($scope.members);
                        $scope.originalMembers = angular.copy($scope.members);
                        if ($scope.__edit__) {
                            // 编辑无上级寻找上级
                            if ($scope.originalReport['receivers']['managers'].length == 0) {
                                $scope.superior = _.find($scope.members, {
                                    id: profileData['manager_id']
                                });
                                if ($scope.superior) {
                                    $scope.superior.tag_for_superior = true;
                                }
                            }

                            $scope.hasCC = true;
                             
                            // 判断身份
                            (function() {
                                // 是否是自己
                                var is_myself = window.__UID__ == $scope.report.uid;
                                // 是否是审核人
                                var is_approver = (function() {
                                    var receivers = $scope.report.receivers['managers'];
                                    for (var i = 0; i < receivers.length; i++) {
                                        var re = receivers[i];
                                        if (window.__UID__ == re['id']) {
                                            return true;
                                        }
                                    }
                                    return false;
                                })();

                                if (is_approver) {
                                    $scope._disable_modify_approver_ = true;
                                }

                                $scope.is_myself = is_myself;
                                $scope.is_approver = is_approver;

                            })();

                            // 如果是审批人消费就用提交者选中的消费
                            if($scope.is_approver) {
                                $scope.consumptions = $scope.report.items;
                            }

                            $scope.availableConsumptions = (function () {
                                return _.filter($scope.consumptions, function (item) {
                                    if (item.rid == $scope.__report_id__ || item.rid == 0) {
                                        return true;
                                    }
                                    return false;
                                });
                            })();

                            $timeout(function () {
                                syncDatatToView();
                            }, 1000/16);
                            
                        } else {
                            // 设置sitemap
                            $('.breadcrumb li:last').text('新建' + $scope.template.name);
                            // 新建寻找上级
                            $scope.superior = _.find($scope.members, {
                                id: profileData['manager_id']
                            });
                            if ($scope.superior) {
                                $scope.superior.tag_for_superior = true;
                            }
                            // 删除自己——新建报销单不能选择自己
                            var selfIndex = _.findIndex($scope.members, {
                                id: __UID__
                            });
                            if (selfIndex >= 0) {
                                $scope.members.splice(selfIndex, 1);
                            }
                            $scope.hasCC = JSON.parse(profileData['group']['config'] || '{}')['enable_report_cc'];
                        }
                        $scope.$apply();
                        setTimeout(function() {
                            initDatetimepicker('.datatimepicker input');
                        }, 100);
                    });
                    
                    $scope.formatOptions = function (fieldItem) {
                        var options = fieldItem.property.options;
                        var rs = [];
                        for(var i= 0;i<options.length;i++) {
                            rs.push({
                                id: i,
                                text: options[i]
                            });
                        }
                        return rs;
                    };

                    $scope.searchImmediate = function(keywords) {
                        return function(item) {
                            delete item.info_html;
                            var tmpl = [
                                // 1
                                '<% if (!type) { %>',
                                '<div class="name"><%= nickname %></div>',
                                '<% } else { %>',
                                // <!-- 2.1 -->
                                    '<% if(type=="nickname") { %>',
                                    '<div class="name"><%= foo %></div>',
                                    '<% } else { %>',
                                    // <!-- 2.2 -->
                                    '<div class="name"><%= nickname %></div>',
                                    '<div class="role"><%= foo %></div>',
                                    '<% } %>',
                                '<% } %>'
                            ].join('');
                            if (!keywords) {
                                item.info_html = $sce.trustAsHtml(_.template(tmpl)({
                                    type: '',
                                    nickname: item.nickname
                                }));
                                return true;
                            }
                            var reg = new RegExp(keywords, 'i');
                            var proArray = ['nickname', 'phone', 'email'];
                            for (var i in proArray) {
                                var pro = proArray[i];
                                if (!item[pro]) {
                                    item[pro] = '';
                                }
                                var match = item[pro].match(reg);
                                if (match) {
                                    match = match.join('');
                                    var m = item[pro].replace(reg, '<span>' + match + '</span>');
                                    var multi_property_matcher = {
                                        type: pro,
                                        foo: m,
                                        nickname: item.nickname
                                    };
                                    item.info_html = $sce.trustAsHtml(_.template(tmpl)(multi_property_matcher));
                                    return true;
                                }
                            }
                            return false;
                        };
                    };
                     
                    $scope.onTextLengthChange2 = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if (str.length >= _templateNameLengthLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $input.val(str);
                            }, 50);
                        }
                    }, 1000);
                    $scope.onTextLengthChange = _.debounce(function(e) {
                        var $input = $(e.currentTarget);
                        var str = $input.val();
                        if (str.length >= _templateNameLengthLimit_) {
                            $timeout(function() {
                                str = str.substr(0, _templateNameLengthLimit_)
                                $scope.title = str
                            }, 50);
                        }
                    }, 1000);
                    $scope.makeBankDropdown = {
                        itemFormat: function(item) {
                            if (!item || !item.id) {
                                return {
                                    text: ''
                                }
                            }
                            if (item.id == -1) {
                                return {
                                    value: -1,
                                    text: '其它'
                                }
                            }
                            return {
                                value: item['id'],
                                text: [item.account, '-', '尾号' + item.cardno.substr(-4), '-', item.bankname].join('') || '--'
                            }
                        },
                        onDeselect: function (oldValue, el) {
                            var id = $(el).parents('.field-item').data('id');
                            delete $scope.bankFieldMap[id]
                        },
                        onChange: function(oldValue, newValue, item, columnData) {
                            var id = $(item).parents('.field-item').data('id');
                            var bank = findOneInBanks(newValue, $scope.banks);
                            $scope.bankFieldMap[id] = bank;
                        },
                        onInitValue: function(item, el) {
                            setTimeout(function() {
                                var id = $(el).parents('.field-item').data('id');
                                bank = findOneInBanks(item.value, $scope.banks);
                                $scope.bankFieldMap[id] = bank;
                            }, 100);
                        }
                    };

                    function getProvince() {
                        return Utils.api("/static/province.json", {
                            dataType: 'json'
                        }).done(function(rs) {
                            $scope.__PROVINCE_WITH_CITIES__ = rs;
                            $scope.$apply();
                        });
                    };

                    $scope.makeRadioDropDown = {
                        itemFormat: function (item) {
                            return item;
                        },
                        onChange: function(oldValue, newValue, item, columnData) {
                            var id = $(item).parents('.field-item').data('id');
                            $scope.radioFieldMap[id] = newValue;
                        },
                        onDeselect: function (oldValue, item) {
                            var id = $(item).parents('.field-item').data('id');
                            delete $scope.radioFieldMap[id]
                        }
                    };

                    $scope.makeDropDownProvince = {
                        onChange: function(oldValue, newValue, item, columnData) {
                            $scope.selected_province = newValue;
                            var cities = _.findWhere($scope.__PROVINCE_WITH_CITIES__, {
                                name: newValue
                            });
                            $scope.selected_city = null;
                            $scope.__CITIES__ = cities['city'];
                            $('.bank-form .city').find('.text').text('').addClass('font-placeholder');
                            $scope.$apply();
                            if ($scope.__CITIES__.length == 1) {
                                var first_city = $scope.__CITIES__[0];
                                $('.bank-form .city').find('.option-list .item:contains(' + first_city + ')').addClass('active');
                                $('.bank-form .city').find('.text').text(first_city).removeClass('font-placeholder');
                                $scope.selected_city = first_city;
                            }
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
                            // 修复下拉列表不消失的Bug
                            $('body').scrollTop($('body').scrollTop() + 1);
                        }
                    }

                    function getBankDB() {
                        return Utils.api('/bank/get_banks/0', {
                            dataType: 'json'
                        }).done(function(rs) {
                            if (rs['status'] < 0) {
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
                    $scope.bankCardTypes = [{
                        value: 0,
                        text: '借记卡'
                    }, {
                        value: 1,
                        text: '信用卡'
                    }, {
                        value: 2,
                        text: '其它'
                    }];
                    $scope.onBankNumberChange = function() {
                        var value = $scope.formBankNumber;
                        if (value.length < 6) {
                            return;
                        }
                        value = value.substring(0, 6);
                        var name = $scope.PREFIX_BANK_CODE[value];
                        if (name) {
                            $('.bank-form .bank-db-list').find('.text').text(name).removeClass('font-placeholder');
                            $scope.selected_bankName = name;
                        };
                    };
                    $scope.onAddBankCard = function(e) {
                        var dialog = dialogAddBankSingleton.getInstance();
                        dialog.showModal();
                    };
                    $scope.onAddApprovers = function(e, isCC) {
                        if (!$scope.members) {
                            return show_notify('正在加载数据......');
                        }
                        var dialog = dialogMemberSingleton.getInstance();
                        if (isCC) {
                            dialog._CONFIG_ = {
                                selectedMembers: $scope.selectedMembersCC,
                                ok: function(selectedMembers) {
                                    $scope.selectedMembersCC = angular.copy(selectedMembers);
                                    $scope.$apply();
                                }
                            }
                        }
                        dialog.showModal();
                    };
                    $scope.onRemoveApprover = function(item, isCC) {
                        if (item.tag_for_superior) {
                            $scope.superior = null;
                        }
                        var selectedMembers = $scope.selectedMembers;
                        if (isCC) {
                            selectedMembers = $scope.selectedMembersCC;
                        }
                        var index = _.findIndex(selectedMembers, {
                            id: item.id + ''
                        });
                        if (index >= 0) {
                            selectedMembers.splice(index, 1);
                        }
                    };

                    $scope.onRemoveHistory =  function (item) {
                        var index = _.findIndex($scope.suggestionMembers, {
                            id: item.id
                        });
                        
                        if(index>=0) {
                            $scope.suggestionMembers.splice(index, 1);
                            historyMembersManager.removeById(item.id);
                        }
                    };

                    $scope.onSelectMember = function(item, e) {
                        item.isSelected = !item.isSelected;
                    };
                    $scope.has_select_consumption = true;
                    $scope.has_deselect_consumption = false
                    $scope.onSelectConsumption = function(item, e) {
                        // 如果是审批人，就不能选择
                        if($scope.is_approver) {
                            return;
                        }

                        item.isSelected = !item.isSelected;
                        var unSelectedItem = _.filter($scope.consumptions, function(item) {
                            if (!item.isSelected) {
                                return true;
                            }
                        });
                        if (unSelectedItem.length > 0) {
                            $scope.has_select_consumption = true;
                            $scope.has_deselect_consumption = false;
                        }
                    };
                    $scope.onSelectAllConsumptions = function(e) {
                        _.each($scope.consumptions, function(item) {
                            if(item.rid==0 || item.rid == $scope.__report_id__) {
                                item.isSelected = true;
                            }
                        });
                        $scope.has_select_consumption = false;
                        $scope.has_deselect_consumption = true;
                    };
                    $scope.onDeselectAllConsumptions = function(e) {
                        _.each($scope.consumptions, function(item) {
                            item.isSelected = false;
                        });
                        $scope.has_select_consumption = true;
                        $scope.has_deselect_consumption = false;
                    };
                    $scope.onAddConsumptions = function(e) {
                        if (!$scope.consumptions) {
                            return show_notify('正在加载数据......');
                        }
                        var dialog = dialogConsumptionSingleton.getInstance();
                        dialog.showModal();
                    };

                    function readReportData() {
                        var title = $scope.title;
                        var template_id = $element.find('.report').data('tid');
                        var template_type = $element.find('.report').data('type');
                        if (!title) {
                            $element.find('.report-title input').focus();
                            show_notify('请添加报销单名');
                            return null;
                        }
                        var receiver_ids = $scope.selectedMembers.map(function(i) {
                            return i['id'];
                        });
                        var cc_ids = $scope.selectedMembersCC.map(function(i) {
                            return i['id'];
                        });
                        if ($scope.superior) {
                            receiver_ids.push($scope.superior.id);
                        }
                        if (receiver_ids.length <= 0) {
                            show_notify('请选择审批人');
                            $element.find('.btn-append button').eq(0).focus();
                            return null;
                        }
                        var item_ids = $scope.selectedConsumptions.map(function(i) {
                            return i['id'];
                        });
                        if (item_ids.length <= 0) {
                            if (~~$scope.template['options']['allow_no_items'] == 0) {
                                $element.find('.btn-add-consumptions').focus();
                                show_notify('提交的报销单消费不能为空');
                                return null;
                            }
                        }
                        // extras is fields content
                        var inValidExtras = false;
                        var extras = $element.find('.field-item-list .field-item').map(function(i, item) {
                            var type = $(item).data('type');
                            var id = $(item).data('id');
                            var value = $(item).find('input').val() || $(item).find('.text').text();
                            var isRequired = ~~$(item).data('required');
                            if (isRequired && !value) {
                                $(item).find('input').focus();
                                setTimeout(function () {
                                    $(item).find('.text').click();
                                }, 100);
                                inValidExtras = true;
                                return show_notify('请填写完整的信息');
                            }
                            var data = {
                                type: type,
                                id: id,
                                value: value
                            };

                            if(type==2) {
                                var field = $scope.radioFieldMap[id];
                                if(isRequired) {
                                    if(!field) {
                                        inValidExtras = true;
                                        setTimeout(function () {
                                            $(item).find('.text').trigger('click');
                                        }, 100);
                                        return show_notify('请填写完整的信息');
                                    }
                                    data.value = field.text;
                                } else {
                                    if(!field) {
                                        data.value = '';
                                    } else {
                                        data.value = field.text;
                                    }
                                }
                            }

                            if (type == 3) {
                                // 与android ios 保持一致
                                var dt = +(new Date(value));
                                data['value'] = (dt + '').substr(0, 10);
                            }
                            if (type == 4) {
                                var bank = $scope.bankFieldMap[id];
                                if (isRequired) {
                                    if (!bank) {
                                        inValidExtras = true;
                                        setTimeout(function () {
                                            $(item).find('.text').click();
                                        }, 100);
                                        show_notify('必填银行卡项目不能为空');
                                        return null
                                    }
                                }
                                if (!bank) {
                                    bank = {
                                        "account": '',
                                        "cardno": '',
                                        "bankname": '',
                                        "bankloc": '',
                                        "subbranch": ''
                                    };
                                }
                                data['value'] = JSON.stringify(bank);
                            }
                            return data;
                        }).toArray();
                        if (inValidExtras) {
                            return null;
                        }
                        return {
                            title: title,
                            template_id: template_id,
                            template_type: template_type,
                            receiver_ids: receiver_ids.join(','),
                            cc_ids: cc_ids.join(','),
                            item_ids: item_ids.join(','),
                            extras: JSON.stringify(extras)
                        }
                    };
                    // 特别注意当extras 为空的时候怎么同步数据
                    function syncDatatToView() {
                        $scope.title = $scope.originalReport['title'];
                        $scope.selectedConsumptions = angular.copy($scope.originalReport['items']) || [];
                        // 寻找标准成员数据
                        var selectedMembers = [];
                        _.each($scope.originalReport['receivers']['managers'], function(item) {
                            var one = _.find($scope.members, {
                                id: item.id + ''
                            });
                            if (one) {
                                selectedMembers.push(one);
                            }
                        });
                        $scope.selectedMembers = selectedMembers;
                        var selectedMembersCC = [];
                        _.each($scope.originalReport['receivers']['cc'], function(item) {
                            var one = _.find($scope.members, {
                                id: item.id + ''
                            });
                            if (one) {
                                selectedMembersCC.push(one);
                            }
                        });
                        $scope.selectedMembersCC = selectedMembersCC;
                        var oldConsumptions = angular.copy($scope.selectedConsumptions);
 
                        for (var i = 0; i < $scope.selectedMembers.length; i++) {
                            var item = $scope.selectedMembers[i];
                            var index = _.findIndex($scope.members, {
                                id: item['id'] + ''
                            });
                            if (index > -1) {
                                $scope.members[index].isSelected = true;
                            }
                        }
                        (function(extras) {
                            extras = JSON.parse(extras || '[]');
                            // 通过 field来遍历
                            var extrasMap = arrayToMapWithKey('id', extras);
                            $element.find('.field-item-list .field-item').map(function(i, item) {
                                var itemType = $(item).data('type');
                                var id = $(item).data('id');
                                var itemData = extrasMap[id];
                                // 更新DOM
                                var $input = $('.field-item[data-id="' + id + '"]');
                                if (itemType == 1) {
                                    if (!itemData) {
                                        $input.find('input').val('');
                                        return
                                    }
                                    $input.find('input').val(itemData.value);
                                }
                                if (itemType == 2) {
                                    if (!itemData) {
                                        $input.find('.text').addClass('font-placeholder');
                                        return
                                    }
                                    if(itemData.value) {
                                        // 有就需要选中
                                        $input.find('.option-list .item').each(function (index, item) {
                                            if($(item).text() == itemData.value) {
                                                $input.find('.text').text(itemData.value).removeClass('font-placeholder');
                                                $(item).addClass('active');
                                                $scope.radioFieldMap[id] = {text: itemData.value};
                                                return false;
                                            }
                                        })
                                    } 
                                }
                                if (itemType == 3) {
                                    try {
                                        var dt = itemData.value + '000';
                                        dt = dt.substr(0, 13);
                                        var date = new Date(parseInt(dt));
                                        $input.find('input').val(fecha.format(date, 'YYYY-MM-DD'));
                                    } catch (e) {
                                        $input.find('input').val('');
                                    }
                                }
                                if (itemType == 4) {
                                    if (!itemData) {
                                        return
                                    }
                                    var bankData = JSON.parse(itemData.value);

                                    var index = 0

                                    if(bankData.id==-1) {
                                        bankData = $scope.banks[0];
                                    } else {
                                        var index = _.findIndex($scope.banks, {
                                            cardno: bankData.cardno
                                        });
                                        bankData = $scope.banks[index];    
                                    }

                                    $scope.bankFieldMap[id] = bankData;
                                     
                                    if(bankData) {
                                        $input.find('.text').text($scope.makeBankDropdown.itemFormat(bankData)['text']).removeClass('font-placeholder');
                                        // 避免选中default 的
                                        setTimeout(function () {
                                            // body...
                                            $input.find('.option-list .item').removeClass('active').eq(index).addClass('active');
                                        }, 1000)
                                    }
                                }
                            });
                        })($scope.originalReport.extras);
                    };

                    $scope.dateFormat = function(date, formatter) {
                        formatter || (formatter = 'YYYY-MM-DD HH:mm:ss');
                        if (date instanceof Date == false) {
                            date = new Date(parseInt(date * 1000));
                        }
                        return fecha.format(date, formatter);
                    };

                    $scope.onCancel = function(e) {
                        return window.location.href = '/reports/index';
                    };

                    function getSuggestionDialog(data, isSubmitted) {
                        var suggestionMembers = _.filter($scope.originalMembers, function(item) {
                            var list = data['suggestion'].join(',').split(',');
                            if (_.contains(list, item.id)) {
                                return true;
                            }
                            return false;
                        });
                        var tmpl = ['<div class="suggestion-box">', '   <div>根据公司的规定，你的报销单需要提交给</div>', '   <% for(var i =0;i<list.length;i++) {', '           var item = list[i]; ', '   %>', '      <div class="receiver"><%= item.nickname %> - [<%= item.email %>]</div>', '   <%}%>', '</div>'].join('');
                        var dialog = new CloudDialog({
                            quickClose: true,
                            autoDestroy: false,
                            content: _.template(tmpl)({
                                list: suggestionMembers
                            }),
                            okValue: '按公司规定提交报销单',
                            ok: function() {
                                var d = readReportData();
                                if (!d) {
                                    return;
                                }
                                d['receiver_ids'] = data['suggestion'].join(',');
                                doPostReport(d, isSubmitted);
                            },
                            cancelValue: '按我的选择提交报销单',
                            cancel: function() {
                                var data = readReportData();
                                doPostReport(data, isSubmitted);
                                this.close();
                            }
                        });
                        return dialog;
                    };

                    function doPostReport(data, isSubmitted) {
                        if (!data) {
                            return;
                        }
                        data['status'] = isSubmitted ? 1 : 0;
                        if ($scope.__report_id__) {
                            Utils.api('/reports/update_v2', {
                                method: 'post',
                                data: $.extend({}, data, {
                                    id: $scope.__report_id__
                                })
                            }).done(function(rs) {
                                if (rs['status'] <= 0) {
                                    show_notify(rs['data']['msg']);
                                }

                                historyMembersManager.append([data.receiver_ids, data.cc_ids].join(','));
                                
                                if($scope.is_approver) {
                                    window.location.href = "/reports/show/" + rs.data.id + '?tid=' + data.template_id;
                                } else {
                                    window.location.href = "/reports";
                                }

                            });
                            return;
                        }
                        Utils.api('/reports/create_v2', {
                            method: 'post',
                            data: data
                        }).done(function(rs) {
                            if (rs['status'] <= 0) {
                                show_notify(rs['data']['msg']);
                            }

                            historyMembersManager.append([data.receiver_ids, data.cc_ids].join(','));

                            window.location.href = "/reports";

                        });
                    };
                    window.$scope =$scope;
                    // 首次创建，其次保存
                    $scope.onSave = $scope.onSubmit = function(e) {
                        var data = readReportData();
                        var isSubmitted = 1;
                        if ($(e.currentTarget).hasClass('btn-save')) {
                            isSubmitted = 0;
                            if($scope.is_approver) {
                                data['is_approver'] = true;
                            }
                        }
                        if (!data) {
                            return;
                        }
                        //     iids
                        //     manager_ids
                        //     template_id
                        //     extras

                        if(!$scope.__edit__) {
                            checkSubmit({
                                iids: data['item_ids'],
                                manager_ids: data['receiver_ids'],
                                template_id: data['template_id'],
                                extras: data['extras']
                            }).done(function(rs) {
                                if (rs['status'] <= 0) {
                                    return;
                                }
                                var sugData = rs['data'];
                                if (sugData.complete > 0) {
                                    return doPostReport(data, isSubmitted);
                                }
                                var dialog = getSuggestionDialog(sugData, isSubmitted);
                                dialog.showModal();
                            });
                        } else {
                            doPostReport(data, isSubmitted);   
                        }
                        
                    }
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型
