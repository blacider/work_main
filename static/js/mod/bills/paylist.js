(function () {
	var rids = Utils.queryString(location.search)['rids'].split(',');



	// $query = 'ids=' . implode('|', $ids);
	// $url = $this->get_url('report_finance_flow/list/1?' . $query);
	// log_message('debug', $url);

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

	return {
		init: function () {
			angular.module('reimApp', []).controller('PayListController', ["$scope", function ($scope) {
				// body...
				$scope.a = 12;
				// $scope.isLoaded = true;

				getReportArray(rids).done(function (rs) {
					if (rs['status'] < 0) {
					    return show_notify('找不到模版');
					}

					$scope.reportsArray = rs['data'];

				});

			}]);
		}
	}
}()).init();