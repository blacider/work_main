// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    var _defaultTemplateName_ ='未命名报销单模板';
    return {
        initialize: function() {
            angular.module('reimApp', ['historyMembers', 'exchangeRate']).controller('ReportController', ["$http", "$scope", "$element", "$timeout", "$sce", "historyMembersManagerService", "exchangeRateService",
                function($http, $scope, $element, $timeout, $sce, historyMembersManager, exchangeRate) {
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
                    $scope.exchangeRateMap = exchangeRate.rateMap;

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

                    function getReportFlow(id) {
                        return Utils.api('/reports/get_report_flow_v2/' + id, {}).done(function(rs) {
                            if (rs['status'] < 0) {
                                return show_notify('找不到数据');
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

                    function getReportUserProfile(uid) {
                        return Utils.api('/users/get_user_profile/' + uid, {}).done(function (rs) {
                            if(rs['status']<0) {
                                return show_notify('数据出错');
                            }
                        });
                    };

                    function getMembers() {
                        return Utils.api('/users/get_members', {}).done(function(rs) {
                            var data = rs['data'];
                            $scope.$apply();
                        });
                    };
                    function getPageData(callback) {
                        getReportData(report_id).done(function(rs) {

                            if (rs['status']<=0) {
                                callback.call(null, rs);
                                return show_notify('获取数据失败');
                            }
                           
                            var report_uid = rs['data']['uid'];

                            $scope.report = rs['data'];

                            $.when(getTemplateData(), getReportFlow(report_id), getMembers(), getReportUserProfile(report_uid)).done(function() {
                                callback.apply(null, arguments);
                                // 这种类型不好处理，在这里收集它们——当其改变的数值的时候
                            })
                        });
                    };

                    // 通过报销单
                    function doPass(data, type) {
                        // data = {status, manager_id}
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
                        }).done(function (rs) {
                            if(rs['status']>0) {
                                if(data && data['manager_id']) {
                                    historyMembersManager.append(data.manager_id);
                                }
                            }
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

                        var fieldResult = {
                            id: item.id,
                            value: '',
                            type: itemType
                        };
                        if (!extrasItem) {
                            return fieldResult;
                        }
                        if (itemType == 4) {
                            var bankData = JSON.parse(extrasItem.value);
                            var tempData = bankData;

                            if(!bankData) {
                                bankData = {};
                            }

                            bankData = _.find($scope.banks, {cardno: bankData.cardno}) || {};

                            fieldResult.value = angular.copy(bankData);
                           
                            if(tempData.id==-1) {
                                fieldResult.value = tempData;
                            }

                            return fieldResult; 
                        }
                        if (itemType == 3) {
                            // android and ios 时间为秒
                            var dt = extrasItem.value + '000';
                            dt = dt.substr(0, 13);
                            var date = new Date(parseInt(dt));
                            try {
                                fieldResult.value = fecha.format(date, 'YYYY-MM-DD');
                            } catch(e) {

                            }
                            return fieldResult
                        }

                        fieldResult.value = extrasItem.value;
                        return fieldResult;
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
                    window.scope = $scope;
                    var dialogMemberSingleton = (function() {
                        var instance;

                        function createInstance() {
                            var dialog = new CloudDialog({
                                title: '选择审批人',
                                quickClose: true,
                                buttonAlign: 'right',
                                autoDestroy: false,
                                className: 'theme-grey',
                                ok: function() {
                                    var _this = this;
                                    var receivers = _.where($scope.members, {
                                        isSelected: true
                                    });

                                    var history = _.where($scope.suggestionMembers, {
                                        isSelected: true
                                    });

                                    if(history) {
                                        receivers = [].concat(history, receivers);
                                    }

                                    var receivers_id = _.map(receivers, function(item) {
                                        return item.id;
                                    });

                                    receivers_id = _.unique(receivers_id);

                                    if(this._OK_CONFIG_FN_) {
                                        for(var f in this._OK_CONFIG_FN_) {
                                            var fn = this._OK_CONFIG_FN_[f];
                                            fn(receivers_id);
                                        }
                                        delete this._OK_CONFIG_FN_;
                                        return 
                                    }

                                    // 财务还是业务
                                    if(!this._APPROVE_TYPE_) {
                                        doPass({
                                            status: 2,
                                            manager_id: receivers_id.join(',')
                                        }).done(function (rs) {
                                            if(rs['status']<=0) {
                                                return show_notify(rs['data']['msg']);
                                            }
                                            window.location.href = '/reports/audit_todo';    
                                        });
                                    } else {
                                        doPass({}, 'financial').done(function (rs) {
                                            if(rs['status']<=0) {
                                                return show_notify(rs['data']['msg']);
                                            }
                                            window.location.href = '/bills/finance_flow/'
                                        });
                                    }
                                    delete this._APPROVE_TYPE_;
                                    return;
                                },
                                okIcon: true,
                                cancel: function () {
                                    this.close();
                                },
                                cancelIcon: true,
                                onHide: function () {
                                    $scope.txtSearchText = '';
                                }
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

                    $scope.getJobByUID = function (id) {
                        var one = _.find($scope.originalMembers, {
                            id: id + ''
                        });
                        if(one) {
                            return $scope.getLevelNameById(one.level_id);
                        }
                        return '';
                    };

                    $scope.getLevelNameById = function (id) {
                        var one = _.find($scope.levels, {
                            id: id
                        });
                        if(one) {
                            return one.name;
                        }
                        return '';
                    };

                    $scope.getItemsAmount = function (arr) {
                        var amount = 0;
                        _.each(arr, function(item) {
                            var a = parseFloat(item.amount);
                            var rate = 1;
                            if(item.currency!='cny') {
                                rate = parseFloat(item.rate)/100;
                            }
                            amount += a * rate ;
                        });
                        amount = amount.toFixed(2);
                        return amount;
                    };

                    // main entry
                    getPageData(function(template, flow, members, profile) {
                        $scope.isLoaded = true;

                        $scope._CONST_REFERER_ = document.referrer;

                        // 从编辑页面回来的
                        if(document.referrer.indexOf('edit')>=0) {
                            $scope._CONST_REFERER_ = $.cookie(__UID__+'_url');
                        }

                        if (template['status'] <= 0) {
                            return;
                        }

                        var reportData = $scope.report;
                        var extras = JSON.parse(reportData['extras'] || "[]");

                        var profileData = profile['data'];
                        $scope.banks = profileData['banks'] || [];

                        $scope.template = template['data'];
                        if(!$scope.template.name) {
                            $scope.template.name = _defaultTemplateName_;
                        }

                        var membersData = members['data'];
                        members = membersData['members'];

                        $scope.levels = membersData['levels'];
                        $scope.ranks = membersData['ranks'];

                        //排序
                        members.sort(function (a, b) {
                            var c = a.nickname.localeCompare(b.nickname);
                            if("".toUpperCase) {
                                c = a.nickname.toUpperCase().localeCompare(b.nickname.toUpperCase());
                            }
                            return c;
                        });

                        $scope.members = members;
                        $scope.originalMembers = angular.copy($scope.members);
                        
                        // 寻找标准成员数据
                        var selectedMembers = [];
                        _.each(reportData['receivers']['managers'], function (item) {
                            var one = _.find($scope.members, {
                                id: item.id + ''
                            });
                            if(one) {
                                selectedMembers.push(one);
                            }
                        });

                        $scope.selectedMembers = selectedMembers;

                        var selectedMembersCC = [];
                        _.each(reportData['receivers']['cc'], function(item) {
                            var one = _.find($scope.originalMembers, {
                                id: item.id + ''
                            });
                            if (one) {
                                selectedMembersCC.push(one);
                            }
                        });
                        $scope.selectedMembersCC = selectedMembersCC;

                        $scope.suggestionMembers = historyMembersManager.getArray($scope.originalMembers);
                        
                        $scope.submitter = _.where(members, {
                            id: reportData['uid']
                        })[0];

                        // 删除自己
                        var selfIndex = _.findIndex(members, {id: __UID__});
                        if(selfIndex>=0) {
                            members.splice(selfIndex, 1);
                        }

                        $scope.commentArray = _.map(reportData.comments.data, function(item, index) {
                            var one = _.findWhere($scope.originalMembers, {
                                id: item.uid
                            });
                            item.user = one;
                            return item;
                        });

                        $scope.extrasMap = arrayToMapWithKey('id', extras);
                        $scope.combineConfig = combineTemplateAndReport($scope.template, $scope.report);

                        // 修复站点路由的BUG，查看报销单的列表来源
                        (function () {
                            var referrer = document.referrer;
                            $('.breadcrumb li').eq(1).find('a').attr('href', referrer);
                        })();

                        var flowMap = {};
                        var flowData = flow['data']['data'];
                        var counter = 0;
                        _.each(flowData, function(item, index) {

                            // 有可能是2个或多个人
                            var ids = item.uid.split(',');
                            
                            // 处理职位
                            var user = _.find($scope.originalMembers, {
                                id: ids[0]
                            });
 
                            // 有可能是2个或多个人
                            var job = [];
                            _.each(ids, function (id, index) {
                                var one = _.find($scope.originalMembers, {
                                    id: id
                                });
                                job.push($scope.getJobByUID(one.id));
                            });
                            item.job = job.join('／');
                            item.nickname = item.nickname.split(',').join('／');
                            
                            var type = '';
                            if (_.contains(['-1', '0'], item['ticket_type'])) {
                                type = '业务阶段';
                            } else if (item['ticket_type'] == '1') {
                                type = '财务阶段';
                            }
                            var rowName = counter + type;
                            if(!flowMap[rowName]) {
                                flowMap[rowName] = [];
                            }
                            if(index==0) {
                                flowMap[rowName].push(item);
                                return;
                            }
                            // 当前和前一个属于同一个类别
                            if(_.contains(['-1', '0'], item['ticket_type']) && _.contains(['-1', '0'], flowData[index-1]['ticket_type'])) {
                                flowMap[rowName].push(item);
                            } else {
                                counter++;
                                rowName = counter+type;
                                if(!flowMap[rowName]) {
                                    flowMap[rowName] = [];
                                }
                                flowMap[rowName].push(item);
                            }
                        });

                        $scope.cutFlowName = function (name) {
                            return name.replace(/\d/, '');
                        };

                        $scope.flow = flowMap;

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

                            if(is_myself && _.contains(['0', '3'], status)) {
                                buttons['has_modify'] = true;
                            }

                            if(is_myself && _.contains(['1', '2'], status)!=-1) {
                                buttons['has_drop'] = true;
                            }

                            if(is_myself && status == '7') {
                                buttons['has_affirm'] = true;
                            }
                            //业务
                            if(is_approver && status == '1') {
                                buttons['has_pass'] = true;
                                buttons['has_reject'] = true;
                                buttons['has_modify'] = true;
                            }
                            //财务
                            if(is_approver && status == '2') {
                                buttons['has_pass'] = true;
                                buttons['has_reject'] = true;
                            }
                            return buttons;
                        })();
                        $scope.$apply();
                    });
                    $scope.dateFormat = function(date, formatter) {
                        formatter || (formatter = 'YYYY-MM-DD HH:mm:ss');
                        if (date instanceof Date == false) {
                            date = new Date(parseInt(date * 1000));
                        }
                        return fecha.format(date, formatter);
                    }
                    
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

                            var userProfile = _.findWhere($scope.originalMembers, {
                                id: __UID__
                            });

                            $scope.commentArray.push({
                                user: userProfile,
                                nickname: userProfile['nickname'],
                                apath: userProfile['apath'],
                                comment: comment,
                                lastdt: new Date
                            });
                            $scope.comment_box.txtCommentMessage = '';
                            $scope.$apply();
                        });
                    };

                    $scope.onPreviewConsuptionItem = function (item) {
                        window.location = '/items/show/' + item.id + '/1';
                    };

                    $scope.onSelectMember = function (item, isHistory) {
                        item.isSelected = !item.isSelected;
                    };

                    $scope.searchImmediate = function (keywords) {
                        return function( item ) {

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

                            if(!keywords) {
                                item.info_html = $sce.trustAsHtml(_.template(tmpl)({
                                    type: '',
                                    nickname: item.nickname
                                }));
                                return true;
                            }

                            var reg = new RegExp(keywords, 'i');

                            var proArray = ['nickname', 'phone', 'email'];
                            for(var i in proArray) {
                                var pro = proArray[i];
                                if(!item[pro]) {
                                    item[pro] = '';
                                }
                                var match = item[pro].match(reg);
                                if(match) {
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

                    $scope.onReject = function(id) {
                        var dialog = new CloudDialog({
                            title: '退回理由',
                            quickClose: true,
                            content: '<div style="padding: 77px 50px 113px"><textarea style="min-width: 520px;max-width: 520px;min-height: 200px;max-height: 200px;border-radius: 2px;" placeholder="写下你的退回理由…"></textarea></div>',
                            className: 'theme-grey',
                            ok: function() {
                                var comment = this.$el.find('textarea').val();
                                comment = $.trim(comment);
                                if (!comment) {
                                    return show_notify('理由不能为空');
                                }
                                var _this = this;

                                var url = '/report/' + id;
                                var method = 'put';

                                if($scope.report.status == 2) {
                                    url = '/report_finance_flow/deny/' + id;
                                    method = 'post';
                                }

                                Utils.api(url, {
                                    method: method,
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
                                    if($scope.report.status==2) {
                                        window.location.href = '/bills/finance_flow';
                                    } else {
                                        window.location.href = '/reports/audit_todo';
                                    }
                                });
                            },
                            okIcon: true,
                            cancel: function () {
                                this.close()
                            },
                            cancelIcon: true
                        });
                        dialog.showModal();
                    };

                    $scope.onDrop = function(id) {
                        var dialog = new CloudDialog({
                            quickClose: true,
                            content: '确认要撤回报销单吗？',
                            ok: function() {
                                Utils.api("/revoke/" + report_id, {
                                    env: 'online'
                                }).done(function(rs) {
                                    if (rs['status'] <= 0) {
                                        return show_notify('操作失败');
                                    }
                                    window.location.href = '/reports';
                                });
                            },
                            okIcon: true,
                            cancel: function () {
                                this.close()
                            },
                            cancelIcon: true
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
                                    window.location.href = '/reports';
                                });
                            },
                            okIcon: true,
                            cancel: function () {
                                this.close()
                            },
                            cancelIcon: true
                        });
                        dialog.showModal();
                    };

                    function showSuggestionDialog(sugData, hasSelectAgain, callback) {
                        callback || (callback = function () {});
                        var whom = sugData['canComplete']?'财务': '';

                        var suggestionMembers = [];

                        var arr = sugData['suggestion'].join(',').split(',');

                        for(var i =0;i<arr.length;i++) {
                            var id = arr[i];
                            var one = _.find($scope.originalMembers, {
                                id: id
                            });

                            if(one) {
                                suggestionMembers.push(one);
                            }
                        }
                        var tmpl = [
                            '<div class="suggestion-box">',
                            '   <div>你的报销单将提交给'+whom+':</div>',
                            '   <% for(var i =0;i<list.length;i++) {',
                            '           var item = list[i]; ',
                            '   %>',
                            '      <div class="receiver"><%= item.nickname %> - [<%= item.email %>]</div>',
                            '   <%}%>',
                            '</div>'
                        ].join('');

                        // 预算 fix
                        if(sugData['canComplete'] && suggestionMembers.length == 0 && sugData['prove_ahead'] == 1) {
                            tmpl = '<div class="suggestion-box">确定要通过报销单？</div>';
                        }

                        var dialog = new CloudDialog({
                            quickClose: true,
                            autoDestroy: false,
                            content: _.template(tmpl)({list: suggestionMembers}),
                            ok: function() {
                                var data = {
                                    status: 2,
                                    manager_id: sugData.suggestion.join(',')
                                };
                                if(sugData['without_financial']) {
                                    delete data['manager_id'];
                                }
                                doPass(data).done(function (rs) {
                                    if(rs['status']<=0) {
                                        return show_notify(rs['data']['msg']);
                                    }
                                    callback('ok', rs);
                                    window.location.href = '/reports/audit_todo';
                                });
                            },
                            cancelValue: hasSelectAgain?'选择其他审批人':'取消',
                            cancel: function () {
                                callback('cancel', null);
                                this.close();
                            }
                        });
                        dialog.showModal();
                        return dialog;
                    };

                    $scope.onModify= function () {
                        // body...
                        // 编辑的时候先记住进入当前编辑的referer，这样编辑完成后，返回列表就可以回到；
                        $.cookie(__UID__+'_url', document.referrer, {
                            expires: 30
                        });

                        window.location.href= "/reports/edit/" + $scope.report.id+ '?tid=' + $scope.report.template_id;
                    };

                    $scope.onPass = function(id) {
                        // 0-1:业务阶段, 2:财务阶段
                        var approve_type = '/check_approval_permission';
                        if($scope.report.status == '2') {
                            approve_type = '/report_finance_flow/check_permission'
                        }
                        
                        Utils.api(approve_type + "/" + report_id, {
                            env: 'online',
                            data: {
                                rid: id
                            }
                        }).done(function (rs) {
                            
                            if (rs['status'] <= 0) {
                                return;
                            }

                            var data = rs['data'];

                            var canComplete = data.complete;
                            var has_suggestion_memebers = data.suggestion.length;
                            var fixed = data['fixed'];

                            // 财务阶段审批规则较短 status=2
                            if($scope.report.status == '2') {
                                if(canComplete) {
                                    var dialog = new CloudDialog({
                                        quickClose: true,
                                        autoDestroy: false,
                                        content: '确定要通过报销单？',
                                        ok: function() {
                                            doPass({}, 'financial').done(function (rs) {
                                                if(rs['status']<=0) {
                                                    return show_notify(rs['data']['msg']);
                                                }
                                                window.location.href= '/bills/finance_flow';
                                            });
                                        },
                                        cancel: function () {
                                            this.close();
                                        }
                                    });
                                    dialog.showModal();
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
                                            doPass({}, 'financial').done(function (rs) {
                                                if(rs['status']<=0) {
                                                    return show_notify(rs['data']['msg']);
                                                }
                                                window.location.href= '/bills/finance_flow';
                                            });
                                        },
                                        cancel: function () {
                                            this.close();
                                        }
                                    });
                                    dialog.showModal();
                                }
                                return
                            }
                            //  restart 业务阶段
                            console.log('canComplete=', canComplete, 'has_suggestion_memebers=', has_suggestion_memebers, 'fixed=', fixed);
                            if(!canComplete) {
                                if(!has_suggestion_memebers) {
                                    var dialog = dialogMemberSingleton.getInstance();
                                    dialog.showModal();
                                    dialog._OK_CONFIG_FN_ = {
                                        fn: function (receivers_id) {
                                            dialog.close();
                                            showSuggestionDialog({
                                                suggestion: receivers_id
                                            }, hasSelectAgain=false);
                                        }
                                    };
                                } else {
                                    if(fixed==0) {
                                         showSuggestionDialog(data, hasSelectAgain=true, function (buttonType, rs) {
                                            // 选择其他审批人
                                            if(buttonType=='cancel') {
                                                var dialog = dialogMemberSingleton.getInstance();
                                                dialog.showModal();
                                                dialog._OK_CONFIG_FN_ = {
                                                    fn: function (receivers_id) {
                                                        dialog.close();
                                                        showSuggestionDialog({
                                                            suggestion: receivers_id
                                                        }, hasSelectAgain=false);
                                                    }
                                                };
                                            } else if(buttonType=='ok') {
                                                // 已经默认处理
                                            }
                                         });
                                    } else { //fixed = 1
                                        showSuggestionDialog(data, hasSelectAgain=false);
                                    }
                                }
                            } else { //canComplete = 1
                                if(fixed == 1) {
                                    showSuggestionDialog({
                                        canComplete: canComplete,
                                        suggestion: data['financial_suggestion'],
                                        without_financial: true,
                                        prove_ahead: $scope.report.prove_ahead
                                    }, hasSelectAgain=false);
                                } else {
                                    showSuggestionDialog({
                                        canComplete: canComplete,
                                        suggestion: data['financial_suggestion'],
                                        without_financial: true,
                                        prove_ahead: $scope.report.prove_ahead
                                    }, hasSelectAgain=true, function (buttonType, rs) {
                                        // 选择其他审批人
                                        if(buttonType=='cancel') {
                                            var dialog = dialogMemberSingleton.getInstance();
                                            dialog.showModal();
                                            dialog._OK_CONFIG_FN_ = {
                                                fn: function (receivers_id) {
                                                    dialog.close();
                                                    showSuggestionDialog({
                                                        suggestion: receivers_id
                                                    }, hasSelectAgain=false);
                                                }
                                            };
                                        } else if(buttonType=='ok') {
                                            
                                        }
                                    });
                                }
                            }
                            return
                        })
                        return
                    };
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型