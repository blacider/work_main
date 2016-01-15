(function() {
    var phonecatApp = angular.module('reimApp', []);
    return {
        initialize: function() {
        	phonecatApp.controller('templateController', ["$http", "$scope", function($http, $scope) {
        	    $http.get('/company/get_template_list').success(function(data) {
        	        $scope.template = data;
        	    });
        	}]);
        }
    }
})().initialize();