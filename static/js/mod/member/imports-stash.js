(function() {
    return {
        initialize: function() {

            var _const_input_error_code_ = {
                'NULL': '不能为空',
                'LENGTH_LIMIT': '长度超过限制',
                'EMAIL_ERROR': '邮箱格式不正确',
                'PHONE_ERROR': '手机号需为11位数字',
                'NOT_EQUAL_ONE': '手机号码与邮箱不是同一个人',
                'NUMBERIC_REQUIRED': '只能为数字格式'
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
                    if(original[pro] !== item[pro] ) {
                        rs.push(rs);
                    }
                }
                rs.push(rs);
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
                    if(isNotFoundItem(item, members)) {
                        if(getItemValidator(item)) {
                            rs.error.push(item);
                        } else {
                            rs.appender.push(item);
                        }
                    } else {
                        rs.modifier.push(item);
                    }
                }

                return rs;
            };

            angular.module('reimApp', []).controller('MemberImportsController', ["$scope",
                function($scope) {

                    // init date
                    $scope.isLoaded = true;

                    if(_LOCALE_FILE_MEMBERS_['status']<=0) {
                        return _LOCALE_FILE_MEMBERS_['data']['msg'];
                    }
                    if(_SERVER_MEMBERS_['status']<=0) {
                        return _SERVER_MEMBERS_['data']['msg'];
                    }

                    // events handler here
                    
                    // method here
                    var members = _SERVER_MEMBERS_['data']['gmember'];

                    var rs = groupFileArray(_LOCALE_FILE_MEMBERS_, members);

                    $scope.scanItem = function (item) {
                        var v = getItemValidator(item);
                        var m = isNotFoundItem(item, members);
                        console.log(item.$$hashKey, m, v);
                    };


                    $scope.errorArray = rs.error;
                    $scope.appenderArray = rs.appender;
                    $scope.modifierArray = rs.modifier;

                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型