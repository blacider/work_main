(function () {
	var query = Utils.queryString(location.search);
	var _CONST_DELAY_ = 55;

	var debugConsole = new DebugConsole({
	    debug: 0
	});

	var _PROFILE_ = {};

	debugConsole.log(location.href);

	function getProfileByCodeAndState(query) {
		return Utils.api('/giro_auth/wxauth_process', {
			method: 'post',
			env: 'online',
			data: {
				'wx_code': query['code'],
				'wx_state': query['state'],
				'client_id': window.__CLIEN_ID__,
				'client_secret': window.__CLIEN_SECRET__,
			}
		}).done(function (rs) {

			debugConsole.row('profile', JSON.stringify(rs));

			if(rs['status']<=0) {
				$('.input-wrap').empty().append('<h2 class="succ" style="display: block">' + rs['data'
					]['msg']+ '</h2>');
				return;
			}

			_PROFILE_ = rs['data'];
			$('.wx-nickname').text(_PROFILE_['nick_name']);
			$('.nickname').text(_PROFILE_['user_name']);
			$('.company').text(_PROFILE_['company_name']);
			$('.job').text(_PROFILE_['user_rank']);

			var mode = '手机号';

			if(_PROFILE_['addr_type'] == 'email') {
				mode = '邮箱';
			}

			$('.mode').text(mode);
			$('.receiver').text(_PROFILE_['addr_value']);
			// $('.wx-accout').text(profile['nick_name']);
		});
	};

	function getCode(token) {
		// data: {
		// 	email: ''
		// 	phone:''
		// }
		return Utils.api('/giro_auth/wxauth_bival_request', {
			method: 'post',
			env: 'online',
			token: token,
		}).done(function (rs) {
			if(rs['status']<=0) {
				return
			}
		});
	};

	function doVerifyCode(data, token) {
		return Utils.api('/giro_auth/wxauth_bival_validation', {
			method: 'post',
			env: 'online',
			data: data,
			token: token,
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

			getCode(_PROFILE_['access_token']).done(function (rs) {
				debugConsole.row('getCode', JSON.stringify(rs));
				if(rs['status']<=0) {
					return
				}
				ticker(_CONST_DELAY_, function (num) {
					$('.btn-send-code').text(num + '秒后重发');
				}, function () {
					$('.btn-send-code').text('重新发送').removeClass('waiting');
				});
			});
		});

		$('.btn-submit').on('click', function (rs) {
			var code = $('input.code').val();

			if(!code) {
				$('input.code').focus();
				return $('.fail').show().text('请输入验证码');
			}

			var data = {
				vcode: code,
				payhead_id: _PROFILE_['payhead_id'],
			};

			data[_PROFILE_['check_mode']] = _PROFILE_['check_receiver'];

			doVerifyCode(data, _PROFILE_['access_token']).done(function (rs) {
				if(rs['status']<=0) {
					return $('.fail').show().text(rs['data']['msg']);
				}
				$('.input-wrap').empty().append('<h2 class="succ" style="display: block">授权成功！</h2>')
			})
		});

		$('input.code').on('focus', function () {
			$('.fail').hide();
		})

	};

	return {
		init: function () {
			getProfileByCodeAndState(query).done(function (rs) {
				_bindEvents_();
				(function autoSendIfCan() {
					setTimeout(function () {
						$('.btn-send-code').trigger('click');
					}, 100);
				})();


			});
		}
	};
})().init();