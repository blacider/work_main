(function() {

    function getFlowWithQuery(query) {
        return Utils.api('giro_transaction', {
            env: 'miaiwu',
            data: query
        });
    };

    function pageMaker(option) {
        var current, ender, i, it, j, k, leftWind, list, next, pathname, prev, query, queryString, ref, ref1, ref2, ref3, rightWind, starter, totalPage, v, wing;
        current = parseInt(option['current']);
        totalPage = parseInt(option['totalPage']);
        wing = option['wing'] || 4;
        pathname = option['pathname'];
        query = option['query'];
        starter = current - wing <= 0 ? 1 : current - wing;
        ender = current + wing < totalPage ? current + wing : totalPage;
        leftWind = [];
        rightWind = [];
        for (it = i = ref = starter, ref1 = current; i <= ref1; it = i += 1) {
            leftWind.push(it);
        }
        for (it = j = ref2 = current + 1, ref3 = ender; j <= ref3; it = j += 1) {
            rightWind.push(it);
        }
        prev = leftWind.length <= 1 ? null : current - 1;
        next = rightWind.length <= 1 ? null : current + 1;

        list = [];
        list.push.apply(list, leftWind);
        list.push.apply(list, rightWind);
        queryString = [];
        for (k in query) {
            v = query[k];
            queryString.push(k + '=' + v);
        }
        return {
            start: 1,
            end: totalPage,
            prev: prev,
            list: list,
            next: next,
            current: current,
            totalPage: totalPage,
            pathname: pathname || '/',
            queryString: queryString.join('&'),
            query: query
        };
    };

    function initDatetimepicker(selector) {
        $(selector).datetimepicker({
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            minView: 'month',
            maxView: 'month',
            todayBtn: true,
            todayHighlight: true,
            autoclose: true
        });
    };

    var _const_limit_ = 10;
    var _current_page_ = 0;

    return {
        init: function() {
            angular.module('reimApp', ['ng-dropdown']).controller('PayFlowController', ["$scope", "$element",
                function($scope, $element) {

                    initDatetimepicker($('.datepicker'));

                    $scope.isLoaded = false;

                    $scope.makeStatusDropdown = {
                        onChange: function (oldValue, newValue) {
                            $scope.selectedStatus = newValue;
                        }
                    }
                    // $scope function here
                    $scope.getTextByStatus = function (status) {
                        var m = {
                            'success': '成功',
                            'failure': '失败',
                            'paying': '支付中'
                        };
                        return m[status];
                    };

                    // get page data
                    function doPageAction(query) {
                        $scope.isLoaded = false;
                        getFlowWithQuery(query).done(function (rs) {
                            if (rs['status'] <= 0) {
                                return show_notify(rs['data']['msg']);
                            }
                            $scope.payList = rs['data']['items'];

                            $scope.isLoaded = true;

                            var totalPage = Math.ceil(rs['data']['count'] / _const_limit_);

                            $scope.pageNaviData = pageMaker({
                                current: query.offset,
                                pathname: '',
                                totalPage: totalPage,
                                wing: 5,
                                query: query
                            });

                            $scope.$apply();
                        });
                    }

                    doPageAction({limit: _const_limit_, offset: 0});

                    $scope.payStatusArray = [
                        {text: '全部', value:''},
                        {text: '付款中', value:'paying'},
                        {text: '付款成功', value:'success'},
                        {text: '付款失败', value:'failure'}
                    ];

                    // events handler here
                    $scope.onQuery = function (query) {
                        // carrier_type: 类型 - string, 描述 - 支付载体类型（目前只有报销单可以支付，此处应为报销单类型 - exr， 也可不填，目前默认为exr）
                        // carrier_id: 类型 - string, 描述 - 支付载体ID（目前为报销单ID）
                        // operator_id: 类型 - string, 描述 - 支付操作人ID
                        // status: 类型 - string, 描述 - 支付状态(目前支持'all' - 全部， 'paying' - 支付中, 'success' - 成功, 'failure' - 失败)
                        // start_time: 类型 - string, 描述 - 查询起始时间(支持'2015-06-01'格式)
                        // end_time: 类型 - string, 描述 - 查询起始时间(支持'2015-06-01'格式)
                        // min_amount: 类型 - string, 描述 - 查询最低金额
                        // max_amount: 类型 -

                        var carrier_type = 'exr';
                        var carrier_id = $element.find('.pay-no').val();
                        var start_time = $element.find('.start-time').val();
                        var end_time = $element.find('.end-time').val();
                        var min_amount = $element.find('.min-amount').val();
                        var max_amount = $element.find('.max-amount').val();
                        var pay_status = $scope.selectedStatus;

                        var data = {
                            carrier_type: carrier_type,
                            carrier_id: carrier_id,
                            start_time: start_time,
                            end_time: end_time,
                            min_amount: min_amount,
                            max_amount: max_amount,
                            status: pay_status,
                            limit: _const_limit_,
                            offset: 0
                        };

                        doPageAction(data);
                    };

                    $scope.onPage = function (num, pageNaviData) {
                        var query = pageNaviData.query;
                        query.offset = num;
                        doPageAction(query);
                    };

                    $scope.onPreviewItem = function (item) {
                        var dialog = new CloudDialog({
                            title: '支付详情',
                            okValue: '关闭',
                            cancel: null
                        });
                        dialog.showModal();
                        // carrier_id: "1474"
                        // carrier_name: "123"
                        // carrier_type: "exr"
                        // created_at: "2016-05-09 18:26:21"
                        // currency: "cny"
                        // description: "批量进行企业向员工微信钱包支付（串行）"
                        // employee_name: "张无忌"
                        // failure_msg: null
                        // finished_at: "2016-05-09T18:26:22+00:00"
                        // force_check_name: true
                        // local_bill_no: "20160509182621010000821019"
                        // mode: "b2c"
                        // operator_name: "我是财务70d"
                        // payway: "wechat_pub"
                        // status: "success"
                        // uid: "40"
                        // updated_at: "2016-05-09 18:26:22"
                        // wechat_bill_no: "
                        var tmpl = [
                            '<div class="item-detail table-container">',
                            '    <table>',
                            '        <tbody>',
                            '            <tr>',
                            '                <td class="col-label">付款单号</td>',
                            '                <td><%= local_bill_no %></td>',
                            '                <td class="col-label">支付渠道单号</td>',
                            '                <td><%= wechat_bill_no %></td>',
                            '            </tr>',
                            '            <tr>',
                            '                <td class="col-label">付款方式</td>',
                            '                <td><%= payway=="wechat_pub"?"微信钱包":"其它" %></td>',
                            '                <td class="col-label">收款人</td>',
                            '                <td><%= employee_name %></td>',
                            '            </tr>',
                            '            <tr>',
                            '                <td class="col-label">部门</td>',
                            '                <td><%= uid %></td>',
                            '                <td class="col-label">付款金额</td>',
                            '                <td><%= amount %></td>',
                            '            </tr>',
                            '            <tr>',
                            '                <td class="col-label">提交人员（出纳）</td>',
                            '                <td><%= operator_name %></td>',
                            '                <td class="col-label">提交时间</td>',
                            '                <td><%= created_at %></td>',
                            '            </tr>',
                            '            <tr>',
                            '                <td class="col-label">付款状态</td>',
                            '                <td><%= status %></td>',
                            '                <td class="col-label">最近更新时间</td>',
                            '                <td><%= updated_at %></td>',
                            '            </tr>',
                            '            <tr>',
                            '                <td class="col-label">付款说明</td>',
                            '                <td class="desc"><%= description %></td>',
                            '                <td class="col-label">报销单</td>',
                            '                <td><a target="_blank" href="/reports/show/<%= carrier_id %>"><%= carrier_name %></a></td>',
                            '            </tr>',
                            '        </tbody>',
                            '    </table>',
                            '</div>'
                        ].join('')

                        dialog.content(_.template(tmpl)(item));

                        setTimeout(function () {
                            $(window).trigger('resize');
                        })

                    };

                }
            ]);
        }
    }
}()).init();