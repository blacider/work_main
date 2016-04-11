// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    return {
        initialize: function() {
            angular.module('reimApp', []).controller('ReportController', ["$http", "$scope", "$element", "$timeout",
                function($http, $scope, $element, $timeout) {
                    var report_id = (function() {
                        var router = new RouteRecognizer();
                        router.add([{
                            path: "/reports/show/:id"
                        }]);
                        var matchers = router.recognize(location.pathname);
                        var id = 0;
                        if (matchers.length > 0) {
                            var match = matchers[0];
                            id = match.params['id'];
                        }
                        return id;
                    })();
                    $scope.extrasMap = {};
                    $scope.selectedMembers = [];
                    $scope.selectedConsumptions = [];
                    $scope.banks = [];
                    $scope.default_bank = null;
                    $scope.template = null;
                    $scope.report_status = 0;
                    $scope.default_avatar = '/static/img/mod/report/default-avatar.png';

                    function getTemplateData() {
                        var query = Utils.queryString(location.search);
                        return Utils.api('/template/get_template/' + query.tid, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到模版');
                            }
                        });
                    };

                    function modifyArrayByAll(arr, all) {
                        for (var i = 0; i < arr.length; i++) {
                            var item = arr[i];
                            var index = _.findLastIndex(all, {
                                id: item.id + ''
                            });
                            if (index > -1) {
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
                        return Utils.api('/reports/detail/' + id, {}).done(function(rs) {
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

                    function getCurrentUserBanks() {
                        return Utils.api('/users/get_current_user_banks', {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('个人银行数据出错');
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
                            $scope.rankMap = arrayToMapWithKey('id', data['rankArray']);
                            $scope.levelMap = arrayToMapWithKey('id', data['levelArray']);
                            $scope.$apply();
                        });
                    };

                    function getPageData(callback) {
                        $.when(getTemplateData(), getReportData(report_id), getCurrentUserBanks(), getReportFlow(report_id), getMembers()).done(function() {
                            callback.apply(null, arguments);
                            // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                        })
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
                        if (!item.id) {
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
                            bankData = findOneInBanks(bankData.cardno, $scope.banks, 'cardno');
                            item.value = angular.copy(bankData);
                        }
                        if (itemType == '3') {
                            var date = new Date(parseInt(extrasItem.value));
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
                                            return show_notify('操作失败');
                                        }
                                        _this.close();
                                        show_notify('已通过');
                                    });
                                },
                                onShow: function() {}
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
                    getPageData(function(template, report, banks, flow, members) {
                        $scope.isLoaded = true;
                        if (report['status'] <= 0 || template['status'] <= 0 || banks['status'] <= 0) {
                            return;
                        }
                        var reportData = report['data'];
                        var extras = JSON.parse(reportData['extras'] || "[]");
                        $scope.report = report['data'];
                        $scope.template = template['data'];
                        $scope.members = members['data']['members'];
                        $scope.selectedMembers = report['data']['receivers']['managers'];
                        $scope.banks = banks.banks;
                        $scope.userProfile = _.findWhere(members.data.members, {
                            id: window.__UID__
                        });
                        // fix me
                        modifyArrayByAll($scope.selectedMembers, members.data.members);
                        // get amount
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
                                var receivers = $scope.receivers['managers'];
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

                            if(is_approver && ['1'].indexOf(status)) {
                                buttons['has_pass'] = true;
                                buttons['has_reject'] = true;
                                buttons['has_modify'] = true;
                            }
                            buttons['has_pass'] = true;
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
                    $scope.formatMember = function(m) {
                        // {{levelMap[m.level_id]['name'] || '未知级别'}}－{{rankMap[m.rank_id]['name'] || '未知职位'}}
                        var rankMap = $scope.rankMap;
                        var rank = rankMap[m.rank_id] || {};
                        // console.log(m.d , rankMap[m.rank_id]['name'])
                        if (m.d && rank['name']) {
                            return m.d + '-' + rankMap[m.rank_id]['name'];
                        } else {
                            var rank = rankMap[m.rank_id] || {};
                            return m.d || rank['name'] || '';
                        }
                    };
                    $scope.onAddConsumptions = function(e) {
                        if (!$scope.consumptions) {
                            return show_notify('正在加载数据......');
                        }
                        var dialog = dialogConsumptionSingleton.getInstance();
                        dialog.showModal();
                    };
                    $scope.onAddCommentToReport = function() {
                        var comment = $scope.txtCommentMessage;
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
                                return show_notify('评论失败')
                            }
                            $scope.commentArray || ($scope.commentArray = []);
                            $scope.commentArray.unshift({
                                user: $scope.userProfile,
                                nickname: $scope.userProfile['nickname'],
                                apath: $scope.userProfile['apath'],
                                comment: comment,
                                lastdt: new Date,
                            });
                            $scope.txtCommentMessage = '';
                            $scope.$apply();
                        });
                    };

                    $scope.onSelectMember = function (item, e) {
                        item.isSelected = !item.isSelected;
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
                                Utils.api('report/' + id, {
                                    method: 'put',
                                    env: 'online',
                                    data: {
                                        status: 3,
                                        comment: this.$el.find('textarea').val(),
                                        manager_id: ''
                                    }
                                }).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify('退回失败');
                                    }
                                    _this.close();
                                    show_notify('已退回');
                                });
                            }
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
                            }
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
                            }
                        });
                        dialog.showModal();
                    };

                    // 首次创建，其次保存
                    $scope.onPass = function(id) {
                        $.when(
                            Utils.api("/users/get_profile_data_with_property", {
                                data: {
                                    property: 'group.config'
                                }
                            }),
                            Utils.api("reports/check_permission", {
                                data: {
                                    rid: id
                                }
                            })
                        ).done(function (config, rs) {
                            
                            var config = JSON.parse(config || "{}");
                            if (rs['status'] <= 0) {
                                return;
                            }
                            var data = rs['data'];
                            if (data.complete == 0) {
                                // 将报销单提交给
                                chose_others_zero_audit(getData);
                            } else {
                                var canSelect = config['close_directly']== '0';
                                if(canSelect) {
                                    // 是否结束报销单
                                    var dialog = dialogMemberSingleton.getInstance();
                                    dialog.showModal();

                                    var suggestionMembers = _.filter($scope.members, function(item) {
                                        return _.contains(data['suggestion'], ~~item.id);
                                    });

                                    _.each(suggestionMembers, function(item) {
                                        item.isSelected = true;
                                    });

                                    $scope.suggestionMembers = suggestionMembers;

                                    $scope.$apply();

                                } else {
                                    // 是否结束
                                    var dialog = new CloudDialog({
                                        title: '是否结束报销单',
                                        quickClose: true,
                                        autoDestroy: false,
                                        content: '按公司规定发送报销单',
                                        okValue: '按公司规定发送报销单',
                                        ok: function() {
 
                                            
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
                                                    return show_notify('操作失败');
                                                }
                                                _this.close();
                                                show_notify('已通过');
                                            });
                                        },
                                        cancel: '按我的选择发送报销单',

                                        onShow: function() {}
                                    }); 
                                }
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