(function() {
    return {
        initialize: function() {

            var _const_input_error_code_ = {
                'NULL': '不能为空',
                'LENGTH_LIMIT': '长度超出限制',
                'EMAIL_ERROR': '邮箱格式不合法',
                'PHONE_ERROR': '手机号码各式不合法'
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
            function isErrorItem(item) {
                var errorMap = {};
                var nickname = item.nickname;
                var phone = item.phone;
                var email = item.email;

                if(!nickname) {
                    errorMap['nickname'] = "NULL";
                }

                if(!phone) {
                    errorMap['phone'] = "NULL";
                } else {
                    if(!isPhone(phone)) {
                        errorMap['phone'] = "PHONE_ERROR";
                    }
                }

                if(!email) {
                    errorMap['email'] = "NULL";
                } else {
                    if(!isEmail(email)) {
                        errorMap['email'] = "EMAIL_ERROR";
                    }
                }

                console.log(errorMap, item.email , item.phone, item.nickname)

                if(_.isEmpty(errorMap)) {
                    return false;
                }
                return errorMap;
            };

            // 查看server数据，中的项目是否存在email phone
            function isModifiedItem(item, members) {
                var a = _.find(members, {
                    phone: item.phone
                });
                var b = _.find(members, {
                    email: item.email
                });
                var one = a||b;
                return one;
            };

            // 查看哪些字段被更新了
            function getItemUpdatedFields(item, original) {
                var rs = [];
                for(var pro in item) {
                    if(original[pro] !== item[pro] ) {
                        rs.push(rs);
                    }
                }
                rs.push(rs);
            };

            function groupFileArray(arr, members) {

                var rs = {
                    error: [],
                    appender: [],
                    modifier: []
                };


                for(var i=0;i<arr.length;i++) {
                    var item = arr[i];
                    if(isErrorItem(item)) {
                        rs.error.push(item);
                    } else if(isModifiedItem(item, members)) {
                        rs.modifier.push(item);
                        getItemUpdatedFields(item);
                    } else {
                        rs.appender.push(item);
                    }
                }

                return rs;
            };

            angular.module('reimApp', []).controller('MemberImportsController', ["$scope",
                function($scope) {

                    $scope.isLoaded = true;

                    if(_LOCALE_FILE_MEMBERS_['status']<=0) {
                        return _LOCALE_FILE_MEMBERS_['data']['msg'];
                    }
                    if(_SERVER_MEMBERS_['status']<=0) {
                        return _SERVER_MEMBERS_['data']['msg'];
                    }

                    var members = _SERVER_MEMBERS_['data']['gmember'];

                    var rs = groupFileArray(_LOCALE_FILE_MEMBERS_, members);

                    $scope.errorArray = rs.error;
                    $scope.appenderArray = rs.appender;
                    $scope.modifierArray = rs.modifier;
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型