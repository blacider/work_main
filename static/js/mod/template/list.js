(function() {
    var phonecatApp = angular.module('reimApp', []);
    var _defaultColumnEditConfig_ = {
        "explanation": "",
        "name": "起始地点",
        "required": "0",
        "type": "1",
        "id": "3"
    };
    var _defaultTableEditConfig_ = {
        "name": "新的表格",
        "type": "0",
        "printable": "1",
        "children": [angular.copy(_defaultColumnEditConfig_)],
    };
    var _defaultTemplateConfig_ = {
        "id": "39",
        "name": "差旅报销单" + Date.now(),
        "type": ["2"],
        "config": [{
            "name": "差旅详情",
            "type": "0",
            "printable": "1",
            "children": [{
                "explanation": "",
                "name": "起始地点",
                "required": "0",
                "type": "1",
                "id": "3"
            }, {
                "explanation": "",
                "name": "起始日期",
                "required": "0",
                "type": "1",
                "id": "6"
            }, {
                "explanation": "",
                "name": "事由",
                "required": "0",
                "type": "1",
                "id": "11"
            }],
            "id": "21"
        }, {
            "name": "1",
            "type": "0",
            "printable": "0",
            "children": [{
                "explanation": "",
                "name": "2",
                "required": "0",
                "type": "4",
                "property": {
                    "bank_account_type": "1"
                },
                "id": "16"
            }],
            "id": "22"
        }],
        "disabled": "0"
    }
    return {
        initialize: function() {
            phonecatApp.controller('templateController', ["$http", "$scope",
                function($http, $scope) {
                    // init edit config
                    $scope.templateEditMap = {};

                    $http.get('/company/get_template_list').success(function(rs) {
                        $scope.templateArray = rs['data'];
                    });
                    $scope.onAccordionTemplate = function(item, $index, e) {
                        var $targetEle = angular.element(e.target);
                        var $templateItem = $targetEle.parent().parent().parent();
                        if ($templateItem.hasClass('shrink')) {
                            $templateItem.removeClass('shrink')
                        } else {
                            $templateItem.addClass('shrink')
                        }
                    };
                    $scope.onPreviewTemplate = function  (argument) {
                        // body...
                    };
                    $scope.onDeleteTemplate = function(item, $index) {
                        $http.post('/company/dodelete_report_template/' + item.id).success(function(rs) {
                            // $scope.templateArray = rs['data'];
                            if (rs['status'] <= 0) {
                                return show_notify(rs['msg']);
                            }
                            $scope.templateArray.splice($index, 1);
                        });
                    };
                    $scope.onAddTemplate = function() {
                        var templateData = angular.copy(_defaultTemplateConfig_);
                        $scope.templateArray.push(templateData);

                        Utils.api('/company/docreate_report_template', {
                            method: 'post',
                            data: {
                                template_name: templateData['name']
                            }
                        }).done(function  (rs) {
                            if (rs['status'] <= 0) {
                                $scope.templateArray.pop();
                                return show_notify(rs['msg']);
                            }
                        });
                    };
                    $scope.toggleTableVisible = function  (e) {
                        var $table = $(e.target).parents('.field-table').find('.field-table-content');
                        if($table.hasClass('none')) {
                            $table.removeClass('none');
                        } else {
                            $table.addClass('none')
                        }
                    };
                    $scope.togglePrintSettings = function  (e) {
                        var $target = $(e.target);
                        var $groupContainer = $(e.target).parents('.field-table').find('.group-container');
                        if($groupContainer.hasClass('none')) {
                            $target.addClass('btn-up')
                            $groupContainer.removeClass('none');
                        } else {
                            $groupContainer.addClass('none')
                            $target.removeClass('btn-up')
                        }
                    };

                    $scope.toggleCheckbox = function  (e) {
                        var $target = $(e.target).parent();
                        if($target.hasClass('disabled')) {
                            return
                        }
                        if($target.hasClass('checked')) {
                            $target.removeClass('checked');
                        } else {
                            $target.addClass('checked');
                        }
                    };

                    $scope.onRadioGroupClick = function  (e) {
                        var $target = $(e.currentTarget);
                        $target.addClass('checked').siblings().removeClass('checked');
                    };

                    $scope.editColumnArray = [
                        // {
                        //     "explanation": "",
                        //     "name": "事由",
                        //     "required": "0",
                        //     "type": "1",
                        //     "id": "11"
                        // }
                    ];

                    $scope.onAddColumnForFieldTableConfig = function (data, e, index) {
                        $scope.templateEditMap[data.id][index].children.push(angular.copy(_defaultColumnEditConfig_));
                    };
                    $scope.onAddFieldTable = function (data, e, index) {
                         
                        if(!$scope.templateEditMap[data.id]) {
                            return ($scope.templateEditMap[data.id] = [angular.copy(_defaultTableEditConfig_)]);
                        }
                        debugger
                        $scope.templateEditMap[data.id].push(angular.copy(_defaultTableEditConfig_));
                    };
                    $scope.onRemoveEditColumn = function  (index) {
                        if($scope.editColumnArray.length <=1) {
                            return alert('至少拥有一个字断')
                        }
                        $scope.editColumnArray.splice(index, 1);                        
                    };

                    $scope.getUID = function  (e) {
                        return Utils.uid();
                    }

                }
            ]);
        }
    }
})().initialize();