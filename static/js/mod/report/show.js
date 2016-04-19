// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    var _defaultTemplateName_ ='未命名报销单模板';
    return {
        initialize: function() {
            angular.module('reimApp', []).controller('ReportController', ["$http", "$scope", "$element", "$timeout",
                function($http, $scope, $element, $timeout) {
                    var routerObj = (function() {
                        var router = new RouteRecognizer();
                        router.add([{
                            path: "/reports/:type/:id"
                        }]);
                        var matchers = router.recognize(location.pathname);
                        var id = 0;
                        if (matchers.length > 0) {
                            var match = matchers[0];
                            return match.params;
                        }
                        return {};
                    })();
                    var report_id = routerObj['id'];
                    var path_type = routerObj['type'];

                    $scope.path_type = path_type;
                    $scope.extrasMap = {};
                    $scope.selectedMembers = [];
                    $scope.selectedConsumptions = [];
                    $scope.banks = [];
                    $scope.default_bank = null;
                    $scope.template = null;
                    $scope.originalReport = {
                        receivers: {}
                    };
                    $scope.default_avatar = '/static/img/mod/report/default-avatar.png';
                    $scope.comment_box = {
                        txtCommentMessage: ''
                    };

                    function getTemplateData() {
                        var query = Utils.queryString(location.search);
                        var id = query.tid;
                        if(!id || id=='0') {
                            var def = $.Deferred();
                            def.resolve({
                                status: 1,
                                data: {
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

                        if(path_type == 'snapshot') {
                            return getReportSnapshotData(id);
                        }

                        return Utils.api('/reports/detail/' + id, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到数据');
                            }
                        });
                    };

                    function getReportSnapshotData(id) {
                        return Utils.api('/report/'+id+'snapshot', {
                            env: 'online'
                        }).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到数据');
                            }
                        });
                    };

                    function getReportFlow(id) {
                        return Utils.api('/reports/get_report_flow_v2/' + id, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到数据');
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

                    function getAvailableConsumptions() {
                        return Utils.api('/reports/get_available_consumptions', {}).done(function(rs) {
                            $scope.consumptions = rs['data'] || [];
                            // $scope.consumptions = $scope.consumptions.splice(0, 10);
                            $scope.$apply();
                        });
                    };

                    function getMembers() {
                        return Utils.api('/users/get_members', {}).done(function(rs) {
                            var data = rs['data'];
                            $scope.members = data['members'] || [];
                            $scope.$apply();
                        });
                    };

                    function getPageData(callback) {
                        $.when(getTemplateData(), getReportData(report_id), getReportFlow(report_id), getMembers(), getCategories()).done(function() {
                            callback.apply(null, arguments);
                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                        })
                    };

                    // 通过报销单
                    function doPass(data, type) {
                        var url = '/report/' + report_id;
                        var method = 'put';
                        if(type == 'financial') {
                            url = '/report_finance_flow/pass/' + report_id;
                            method = 'post';
                        }
                        return Utils.api(url, {
                            method: method,
                            env: 'online',
                            data: data
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

                    function bankItemFormat(item) {
                        if (!item || !item.id) {
                            return {
                                text: ''
                            }
                        }
                        return {
                            value: item['id'],
                            text: '尾号' + item.cardno.substr(-4) + '-' + item.bankname || '--'
                        }
                    };

                    function formatFieldItemByExtrasMap(item, extrasMap) {
                        var extrasItem = extrasMap[item.id];
                        var itemType = item.type + '';
                        item.type = itemType;
                        if (!extrasItem) {
                            return {
                                value: '',
                                type: itemType
                            };
                        }
                        if (itemType == '4') {
                            var bankData = JSON.parse(extrasItem.value);
                            if(!bankData.cardno) {
                                bankData = $scope.default_bank;
                            } else {
                                bankData = findOneInBanks(bankData.cardno, $scope.banks, 'cardno');
                            }
                            item.value = angular.copy(bankData);
                        }
                        if (itemType == '3') {
                            var date = new Date(parseInt(extrasItem.value*1000));
                            try {
                                item.value = fecha.format(date, 'YYYY-MM-DD');
                            } catch(e) {}
                        }
                        return item;
                    };

                    function combineTemplateAndReport(template, report) {
                        var config = template.config;
                        for (var i = 0; i < config.length; i++) {
                            var tableItem = config[i];
                            for (var j = 0; j < tableItem.children.length; j++) {
                                var col = tableItem.children[j];
                                col._combine_data_ = formatFieldItemByExtrasMap(col, $scope.extrasMap);
                                console.log(col._combine_data_);
                            }
                        }
                    };
                    var dialogMemberSingleton = (function() {
                        var instance;

                        function createInstance() {
                            var dialog = new CloudDialog({
                                title: '将报销单提交给',
                                quickClose: true,
                                buttonAlign: 'right',
                                autoDestroy: false,
                                className: 'theme-grey',
                                ok: function() {
                                    var _this = this;
                                    var receivers = _.where($scope.members, {
                                        isSelected: true
                                    });

                                    var receivers_id = _.map(receivers, function(item) {
                                        return item.id;
                                    });
                                    
                                    Utils.api('report/' + report_id, {
                                        method: 'put',
                                        env: 'online',
                                        data: {
                                            status: 2,
                                            comment: '',
                                            manager_id: receivers_id.join(',')
                                        }
                                    }).done(function(rs) {
                                        if (rs['status'] <= 0) {
                                            return show_notify(rs['data']['msg']);
                                        }
                                        _this.close();
                                        window.location.href = '/reports/audit_todo'
                                    });
                                },
                                okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                                cancel: function () {
                                    this.close();
                                },
                                cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png',
                                onHide: function () {
                                    $scope.txtSearchText = '';
                                }
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
                            getInstance: function() {
                                if (!instance) {
                                    instance = createInstance();
                                }
                                return instance;
                            }
                        };
                    })();
                    // main entry
                    getPageData(function(template, report, flow, members, category) {
                        $scope.isLoaded = true;
                        if (report['status'] <= 0 || template['status'] <= 0 || flow['rs']<=0) {
                            return;
                        }
                        var reportData = report['data'];
                        var extras = JSON.parse(reportData['extras'] || "[]");
                        $scope.report = report['data'];
                        $scope.template = template['data'];
                        if(!$scope.template.name) {
                            $scope.template.name = _defaultTemplateName_;
                        }

                        $scope.members = members['data']['members'];
                        
                        $scope.selectedMembers = _.map($scope.originalReport['receivers']['managers'], function (item) {
                            return _.find($scope.members, {
                                id: item.id + ''
                            });
                        });

                        var categoryArray = category['data']['categories'];

                        $scope.categoryMap = arrayToMapWithKey('id', categoryArray);

                        $scope.userProfile = _.findWhere(members.data.members, {
                            id: window.__UID__
                        });
                        var amount = 0;
                        _.each($scope.report.items, function(item) {
                            var a = parseFloat(item.amount);
                            amount += a;
                        });
                        $scope.report.amount = amount.toFixed(2);
                        $scope.commentArray = _.map(reportData.comments.data, function(item, index) {
                            var one = _.findWhere($scope.members, {
                                id: item.uid
                            });
                            item.user = one;
                            return item;
                        });
                        $scope.extrasMap = arrayToMapWithKey('id', extras);
                        $scope.combineConfig = combineTemplateAndReport($scope.template, $scope.report)
                        $scope.flow = _.groupBy(flow['data']['data'], function(item) {
                            if (['-1', '0'].indexOf(item['ticket_type']) > -1) {
                                return '业务阶段';
                            } else if (['1'].indexOf(item['ticket_type']) > -1) {
                                return '财务阶段';
                            }
                        });
                        $scope.submitter = _.where(members.data.members, {
                            id: report['data']['uid']
                        })[0];

                        $scope.buttons = (function (rs) {

                            var buttons = {
                                has_reject: false,
                                has_modify: false,
                                has_pass: false,
                                has_drop: false,
                                has_affirm: false
                            }
                            // 0:  待提交
                            // 1:  待审批
                            // 2:  已通过
                            // 3:  退回
                            // 4:  已完成
                            // 7:  完成待确认
                            // 8:  完成已确认
                            var status = $scope.report.status;

                            // 是否是自己
                            var is_myself = window.__UID__ == $scope.report.uid;
                            // 是否是审核人

                            var is_approver = (function () {
                                var receivers = $scope.selectedMembers;
                                for(var i=0;i<receivers.length;i++) {
                                    var re = receivers[i];
                                    if(window.__UID__ == re['id']) {
                                        return true;
                                    }
                                }
                                return false;
                            })();

                            // 如果自己是审批人，把自己当成审批人
                            if(is_myself && is_approver) {
                                is_myself = false;
                            }

                            if(is_myself && ['0', '3'].indexOf(status)!=-1) {
                                buttons['has_modify'] = true;
                            }

                            if(is_myself && ['1', '2'].indexOf(status)!=-1) {
                                buttons['has_drop'] = true;
                            }

                            if(is_myself && ['7'].indexOf(status)!=-1) {
                                buttons['has_affirm'] = true;
                            }

                            if(is_approver && ['1'].indexOf(status)!=-1) {
                                buttons['has_pass'] = true;
                                buttons['has_reject'] = true;
                                buttons['has_modify'] = true;
                            }
                            return buttons;
                        })();
                        $scope.$apply();
                    });
                    $scope.dateFormat = function(date, formatter) {
                        formatter || (formatter = 'YYYY-MM-DD hh:mm:ss');
                        if (date instanceof Date == false) {
                            date = new Date(parseInt(date * 1000));
                        }
                        return fecha.format(date, formatter);
                    }
                    
                    $scope.onAddConsumptions = function(e) {
                        if (!$scope.consumptions) {
                            return show_notify('正在加载数据......');
                        }
                        var dialog = dialogConsumptionSingleton.getInstance();
                        dialog.showModal();
                    };
                    $scope.onAddCommentToReport = function(e) {
                        var comment = $scope.comment_box.txtCommentMessage;
                        comment = $.trim(comment);
                        if (!comment) {
                            return show_notify('评论内容不允许为空');
                        }
                        return Utils.api('/report/' + report_id, {
                            method: 'put',
                            env: 'online',
                            data: {
                                rid: report_id,
                                comment: comment
                            }
                        }).done(function(rs) {
                            if (rs['status'] <= 0) {
                                return show_notify('评论失败');
                            }
                            $scope.commentArray || ($scope.commentArray = []);
                            $scope.commentArray.unshift({
                                user: $scope.userProfile,
                                nickname: $scope.userProfile['nickname'],
                                apath: $scope.userProfile['apath'],
                                comment: comment,
                                lastdt: new Date
                            });
                            $scope.comment_box.txtCommentMessage = '';
                            $scope.$apply();
                        });
                    };

                    $scope.onSelectMember = function (item, e) {
                        item.isSelected = !item.isSelected;
                    };

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

                    $scope.onReject = function(id) {
                        var dialog = new CloudDialog({
                            title: '退回理由',
                            quickClose: true,
                            content: '<div><textarea style="width: 500px;height: 200px;border-radius: 2px;" placeholder="写下你的退回理由…"></textarea></div>',
                            className: 'theme-grey',
                            ok: function() {
                                var comment = this.$el.find('textarea').val();
                                comment = $.trim(comment);
                                if (!comment) {
                                    return show_notify('理由不能为空');
                                }
                                var _this = this;

                                var url = '/report/' + id

                                if($scope.report.status == '2') {
                                    url = '/report_finance_flow/deny/' + id;
                                }

                                Utils.api(url, {
                                    method: 'put',
                                    env: 'online',
                                    data: {
                                        status: 3,
                                        comment: this.$el.find('textarea').val(),
                                    }
                                }).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify(rs['data']['msg']);
                                    }
                                    _this.close();
                                    show_notify('已退回');
                                });
                            },
                            okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                            cancel: function () {
                                this.close()
                            },
                            cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png'
                        });
                        dialog.showModal();
                    };

                    $scope.onDrop = function(id) {
                        var dialog = new CloudDialog({
                            quickClose: true,
                            content: '确认要撤回报销单吗？',
                            className: 'theme-grey',
                            ok: function() {
                                Utils.api("/revoke/" + report_id, {
                                    env: 'online'
                                }).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify('操作失败');
                                    }
                                    window.location.reload()
                                });
                            },
                            okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                            cancel: function () {
                                this.close()
                            },
                            cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png'
                        });
                        dialog.showModal();
                    };

                    $scope.onAffirm = function(id) {
                        var dialog = new CloudDialog({
                            quickClose: true,
                            content: '确认已经收款?',
                            ok: function() {
                                Utils.api("/success", {
                                    env: 'online',
                                    data: {
                                        act: confirm,
                                        status: 2,
                                        rids: [report_id]
                                    }
                                }).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify('操作失败');
                                    }
                                    window.location.reload()
                                });
                            },
                            okIconUrl: '/static/img/mod/report/24/btn-ok@2x.png',
                            cancel: function () {
                                this.close()
                            },
                            cancelIconUrl: '/static/img/mod/report/24/btn-cancel@2x.png'
                        });
                        dialog.showModal();
                    };

                    // 首次创建，其次保存
                    $scope.onPass = function(id) {
                        
                        // 0-1:业务阶段, 2:财务阶段
                        var approve_type = '/check_approval_permission';
                        if($scope.report.status == '2') {
                            approve_type = '/report_finance_flow/check_permission'
                        }
                        
                        Utils.api(approve_type + "/" + report_id, {
                            env: 'yuqi',
                            data: {
                                rid: id
                            }
                        }).done(function (rs) {
                            
                            if (rs['status'] <= 0) {
                                return;
                            }

                            var data = rs['data'];

                            var can_complete = data.complete;
                            var has_suggestion_memebers = data.suggestion.length;
                            var canSelect = data['fixed'];

                            // 财务阶段审批规则较短 status=2
                            if($scope.report.status == '2') {
                                if(can_complete) {
                                    doPass({}, 'financial').done(function (rs) {
                                        if(rs['status']<=0) {
                                            return show_notify(rs['data']['msg']);
                                        }
                                        show_notify('已通过');
                                        window.location = '/bills/finance_flow';
                                    });
                                } else {
                                    var suggestionMembers = _.filter($scope.members, function(item) {
                                        var list = data['suggestion'].join(',').split(',');
                                        if(_.contains(list, item.id)) {
                                            return true;
                                        }
                                        return false;
                                    });

                                    var tmpl = [
                                        '<div class="suggestion-box">',
                                        '   <div>你的报销单将提交给财务</div>',
                                        '   <% for(var i =0;i<list.length;i++) {',
                                        '           var item = list[i]; ',
                                        '   %>',
                                        '      <div class="receiver"><%= item.nickname %> - [<%= item.email %>]</div>',
                                        '   <%}%>',
                                        '</div>'
                                    ].join('');

                                    var dialog = new CloudDialog({
                                        quickClose: true,
                                        autoDestroy: false,
                                        content: _.template(tmpl)({list: suggestionMembers}),
                                        okValue: '按公司规定发送报销单',
                                        ok: function() {
                                            doPass({}, 'financial').done(function (rs) {
                                                if(rs['status']<=0) {
                                                    return show_notify(rs['data']['msg']);
                                                }
                                                show_notify('已通过');
                                            });
                                        },
                                        cancelValue: '按我的选择发送报销单',
                                        cancel: function () {
                                            var dialog = dialogMemberSingleton.getInstance();
                                            dialog.show();
                                        }
                                    });
                                    dialog.showModal();
                                }
                                return
                            }

                            if(can_complete) { //1
                                if(canSelect) {
                                    var suggestionMembers = _.filter($scope.members, function(item) {
                                        var list = data['financial_suggestion'].join(',').split(',');
                                        if(_.contains(list, item.id)) {
                                            return true;
                                        }
                                        return false;
                                    });

                                    var tmpl = [
                                        '<div class="suggestion-box">',
                                        '   <div>你的报销单将提交给</div>',
                                        '   <% for(var i =0;i<list.length;i++) {',
                                        '           var item = list[i]; ',
                                        '   %>',
                                        '      <div class="receiver"><%= item.nickname %> - [<%= item.email %>]</div>',
                                        '   <%}%>',
                                        '</div>'
                                    ].join('');

                                    var dialog = new CloudDialog({
                                        quickClose: true,
                                        autoDestroy: false,
                                        content: _.template(tmpl)({list: suggestionMembers}),
                                        okValue: '按公司规定发送报销单',
                                        ok: function() {
                                            doPass({
                                                comment: '',
                                                status: 2,
                                                manager_id: list.join(',')
                                            }).done(function (rs) {
                                                if(rs['status']<=0) {
                                                    return show_notify(rs['data']['msg']);
                                                }
                                                show_notify('已通过');
                                            });
                                        },
                                        cancelValue: '按我的选择发送报销单',
                                        cancel: function () {
                                            var dialog = dialogMemberSingleton.getInstance();
                                            dialog.show();
                                        }
                                    });
                                    dialog.showModal();
                                    return;
                                }
                                return doPass({
                                    comment: '',
                                    status: 2,
                                    manager_id: data.suggestion.join(',')
                                }).done(function (rs) {
                                    if(rs['status']<=0) {
                                        return show_notify(rs['data']['msg']);
                                    }
                                    show_notify('已通过');
                                });
                            }

                            if(!can_complete && !has_suggestion_memebers) { //4
                                var dialog = dialogMemberSingleton.getInstance();
                                dialog.showModal();
                                return
                            }

                            if(!can_complete && has_suggestion_memebers && !canSelect) { //2
                                var suggestionMembers = _.filter($scope.members, function(item) {
                                    var list = data['suggestion'].join(',').split(',');
                                    if(_.contains(list, item.id)) {
                                        return true;
                                    }
                                    return false;
                                });

                                var tmpl = [
                                    '<div class="suggestion-box">',
                                    '   <div>你的报销单将提交给</div>',
                                    '   <% for(var i =0;i<list.length;i++) {',
                                    '           var item = list[i]; ',
                                    '   %>',
                                    '      <div class="receiver"><%= item.nickname %> - [<%= item.email %>]</div>',
                                    '   <%}%>',
                                    '</div>'
                                ].join('');

                                var dialog = new CloudDialog({
                                    quickClose: true,
                                    autoDestroy: false,
                                    content: _.template(tmpl)({list: suggestionMembers}),
                                    ok: function() {
                                        doPass({
                                            comment: '',
                                            status: 2,
                                            manager_id: list.join(',')
                                        }).done(function (rs) {
                                            if(rs['status']<=0) {
                                                return show_notify(rs['data']['msg']);
                                            }
                                            show_notify('已通过');
                                        });
                                    },
                                    cancel: function () {
                                        var dialog = dialogMemberSingleton.getInstance();
                                        dialog.show();
                                    }
                                });
                                dialog.showModal();
                                return;
                            }
                            if(!can_complete && has_suggestion_memebers && canSelect) { //3
                                var dialog = dialogMemberSingleton.getInstance();
                                
                                (function selectSuggestionMembes(argument) {
                                    var suggestionMembers = _.filter($scope.members, function(item) {

                                        // 当审批人在上方建议中，下方就无需出现了，设置标记隐藏之

                                        delete item['_in_sug_'];

                                        if(_.contains(data['suggestion'], item.id+'')) {
                                            item['_in_sug_'] = true;
                                            return true;
                                        }

                                        return false;

                                    });

                                    _.each(suggestionMembers, function(item) {
                                        item.isSelected = true;
                                    });

                                    $scope.suggestionMembers = suggestionMembers;

                                })();

                                dialog.showModal();
                                return $scope.$apply();
                            }
                        })
                        return
                    };
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型