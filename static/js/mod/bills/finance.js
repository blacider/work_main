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
				var canPayArray = [];
				var otherPayArray = [];

				for(var id in map) {
					if(map[id]) {
						canPayArray.push(id);
					} else {
						otherPayArray.push(id);
					}
				}

				if(canPayArray.length==0) {
					var dialog = new CloudDialog({
						title: '12',
						content: '当前无可微信支付的报销单',
						ok: function (e) {
							this.close();
						}
					});
					dialog.showModal();
					return;
				}

				var str = '去支付报销单';
				if(otherPayArray.length != ids.length && otherPayArray.length>0) {
					str = '有'+otherPayArray.length + '条报销单不支持转账，是否继续？' ;
				}

				var dialog = new CloudDialog({
					content: str,
					ok: function (e) {
						window.open('/bills/paylist?rids=' + canPayArray.join(','));
						this.close();
					}
				});
				dialog.showModal();
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