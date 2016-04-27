(function (e) {

	var _COMPANY_PAYHEAD_ = {};

	function getCompanyPayHeads() {
		// report_id 类型 - string, 描述 - 需处理的报销单ID。
		// company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
		// payway 类型 - string, 描述 - 指定的支付方式。
		// description 类型 - string, 描述 - 支付描述信息。
		return Utils.api('giro_payhead/company_payheads', {
			env: 'miaiwu'
		}).done(function (rs) {
			if(rs['status']<=0) {
				return;
			}

			_COMPANY_PAYHEAD_ = rs['data'];

			if(_COMPANY_PAYHEAD_['wechat_pub']['payhead_uid']) {
				$('.btn-pay').show();
			}
		});
	};

	function canPayable(data) {
		// report_id 类型 - string, 描述 - 需处理的报销单ID。
		// company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
		// payway 类型 - string, 描述 - 指定的支付方式。
		// description 类型 - string, 描述 - 支付描述信息。
		return Utils.api('giro_transaction/fetch_reports_payables', {
			method: 'post',
			env: 'miaiwu',
			data: data
		}).done(function (rs) {
			if(rs['status']<=0) {
				return;
			}
		});
	};

	function doPayItem(data) {
		// report_id 类型 - string, 描述 - 需处理的报销单ID。
		// company_payhead_id 类型 - string, 描述 - 指定的公司支付户头ID。
		// payway 类型 - string, 描述 - 指定的支付方式。
		// description 类型 - string, 描述 - 支付描述信息。
		return Utils.api('giro_transaction/pay_report', {
			method: 'post',
			env: 'miaiwu',
			data: data
		});
	};

	function doPayOneByOne(index, list, opts) {
		var item = list[index];
		var itemData = {
			report_id: item.id,
			company_payhead_id: _COMPANY_PAYHEAD_['wechat_pub']['payhead_uid'],
			payway: 'wechat_pub',
			description: '批量进行企业向员工微信钱包支付（串行）'
		}

		doPayItem(itemData).done(function (rs) {
			if(rs['status']<=0) {
				opts['interruptHandler'](index, list);
				return show_notify(rs['data']['msg']);
			}
			if(index<list.length-1) {
				opts['eachHandler'](index, list);
				doPayOneByOne(index++, list);
			} else {
				opts['completeHandler'](list, index);
			}
		});
	}

	function onPay() {
		$('.btn-pay').on('click', function (e) {
			var ids = selectRows;
			canPayable({
				report_ids: ids,
				company_payhead_id: _COMPANY_PAYHEAD_['wechat_pub']['payhead_uid'],
				payway: 'wechat_pub'
			}).done(function (rs) {
				if(rs['status']<=0) {
					return show_notify(rs['data']['msg']);
				}

				var map = rs['data'];
				var rs = [];
				for(var id in map) {
					rs.push(id);
				}

				doPayOneByOne(0, rs, {
					interruptHandler: function (index, list) {
						show_notify(index + ' is not ok');
					},
					eachHandler: function (index, list) {
						show_notify(index + ' is ok and next will be done');
					},
					completeHandler: function (index, list) {
						show_notify('success');	
					}
				})
				
			});
		});
	};

	function _bindEvents_() {
		onPay();
	};

	return {
		init: function () {
			getCompanyPayHeads();
			_bindEvents_();		
		}
	}
}()).init();