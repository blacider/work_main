(function() {
    var rids = Utils.queryString(location.search)['rids'].split(',');
    var _COMPANY_PAYHEAD_ = {};
    var _CONST_DELAY_ = 30;
    if (!show_notify) {
        var show_notify = window.top.show_notify;
    }

    function getCompanyPayHeads() {
        // report_id 类型 - string, 描述 - 需处理的报销单ID。
        // company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
        // payway 类型 - string, 描述 - 指定的支付方式。
        // description 类型 - string, 描述 - 支付描述信息。
        return Utils.api('giro_payhead/company_payheads', {
            env: 'miaiwu'
        }).done(function(rs) {
            if (rs['status'] <= 0) {
                return;
            }
            _COMPANY_PAYHEAD_ = rs['data'];
            if (_COMPANY_PAYHEAD_['wechat_pub']['payhead_uid']) {
                $('.btn-pay').show();
            }
        });
    };

    function getReportArray(rids) {
        return Utils.api('/report_finance_flow/list/1', {
            env: 'miaiwu',
            data: {
                ids: rids.join('|')
            }
        });
    };

    function getGroup(id) {
        return Utils.api('/groups/' + id, {
            env: 'miaiwu'
        });
    };

    function getCompanyProflie() {
        return Utils.api('/report_finance_flow/list/1', {
            env: 'miaiwu',
            data: {
                ids: rids.join('|')
            }
        });
    };

    function getCurrentUserProflie(uid) {
        return Utils.api('/users/info/' + uid, {}).done(function(rs) {
            if (rs['status'] < 0) {
                return show_notify('数据出错');
            }
        });
    };

    function getUserPhone() {
        return Utils.api('/giro_transaction/get_security_pay_phone', {
            env: 'miaiwu'
        }).done(function(rs) {
            if (rs['status'] < 0) {
                return show_notify('获取手机号码失败');
            }
        });
    }

    function getPageData() {
        return $.when(getReportArray(rids), getCurrentUserProflie(__UID__), getUserPhone(), getCompanyPayHeads())
    };

    function getCode(data) {
        // data: {
        // 	email: ''
        // 	phone:''
        // }
        return Utils.api('/vcode/pay', {
            method: 'post',
            env: 'miaiwu',
            data: data
        }).done(function(rs) {
            if (rs['status'] <= 0) {
                return
            }
        });
    };

    function doPayItem(data) {
        // report_id 类型 - string, 描述 - 需处理的报销单ID。
        // company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
        // payway 类型 - string, 描述 - 指定的支付方式。
        // description 类型 - string, 描述 - 支付描述信息。
        return Utils.api('giro_transaction/pay_report', {
            method: 'post',
            env: 'miaiwu',
            data: data
        });
    };

    function ticker(count, tick, done) {
        function handler() {
            count--;
            if (count <= 0) {
                return done();
            }
            tick(count);
            setTimeout(function() {
                handler();
            }, 1000);
        };
        handler();
    };

    function doPayOneByOne(index, data, opts) {
        var list = data['list'];
        if (index >= list.length) {
            opts['done'](list, index);
            return;
        }
        var item = list[index];
        var itemData = {
            report_id: item,
            vcode: data.vcode,
            phone: data.phone,
            description: data.desc || '批量进行企业向员工微信钱包支付（串行）',
            company_payhead_id: _COMPANY_PAYHEAD_['wechat_pub']['payhead_uid'],
            payway: 'wechat_pub'
        }
        doPayItem(itemData).done(function(rs) {
            // -82 TAOYUAN_PAYMENT_CONTINUABLE_ERR
            // -83 TAOYUAN_PAYMENT_UNCONTINUABLE_ERR
            if (rs['status'] <= 0) {
                if (rs['code'] == -82) {
                    opts['one'](rs, index, list);
                } else {
                    opts['error'](rs, index, list);
                    return opts['done'](list, index);
                }
            }
            opts['one'](rs, index, list);
            index++;
            doPayOneByOne(index, data, opts);
        });
    };
    return {
        init: function() {
            angular.module('reimApp', []).controller('PayListController', ["$scope",
                function($scope) {
                    // variable here
                    // 支付验证码
                    setTimeout(function() {
                        $scope.vcode = '';
                        $scope.$apply();
                    }, 100)
                    // $scope.isLoaded = true;
                    getPageData().done(function(rs, profile, phone, payHeads) {
                        $scope.isLoaded = true;
                        if (rs['status'] < 0) {
                            return show_notify('找不到模版');
                        }
                        $scope.reportArray = rs['data']['data'];
                        $scope.profile = profile['data'];
                        $scope.phone = phone['data']['phone'];
                        $scope.$apply();
                        // last fetch get group data
                        // getGroup($scope.profile.gid).done(function (rs) {
                        // 	debugger
                        // });
                    });
                    // $scope event handler here
                    $scope.onRemoveItem = function(item) {
                        var index = _.findIndex($scope.reportArray, {
                            id: item.id
                        });
                        if (index >= 0) {
                            $scope.reportArray.splice(index, 1);
                        }
                    };
                    $scope.onSendCode = function() {
                        if ($scope.isWaiting) {
                            return show_notify('验证码正在发送，请耐心等待');
                        }
                        $scope.isWaiting = true;
                        $('.btn-send-code').text('30秒后重发');
                        ticker(_CONST_DELAY_, function(count) {
                            $('.btn-send-code').text(count + ' 秒后重发');
                        }, function() {
                            $('.btn-send-code').text('短信获取口令');
                            $scope.isWaiting = false;
                            $scope.$apply();
                        });
                        getCode({
                            phone: $scope.phone
                        }).done(function(rs) {
                            $scope.$apply();
                        });
                    };
                    $scope.onSubmit = function(vcode, desc) {
                        if (!vcode) {
                            $('.btn-vcode').focus();
                            return show_notify('请输入验证码');
                        }
                        // 获取显示的列表
                        var idArr = [];

                        _.each($scope.reportArray, function(item) {
                            idArr.push(item.id);
                        });

                        var statis_ok = 0, statis_continue = 0, statis_error = 0;
                        var errorMsg = '';
                        doPayOneByOne(0, {
                            list: idArr,
                            vcode: vcode,
                            phone: $scope.phone,
                            desc: desc
                        }, {
                            error: function(rs, index, list) {
                               statis_error++;
                               errorMsg = rs['data']['msg'];
                            },
                            one: function(rs, index, list) {
                                if (rs['status'] <= 0) {
                                	show_notify(rs['data']['msg']);
                                	statis_continue++;
                                } else {
                                	statis_ok++;
                                }
                            },
                            done: function(index, list) {
                            	var type = '';
                            	// 有一条错误，其余全部continue
                            	// 
                            	if(statis_error) {
                            		if(statis_continue) {
                            			type = 'continue_and_error';
                            		} else {
                            			type = 'error';
                            		}
                            	} else {
                            		if(statis_continue) {
                            			if(ok) {
                            				type = 'continue_ok';
                            			} else {
                            				type = 'continue';
                            			}
                            		} else {
                            			type = 'ok';
                            		}
                            	}

                            	var tmpl = [
                            		'<div class="row">',
                            		'	<div>系统错误，<%= statis_continue  %></div>',
                            		'	<div>请稍后重试，或联系<a href="">云报销客服</a></div>',
                            		'</div>',
                            	].join('');

                            	var dialog = new CloudDialog({
                            		content: _.template(tmpl)({
                            			statis_continue: statis_continue,
                            			statis_ok: statis_ok,
                            			errorMsg: errorMsg
                            		}),
                            		cancelValue: '确认',
                            		cancel: function () {
                            			this.close()
                            		},
                            		okValue: '查看转账记录',
                            		ok: function () {
                            			window.location = 'http://www.baidu.com';
                            			this.close();
                            		}
                            	});

                            	dialog.showModel();
                            }
                        })
                    };
                }
            ]);
        }
    }
}()).init();