(function() {

    function getFlowWithQuery(query) {
        return Utils.api('giro_transaction', {
            env: 'miaiwu',
            data: query
        });
    };

    return {
        init: function() {
            angular.module('reimApp', []).controller('PayFlowController', ["$scope",
                function($scope) {
                    getFlowWithQuery({}).done(function (rs) {
                        if (rs['status'] <= 0) {
                            return show_notify(rs['data']['msg']);
                        }
                        $scope.payList = rs['data']['items'];
                        $scope.$apply();
                    })
                }
            ]);
        }
    }
}()).init();