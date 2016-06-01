(function() {
    return {
        initialize: function() {

            var _CONST_INPUT_CODE_ = {
                'NULL': '内容不能为空',
                'LENGTH_LIMIT': '长度超过限制',
                'EMAIL_ERROR': '邮箱格式不正确',
                'PHONE_ERROR': '手机号需为11位数字',
                'NOT_EQUAL_ONE': '手机号码与邮箱不可以不是同一个人的信息',
                'NUMBERIC_REQUIRED': '只能为数字格式',
                'BANK_CARD_NUMBER_LENGTH': '银行卡号长度必须为12-100位数字',
                'MODIFIED': '信息已修改',
                'EMAIL_OR_PHONE_REQUIRED': '必须是邮箱或者手机号',
            };

            function isPhone(str) {
                return /^1\d{10}$/.test(str);
            };

            function isEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            };

            function isNumberic(str) {
                return /^\d+$/.test(str);
            };

            // 全面过滤出来手机，邮箱，昵称为空的项目，如果不为空，还需要过滤非法
            function getItemValidator(item) {
                var errorMap = {};

                if(item.id) {
                    if(!/^\d+$/.test(item.id)) {
                        errorMap['id'] = 'NUMBERIC_REQUIRED'
                    }
                }

                if(!item.nickname) {
                    errorMap['nickname'] = "NULL";
                } else {
                    if(item.nickname.length>50) {
                        errorMap['nickname'] = "LENGTH_LIMIT";
                    }
                }

                if(!item.phone) {
                    errorMap['phone'] = "NULL";
                } else {
                    if(!isPhone(item.phone)) {
                        errorMap['phone'] = "PHONE_ERROR";
                    }
                }

                if(!item.email) {
                    errorMap['email'] = "NULL";
                } else {
                    if(!isEmail(item.email)) {
                        errorMap['email'] = "EMAIL_ERROR";
                    }
                }

                // 如果邮箱手机号2个，有一个填写了另一个为空是OK的
                if(!errorMap['email'] && errorMap['phone']== 'NULL') {
                    delete errorMap['phone']== 'NULL';
                } 
                if(!errorMap['phone'] && errorMap['email'] == "NULL") {
                    delete errorMap['email']== 'NULL';
                }

                if(item.cardno) {
                    if(!/^\d+$/.test(item.cardno)) {
                        errorMap['cardno'] = 'NUMBERIC_REQUIRED';
                    } else {
                        if(item.cardno.length>100 || item.cardno.length<12) {
                            errorMap['cardno'] = 'BANK_CARD_NUMBER_LENGTH';
                        }
                    }
                }

                if(item.manager_id) {
                    if(!isEmail(item.manager_id) && !isPhone(item.manager_id)) {
                        errorMap['manager_id'] = 'EMAIL_OR_PHONE_REQUIRED';
                    }
                }

                if(_.isEmpty(errorMap)) {
                    return false;
                }

                console.log(item, errorMap);

                return errorMap;
            };

            function isNotAllAsValue(obj, value) {
                for(var pro in obj) {
                    if(obj[pro] !== value) {
                        return true;
                    }
                }
                return false;
            };

            // 未与现有匹配
            function isNotFoundItem(item, members) {
                var a = null;
                if(item.phone) {
                    a = _.find(members, {
                        phone: item.phone
                    });
                }

                var b = null;
                if(item.email) {
                    b = _.find(members, {
                        email: item.email
                    });
                }

                // 判断ab 是否是同一个人
                if(a && b) {
                    if(a.id != b.id) {
                        return true
                    }
                }

                var one = a||b;

                if(!one) {
                    return true;
                }

                return false;
            };

            function getOriginalItem(item, members) {
                var a = null;
                if(item.phone) {
                    a = _.find(members, {
                        phone: item.phone
                    });
                }

                var b = null;
                if(item.email) {
                    b = _.find(members, {
                        email: item.email
                    });
                }

                return a||b;
            };

            function isEqualSet(a, b) {
                if(a.length != b.length) {
                    return false;
                }
                for(var i=0;i<a.length;i++) {
                    var ele = a[i];
                    if(b.indexOf(ele)==-1) {
                        return false
                    }
                }
                return true;
            }

            // 查看哪些字段被更新了
            function getItemModifiedFields(item, original) {
                var rs = [];
                for(var pro in item) {
                    if(item[pro] && original[pro] !== item[pro] ) {
                        rs.push(pro);
                    }
                }
                // console.log(rs, item, original)
                return rs;
            };

            function getItemRedOrBlueMap(item, originalItem) {
                
                var fields = getItemModifiedFields(item, originalItem);
                var errorValidator = getItemValidator(item);
                var m = {};
                // 错误优先，再看是否改动
                for(k in errorValidator) {
                    if(typeof errorValidator[k] == 'object') {
                        continue;
                    }
                    m[k] = errorValidator[k];
                    fields = _.without(fields, k);
                }

                for(var i=0;i<fields.length;i++) {
                    var pro = fields[i];
                    m[pro] = 'MODIFIED';
                }
                return m;
            };

            function syncItemFieldValue(item) {
                var one = null;
                one = _.find(_SERVER_RANKS_, {
                    id: item.rank_id
                });
                if(one) {
                    item.rank = one.name
                }

                one = _.find(_SERVER_LEVELS_, {
                    id: item.level_id
                });
                if(one) {
                    item.level = one.name
                }

                var members = _SERVER_MEMBERS_.data.gmember;
                one = _.find(members, {
                    id: item.manager_id
                });

                if(one) {
                    item.manager_id = one.name
                }

                item.gids = item.d;
                item.bank = item.bankname;

                return item;
            }

            function isItemEmpty(item) {
                for(var pro in item) {
                    if(item[pro]) {
                        return false
                    }
                }
                return true;
            }

            // 将数据分成三组
            function groupFileArray(arr, members) {

                var rs = {
                    error: [],
                    appender: [],
                    modifier: []
                };

                for(var i=0;i<arr.length;i++) {
                    var item = arr[i];

                    // 如果是空行跳过
                    if(isItemEmpty(item)) {
                        continue;
                    }

                    var notIn = isNotFoundItem(item, members);
                    // console.log(item.email, item.phone, notIn);
                    if(notIn) {
                        var v = getItemValidator(item);
                        
                        if(v) {
                            rs.error.push(item);
                        } else {
                            item._status_text_ = '待确认';
                            item_status_ = 1;
                            rs.appender.push(item);
                        }

                        item._v_ = v;

                        if(v) {
                            item._status_text_ = '无法导入'
                        } else {
                            item._status_ = 1;
                            item._status_text_ = '待确认';
                        }

                    } else {
                        var originalItem = getOriginalItem(item, members);

                        originalItem = syncItemFieldValue(originalItem);

                        var v = getItemRedOrBlueMap(item, originalItem);
                        item._v_ = v;
                        rs.modifier.push(item);
                        if(isNotAllAsValue(v, 'MODIFIED')) {
                            item._status_text_ = '无法导入';
                        } else {
                            item._status_ = 1;
                            item._status_text_ = '待确认';
                        }
                    }
                }
                return rs;
            };

            angular.module('reimApp', []).controller('MemberImportsController', ["$scope",
                function($scope) {

                    // init data
                    $scope.isLoaded = true;

                    if(_LOCALE_FILE_MEMBERS_['status']<=0) {
                        return _LOCALE_FILE_MEMBERS_['data']['msg'];
                    }
                    if(_SERVER_MEMBERS_['status']<=0) {
                        return _SERVER_MEMBERS_['data']['msg'];
                    }
                    var members = $scope.members = _SERVER_MEMBERS_['data']['gmember'];

                    var rs = groupFileArray(_LOCALE_FILE_MEMBERS_, members);
                    // mount variable here
                    $scope._CONST_INPUT_CODE_ = _CONST_INPUT_CODE_;
                    // events handler here
                    $scope.getItemValidator = getItemValidator;                    
                    $scope.getItemRedOrBlueMap = getItemRedOrBlueMap;

                    $scope.onSubmit = function (isSendEmail, e) {

                        if($scope.isSubmitDone) {
                            return window.location = '/members/index';
                        }

                        isSendEmail = 1 - ~~isSendEmail;
                        if(!$scope.isLoaded) {
                            return
                        }

                        $scope.isLoaded = false;

                        var data = [];
                        _.each([].concat($scope.errorArray, $scope.modifierArray), function (item) {
                            var validator = getItemValidator(item);
                            if(validator) {
                                item._status_text_ = '导入失败' ;
                            } else {
                                item._status_text_ = '待确认';
                                var one = angular.copy(item);
                                delete one._v_;
                                delete one._status_text_;
                                delete one.$$hashKey;
                                // api key
                                item['uuid'] = one['uuid'] = Utils.uid();

                                data.push(one);
                            }
                        });

                        // add new members directly
                        _.each($scope.appenderArray, function (item) {
                            item['uuid'] = Utils.uid();
                            data.push(item);
                            delete item._v_;
                            delete item._status_text_;
                            delete item.$$hashKey;
                        });

                        var members = angular.copy(data);

                        Utils.api('load', {
                            method: 'post',
                            env: 'yuqi',
                            data: {
                                quiet: isSendEmail,
                                members: JSON.stringify(members)
                            }
                        }).done(function (rs) {
                            $scope.isLoaded = true;
                            if(rs['status']<=0) {
                                $scope.$apply();
                                return show_notify(rs.data.msg);
                            }

                            $scope.isSubmitDone = true;

                            var data = rs['data'];
                            for(var key in data) {
                                var one = _.find([].concat($scope.errorArray, $scope.appenderArray, $scope.modifierArray), {
                                    uuid: key
                                });

                                if(one) {
                                    var importData = data[key];
                                    var status = importData['status'];
                                    
                                    if(status>0 && status<4) {
                                        one['_status_text_'] = '导入成功';
                                        one['_status_'] = 1;
                                    } else {
                                        delete one['_status_'];
                                        one['_status_tip_'] = importData['status_text'];
                                        one['_status_text_'] = '导入失败';
                                    }
                                }
                            }
                            $scope.$apply();
                        });

                    };                 
                    // method here
                    $scope.errorArray = rs.error;
                    $scope.appenderArray = rs.appender;
                    $scope.modifierArray = rs.modifier;

                    // bind events executed
                    (function () {
                        
                        $('table').on('mouseenter', '.field-tip', function (e) {
                            var offset = $(this).offset();

                            var $div = $('<div class="ui-bubble-tip down">').text($(this).data('title'));

                            $div.appendTo(document.body);

                            // 先看左右
                            if(offset['left'] + $div.outerWidth() + 30 > $(window).width()) {
                                offset['left'] = offset['left'] - $div.outerWidth() - 12;
                                offset['top'] = offset['top'] - $div.outerHeight()/2 + 10;
                                $div.addClass('right');
                            // 上下
                            } else {
                                offset['margin-left'] = -$div.width()/2 - 3;
                                if(offset['top'] - $(window).scrollTop() - $div.outerHeight() < 0) {
                                    offset['top'] = offset['top'] + 24;
                                    $div.removeClass('down').addClass('up');
                                } else {
                                    offset['top'] = offset['top'] - $div.outerHeight() - 10;
                                }
                            }

                            $div.css(offset);

                            e.stopPropagation();

                        }).on('mouseleave mouseout', '.field-tip', function () {
                            $('.ui-bubble-tip').remove();
                        });
 
                        $('table').on('click', 'td.field-error', function (e) {

                            var hashKey = $(this).parent().data('id');

                            var one = _.find([].concat($scope.errorArray, $scope.appenderArray, $scope.modifierArray), {
                                $$hashKey: hashKey
                            });

                            var fieldName = $(this).data('field');

                            var str = '';
                            if(one) {
                                str = one[fieldName];
                            }

                            var d = dialog({
                                content: '<div class="field-input"><input onfocus="this.value = this.value;" type="text" value="'+str+'" /></div>',
                                // quickClose: false,// 点击空白处快速关闭
                                padding: "20px 0 10px 0",
                                cancelValue: '取消',
                                cancel: function (e) {
                                    
                                },
                                okValue: '修改',
                                ok: function () {
                                    var txt = $(this.node).find('input').val();
                                    txt = $.trim(txt);
                                    one[fieldName] = txt;

                                    if(one) {
                                        var originalItem = getOriginalItem(one, members);
                                        // 新增更新
                                        if(originalItem) {
                                            originalItem = syncItemFieldValue(originalItem);
                                            var v = getItemRedOrBlueMap(one, originalItem);
                                            one._v_ = v;

                                            if(isNotAllAsValue(v, 'MODIFIED')) {
                                                one._status_text_ = '无法导入';
                                            } else {
                                                one._status_ = 1;
                                                one._status_text_ = '待确认';
                                            }

                                        // 错误更新
                                        } else {
                                            one._v_ = getItemValidator(one);
                                            one._status_text_ = '无法导入' ;
                                            delete one._status_;
                                        }

                                        setTimeout(function () {
                                           $scope.$apply();
                                        }, 1000/16);
                                    }
                                    
                                    return true;
                                },
                                onshow: function () {
                                // auto close
                                    var _this = this;

                                    setTimeout(function () {
                                        $(_this.node).find('input')[0].focus(true);
                                    }, 1000/16);

                                    $(this.node).prev().on('click', function (e) {
                                        _this.close();
                                    });

                                    $(this.node).on('keyup', 'input', function (e) {
                                        if(e.keyCode==13) {
                                            $(_this.node).find('button:last').click();
                                        }
                                    });
                                }
                            });

                            d.showModal(e.currentTarget);
                            
                        });
                    })();
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型