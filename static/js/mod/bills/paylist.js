(function () {
	var rids = Utils.queryString(locatin.search)['rids'].split(',');


	function getReportArray(rids) {
		
	};

	return {
		init: function () {
			angular.module('reimApp', []).controller('PayListController', ["$scope", function ($scope) {
				// body...
				$scope.a = 12;
				$scope.isLoaded = true;
			}]);
		}
	}
}()).init();