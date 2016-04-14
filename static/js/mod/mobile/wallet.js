(function () {
	var query = Utils.queryString(location.search);

	var debugConsole = new DebugConsole({
	    debug: 1
	});

	var _PROFILE_ = {};

	debugConsole.log(location.href);

	function getProfileByCodeAndState(query) {
		return Utils.api('/giro_auth/wxauth_callback_process', {
			method: 'post',
			env: 'miaiwu',
			data: {
				'wx_params': $.param({code: query['code'], state: query['state']})
			}
		}).done(function (rs) {
			debugConsole.row('profile', JSON.stringify(rs));

			if(rs['status']<=0) {
				return
			}

			_PROFILE_ = rs['data'];
			$('.wx-nickname').text(_PROFILE_['nick_name']);
			$('.nickname').text(_PROFILE_['user_name']);
			$('.company').text(_PROFILE_['company_name']);
			$('.job').text(_PROFILE_['user_rank']);

			var mode = '手机号';

			if(_PROFILE_['check_mode'] == 'email') {
				mode = '邮箱';
			}

			$('.mode').text(mode);
			$('.receiver').text(_PROFILE_['check_receiver']);
			// $('.wx-accout').text(profile['nick_name']);
		});
	};

	function checkBefore(data) {
		return Utils.api('/giro_auth/wxauth_bival_request_validation', {
			method: 'post',
			env: 'miaiwu',
			data: data
		}).done(function (rs) {
			if(rs['status']<=0) {
				return
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

	function acrivate(data) {
		// nonce: 类型 - string, 描述 - 接口2中返回的随机码;
		// uid: 类型 - string, 描述 - 接口2中的用户的UID;
		// payhead_id: 类型 - string, 描述 - 接口2中用户的桃园户头ID。
		return Utils.api('/giro_auth/inform_wxauth_bival_success', {
			method: 'post',
			env: 'miaiwu',
			data: data
		}).done(function (rs) {
			if(rs['status']<=0) {
				return
			}
		});
	};

	function doVerifyCode(data) {
		return Utils.api('/vcode/verify', {
			method: 'post',
			env: 'miaiwu',
			data: data
		}).done(function (rs) {
			if(rs['status']<=0) {
				return
			}
		});
	}

	function ticker(count, tick, done) {
		function handler() {
			count--;
			if(count<=0) {
				return done();
			}
			tick(count);
			setTimeout(function () {
				handler();
			}, 1000);
		};
		handler();
	};

	function _bindEvents_() {
		$('.btn-send-code').on('click', function (e) {
			if($(this).hasClass('waiting')) {
				return;
			}
			$(this).addClass('waiting');
			checkBefore({
				nonce: _PROFILE_['nonce'],
				mode: _PROFILE_['check_mode'],
				receiver: _PROFILE_['check_receiver']
			}).done(function (rs) {
				debugConsole.row('checkBefore', JSON.stringify(rs));
				if(rs['status']<=0) {
					return
				}
				
				var data = {};
				data[_PROFILE_['check_mode']] = _PROFILE_['check_receiver'];

				getCode(data).done(function (rs) {
					debugConsole.row('getCode', JSON.stringify(rs));
					if(rs['status']<=0) {
						return
					}
					ticker(15, function (num) {
						$('.btn-send-code').text(num + '秒后重发');
					}, function () {
						$('.btn-send-code').text('发送验证码').removeClass('waiting');
					});
				});
			});
		});



		$('.btn-submit').on('click', function (rs) {
			var code = $('input.code').val();

			if(!code) {
				$('input.code').focus();
				return $('.fail').show().text('请输入验证码');
			}

			checkBefore({
				nonce: _PROFILE_['nonce'],
				mode: _PROFILE_['check_mode'],
				receiver: _PROFILE_['check_receiver']
			}).done(function (rs) {
				if(rs['status']<=0) {
					return $('.fail').show().text(rs['data']['msg']);
				}

				var data = {};
				data[_PROFILE_['check_mode']] = _PROFILE_['check_receiver'];

				doVerifyCode(data).done(function (rs) {
					if(rs['status']<=0) {
						return $('.fail').show().text(rs['data']['msg']);
					}
					acrivate({
						nonce: _PROFILE_['nonce'],
						uid: _PROFILE_['uid'],
						payhead_id: _PROFILE_['taoyuan_uid']
					}).done(function (rs) {
						if(rs['status']<=0) {
							return $('.fail').show().text(rs['data']['msg']);
						}
						$('.input-wrap').empty().append('<h2 class="succ" style="display: block">授权成功！</h2>')
					});
				})
			});
		});

		$('input.code').on('focus', function () {
			$('.fail').hide();
		})

	};

	return {
		init: function () {
			getProfileByCodeAndState(query).done(function (rs) {
				_bindEvents_();
			});
		}
	};
})().init();