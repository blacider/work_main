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
                        $scope.payList = rs['data'];
                        $scope.$apply();
                    })


                    // events handler here
                    $scope.onPreviewItem = function (item) {
                        var dialog = new CloudDialog({
                            title: '支付详情'
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