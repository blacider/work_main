/**
 * @author alex <jie.zhang@yunbaoxiao.com>
 * @licence MIT
 */
(function (factory) {
	'use strict';

	if (typeof define === 'function' && define.amd) {
		define(['angular', './Dropdown'], factory);
	} else if (typeof require === 'function' && typeof exports === 'object' && typeof module === 'object') {
		require('angular');
		factory(angular, require('./Dropdown'));
		module.exports = 'ng-Dropdown';
	} else {
		factory(angular);
	}
})(function (angular) {
	'use strict';

	/**
	 * @typedef   {Object}        ngSortEvent
	 * @property  {*}             model      List item
	 * @property  {Object|Array}  models     List of items
	 * @property  {number}        oldIndex   before sort
	 * @property  {number}        newIndex   after sort
	 */
	//define a module, with no dependent modules
	angular.module('ng-dropdown', [])
		.constant('ngDropdownVersion', '1.0.0') // const var 
		.constant('ngDropdownDefaultOptions', {
			onChange: function (oldValue, newValue, item) {
			},
			onSelect: function (oldValue, newValue, item) {
			},
			itemFormat: function (item) {
				return item;
			},
			onInitValue: function (value) {
				
			}
		}) // const var 
		.directive('ngDropdown', ['$parse', 'ngDropdownDefaultOptions', function ($parse, ngDropdownDefaultOptions) {

			// Export

			var findItemByKey = function(item, ls) {
				for(var i=0;i<ls.length;i++) {
					var one = ls[i];
					if(angular.equals(item, one)) {
						return i;
					}
				}
				return -1;
			};

			return {
				restrict: 'EA',
				scope: { ngDropdown: "=?", 'selectedItem': '=?', 'data': '=?', 'defaultItem': '=?', 'paramExtra': '=?'},
				replace: true,
				transclude: true,
				template: '<div ng-transclude></div>',
				link: function ($scope, element, attrs) {
					var options = angular.extend({}, ngDropdownDefaultOptions, $scope.ngDropdown);
					// 有选中的，就用选中的项目展示（此项目必须在下拉列表中）
					// 无选中的或者没有传🈯️，就用默认展示
					var selectedItem = angular.copy($scope.selectedItem);
					var defaultItem = angular.copy($scope.defaultItem);
					var index = findItemByKey(selectedItem, $scope.data);
					var item = null;
					if(index!=-1) {
						item = $scope.data[index];
					}
					item = item || defaultItem;
					// init
					if(item) {
						item = options['itemFormat'](item);
						$(element).find('.text').removeClass('font-placeholder');
						$(element).find('.text').text(item['text']);

						options['onInitValue'](item, element);
						//fix me
						setTimeout(function () {
							$(element).find('.option-list .item').eq(index).addClass('active');
						}, 1000);
					}
					
					var oldValue = item && item['value'];

					$(element).on('click', '.item', function(e) {

						$(element).find('.text').removeClass('font-placeholder');

						var $item = $(e.toElement);
						var text = $item.text();
						var newValue = $item.data('value');
						$(element).find('.text').text(text);
						$(element).find('.option-list').addClass('none');
						$(element).find('.text').removeClass('focus');

						if(oldValue != newValue) {
							options['onChange'](oldValue, newValue, $item[0], $scope.paramExtra, element);
						}
						options['onSelect'](oldValue, newValue, $item[0], element);

						$item.addClass('active').siblings().removeClass('active');

						oldValue = newValue;

						e.stopPropagation();
					});
					
					$(document.body).on('click', function(e) {
						setTimeout(function() {
							$(element).find('.option-list').addClass('none');
							$(element).find('.text').removeClass('focus');
						}, 60);
					});
					$(element).on('click', '.text, .icon', function(e) {
						// fix bug
						$('.option-list').prev().removeClass('focus');
						$('.option-list').addClass('none');
						$(element).find('.option-list').removeClass('none');
						$(e.currentTarget).addClass('focus');
						e.stopPropagation()
					});
				}
			};
		}]);
});
