(function() {
    return {
        initialize: function() {
            angular.module('reimApp', []).controller('MemberImportsController', ["$scope",
                function($scope) {
                    $scope.haha = new Date

                    $scope.isLoaded = true;

                    //variable here
                    $scope.members = _CONST_MEMBERS_;
                }
            ]);
        }
    }
})().initialize();
//创建模板默认类型