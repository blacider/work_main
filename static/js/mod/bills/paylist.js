(function () {
	var rids = Utils.queryString(location.search)['rids'].split(',');

	function getReportArray(rids) {
		return Utils.api('/report_finance_flow/list/1', {
			env: 'miaiwu',
			data: {
				ids: rids.join('|')
			}
		});
	};

	function getCompanyProflie() {
		return Utils.api('/report_finance_flow/list/1', {
			env: 'miaiwu',
			data: {
				ids: rids.join('|')
			}
		});
	};

	function getCode(data) {
		// data: {
		// 	email: ''
		// 	phone:''
		// }
		return Utils.api('/vcode/wxpay_auth', {
			method: 'post',
			env: 'miaiwu',
			data: data
		}).done(function (rs) {
			if(rs['status']<=0) {
				return
			}
		});
	};

	return {
		init: function () {
			angular.module('reimApp', []).controller('PayListController', ["$scope", function ($scope) {

				// $scope.isLoaded = true;

				getReportArray(rids).done(function (rs) {

					if (rs['status'] < 0) {
					    return show_notify('找不到模版');
					}

					$scope.reportArray = rs['data']['data'];

					$scope.isLoaded = true;

					$scope.$apply();

				});

				// $scope handler here
				$scope.onRemoveItem = function (item) {
					var index = _.findIndex($scope.reportArray, {
						id: item.id
					});

					if(index>=0) {
						$scope.reportArray.splice(index, 1);
					}
				};

			}]);
		}
	}
}()).init();