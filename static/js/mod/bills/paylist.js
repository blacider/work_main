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
            if (_COMPANY_PAYHEAD_['wechat_pub']['payhead_id']) {
                $('.btn-pay').show();
            }
        });
    };

    function openMeiQia() {
        window.top.$('#MEIQIA-PANEL-HOLDER-MASK')[0].click();
    };

    function getReportArray(rids) {
        return Utils.api('/reports', {
            method: 'post',
            env: 'miaiwu',
            data: {
                ids: rids.join(',')
            }
        });
    };

    function getGroup(id) {
        return Utils.api('/groups/' + id, {
            env: 'miaiwu'
        });
    };

    function getCurrentUserProflie(uid) {
        return Utils.api('/users/get_user_profile/' + uid, {}).done(function(rs) {
            if (rs['status'] < 0) {
                return show_notify('数据出错');
            }
        });
    };

    function getUserPhone() {
        return Utils.api('/giro_transaction/get_safe_phone', {
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

    function getCode() {
        // data: {
        // 	email: ''
        // 	phone:''
        // }
        return Utils.api('/giro_transaction/fetch_pay_vcode', {
            method: 'post',
            env: 'miaiwu',
        }).done(function(rs) {
            if (rs['status'] <= 0) {
                return
            }
        });
    };

    function getPayToken(vcode) {
        return Utils.api('giro_transaction/payment_auth', {
            method: 'post',
            env: 'miaiwu',
            data: {
                vcode: vcode,
                client_id: window.__CLIEN_ID__,
                client_secret: window.__CLIEN_SECRET__,
            },
        });
    };

    function doPayItem(data, pay_token) {
        // report_id 类型 - string, 描述 - 需处理的报销单ID。
        // company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
        // payway 类型 - string, 描述 - 指定的支付方式。
        // description 类型 - string, 描述 - 支付描述信息。
        return Utils.api('giro_transaction/pay_report', {
            method: 'post',
            env: 'miaiwu',
            data: data,
            token: pay_token,
        });
    };

    function reportMapToArray(m) {
        var rs = [];
        for (var id in m) {
            rs.push(m[id]);
        }
        return rs;
    }

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
        // opts ={done,next,error}
        var list = data['list'];
        if (index >= list.length) {
            opts['done'](index, list);
            return;
        }
        var item = list[index];
        var itemData = {
            report_id: item,
            payway: 'wechat_pub',
            description: data.desc || '批量进行企业向员工微信钱包支付（串行）',
            company_payhead_id: _COMPANY_PAYHEAD_['wechat_pub']['payhead_id'],
        }
        doPayItem(itemData, data.token).done(function(rs) {
            // next返回当前条目处理结果，返回true可以继续下去，否则不可以
            // rs.status =1
            if (opts.next(rs, index, data)) {
                index++;
                doPayOneByOne(index, data, opts);
            } else {
                opts.error(index, data, opts);
            }
        });
    };
    return {
        init: function() {
            angular.module('reimApp', []).controller('PayListController', ["$scope",
                function($scope) {
                    // variable here
                    // $scope.isLoaded = true;
                    // $scope.isSubmitWaiting = true;

                    $scope.moneyFormat = function(str) {
                        var num = parseFloat(str);
                        return num.toFixed(2);
                    };

                    $scope.reportArray = [];

                    $scope.getReportArrayAmount = function(reportArray) {
                        var sum = 0;
                        for (var i = 0; i < reportArray.length; i++) {
                            var r = reportArray[i];
                            sum += parseFloat(r.amount || 0);
                        }
                        return sum.toFixed(2);
                    };

                    $scope.phoneStars = function(phone) {
                        var a = phone.slice(3, 7);
                        return phone.replace(a, '****');
                    };

                    getPageData().done(function(rs, profile, phone, payHeads) {
                        $scope.isLoaded = true;
                        if (rs['status'] < 0) {
                            return show_notify('找不到模版');
                        }
                        $scope.reportArray = reportMapToArray(rs['data']['report']);
                        $scope.profile = profile['data'];
                        $scope.phone = phone['data']['phone'];
                        $scope.$apply();
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
                        getCode().done(function(rs) {
                            $scope.$apply();
                        });
                    };
                    $scope.onSubmit = function(vcode) {
                        if($scope.isSubmitWaiting) {
                            return;
                        }
                        if (!vcode) {
                            $('.btn-vcode').focus();
                            return show_notify('请输入验证码');
                        }

                        $scope.isSubmitWaiting = true;
                        // 获取显示的列表
                        var idArr = [];

                        _.each($scope.reportArray, function(item) {
                            idArr.push(item.id);
                        });

                        var statis_ok = 0,
                            statis_next = 0,
                            statis_error = 0,
                            statis_check = 0;
                        var errorMsg = '';
                        var desc = $('textarea').val();
                        getPayToken(vcode).done(function(rs) {
                            if (rs['status'] <= 0) {
                                $scope.isSubmitWaiting = false;
                                $scope.$apply();
                                return show_notify(rs['data']['msg']);
                            }
                            var pay_token = rs['data']['pay_token'];
                            doPayOneByOne(0, {
                                list: idArr,
                                desc: desc,
                                token: pay_token
                            }, {
                                error: function(rs, index, list) {

                                },
                                next: function(rs, index, list) {
                                    // -110 ~ -119: 普通支付错误
                                    // 其中:
                                    // -110: 一般错误
                                    // -111：用户姓名校验失败

                                    // -120~ -129：严重支付错误
                                    // 其中:
                                    // -120: 一般错误
                                    // -121：余额不足

                                    var code = rs['code'];
                                    if (rs['status'] > 0) {
                                        statis_ok++;
                                        return true;
                                    } else if (code <= -110 && code >= -119) {
                                        show_notify(rs['data']['msg']);
                                        statis_next++;
                                        if (code == -111) {
                                            statis_check++;
                                        }
                                        return true;
                                    } else if (code <= -120 && code >= -129) {
                                        statis_error++;
                                        errorMsg = rs['data']['msg'];
                                        show_notify(errorMsg);
                                        if (code == -121) {
                                            errorMsg = '余额不足';
                                        }
                                        return false;
                                    }
                                },
                                done: function(index, list) {
                                    var str = '';
                                    // ok
                                    if (statis_ok == list.length) {
                                        str = '已成功发起微信转账，预计2小时内到账。<br />请到［流水查询］中查看转账记录。';
                                    } else if (statis_next) {
                                        str = '系统错误，' + statis_next + '笔支付失败。<br />请稍后重试，或联系<a class="btn-open-meiqia" href="javascript:void(0);">云报销客服</a>';
                                        // '<%= statis_check  %>笔支付实名校验失败失败',
                                    } else if (statis_check) {
                                        str = '系统错误，' + statis_check + '笔支付实名校验失败失败。<br />请核实员工，或联系<a class="btn-open-meiqia" href="javascript:void(0);">云报销客服</a>';
                                    } else if (statis_error) {
                                        str = errorMsg + '，' + (list.length - statis_ok) + '笔支付失败。<br />请充值后重试。<a target="_blank" href="http://kf.qq.com/faq/140225MveaUz150107fqeQBj.html?pass_ticket=mczQUvfhw2FPVPPVvwW68vP%2B98vdiRQ5LHDNWWTpkQiSKarE3GQ51K0KPyT888Rs">了解如何充值</a>';
                                    }
                                    // str = '系统错误，' + statis_next + '笔支付失败。<br />请稍后重试，或联系<a class="btn-open-meiqia" href="javascript:void(0);" >云报销客服</a>';
                                    var dialog = new CloudDialog({
                                        content: str,
                                        cancelValue: '确认',
                                        onShow: function(argument) {
                                            this.$el.on('click', '.btn-open-meiqia', function(e) {
                                                openMeiQia();
                                            });
                                        },
                                        onHide: function() {
                                            window.top._PAY_LAYER_.close();
                                            window.top.location.reload();
                                        },
                                        okValue: '查看转账记录',
                                        cancel: function(argument) {
                                            this.close();
                                            window.top._PAY_LAYER_.close();
                                            window.top.location.reload();
                                        },
                                        ok: function() {
                                            this.close();
                                            window.top._PAY_LAYER_.close();
                                            window.top.location = '/bills/payflow';
                                        }
                                    });

                                    dialog.showModal();

                                    $scope.isSubmitWaiting = false;
                                    $scope.$apply();

                                }
                            });
                        });
                    };
                }
            ]);
        }
    }
}()).init();