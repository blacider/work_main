(function() {
    return {
        initialize: function() {

            var _CONST_INPUT_CODE_ = {
                'NULL': '不能为空',
                'LENGTH_LIMIT': '长度超过限制',
                'EMAIL_ERROR': '邮箱格式不正确',
                'PHONE_ERROR': '手机号需为11位数字',
                'NOT_EQUAL_ONE': '手机号码与邮箱不是同一个人',
                'NUMBERIC_REQUIRED': '只能为数字格式',
                'BANK_CARD_NUMBER_LENGTH': '银行卡号长度为12-100位数字',
                'MODIFIED': '信息已修改'
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

                if(item.id) {
                    if(!/^\d+$/.test(item.id)) {
                        errorMap['id'] = 'NUMBERIC_REQUIRED'
                    }
                }

                if(item.cardno) {
                    if(!/^\d+$/.test(item.cardno)) {
                        errorMap['cardno'] = 'NUMBERIC_REQUIRED';
                    } else {
                        if(item.cardno>100 || item.cardno<12) {
                            errorMap['cardno'] = 'BANK_CARD_NUMBER_LENGTH';
                        }
                    }
                }

                if(_.isEmpty(errorMap)) {
                    return false;
                }

                return errorMap;
            }

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
                var a = _.find(members, {
                    phone: item.phone
                });
                var b = _.find(members, {
                    email: item.email
                });

                return a||b;
            };

            // 查看哪些字段被更新了
            function getItemModifiedFields(item, original) {
                var rs = [];
                for(var pro in item) {
                    if(item[pro] && original[pro] !== item[pro] ) {
                        rs.push(pro);
                    }
                }
                return rs;
            };

            function getItemRedOrBlueMap(item, members) {
                var originalItem = getOriginalItem(item, members);
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

            // 将数据分成三组
            function groupFileArray(arr, members) {

                var rs = {
                    error: [],
                    appender: [],
                    modifier: []
                };

                for(var i=0;i<arr.length;i++) {
                    var item = arr[i];
                    var notIn = isNotFoundItem(item, members);
                    console.log(item.email, item.phone, notIn);
                    if(notIn) {
                        var v = getItemValidator(item);
                        if(v) {
                            // 如果只是错的就是只是邮箱或者手机号中的一个
                            if(_.size(v)==1 && (v['phone'] || v['email'])) {
                                rs.appender.push(item);
                            } else {
                                rs.error.push(item);
                            }

                        } else {
                            rs.appender.push(item);
                        }
                        item._v_ = getItemValidator(item);
                    } else {
                        item._v_ = getItemRedOrBlueMap(item, members)
                        rs.modifier.push(item);
                    }
                }

                return rs;
            };

            // events hanlder
            function onEditCell(callback) {
                $('table').on('click', 'td.field-error, td.field-modified', function (e) {

                    var $txt = $(this).find('.field-value');

                    var txt = $txt.text();

                    var d = dialog({
                        content: '<div class="field-input"><input type="text" value="'+txt+'" /></div>',
                        // quickClose: false,// 点击空白处快速关闭
                        padding: "20px 0 10px 0",
                        cancelValue: '取消',
                        cancel: function (e) {
                            
                        },
                        okValue: '修改',
                        ok: function () {
                            callback.call(this);
                            return true;
                        },
                        onshow: function () {
                        // auto close
                            var _this = this;
                            $(this.node).prev().on('click', function (e) {
                                _this.close();
                            });
                        }
                    });

                    d.showModal(e.currentTarget);
                    
                });
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
                    // method here

                    $scope.errorArray = rs.error;
                    $scope.appenderArray = rs.appender;
                    $scope.modifierArray = rs.modifier;

                    // bind events executed
                    onEditCell(function () {
                        // on ok
                        var str = $(this.node).find('input').val();
                        str = $.trim(str);
                        $(this.follow).find('.field-value').text(str);

                        var hashKey = $(this.follow).parent().data('id');
                        var fieldName = $(this.follow).data('field');
                        var query = {};
                        var one = _.find([].concat($scope.errorArray, $scope.appenderArray, $scope.modifierArray), {
                            $$hashKey: hashKey
                        });

                        if(one) {
                            one[fieldName] = str;

                            if($(this.follow).parents('.cbx-table-container').hasClass('table-modified')) {
                                one._v_ = getItemRedOrBlueMap(one, members);
                            } else {
                                one._v_ = getItemValidator(one);
                            }

                            setTimeout(function () {
                               $scope.$apply();
                            }, 1000/16);
                        }

                    });
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型