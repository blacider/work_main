// subl static/css/mod/report/add.css static/js/mod/report/add.js application/controllers/Reports.php:17 application/controllers/Reports.php
(function() {
    
    var _fieldCountLimit_ = 6;
    var _radioOptionsCountLimit_ = 100;
    var _templateNameLengthLimit_ = 10;
    var _templateFieldLengthLimit_ = 8;
    var _templateTotalLimit_ = 10;
    var _templateTypes_ = null;
    var _ON_TEMPLATE_ADD_ANIMATION_ = 'animated flash';

    return {
        initialize: function() {
            angular.module('reimApp', ['ng-sortable', 'ng-dropdown']).controller('ReportController', ["$http", "$scope", "$element", "$timeout",
                function($http, $scope, $element, $timeout) { 
                    
                }
            ]);
        }
    }
})().initialize();

//创建模板默认类型