(function () {

	function getCode(data) {
		return Utils.api('/vcode/bind', {
			env: 'online',
			method: 'post',
			data: data
		});
	};

	function bindSelfEmail(data) {
		// 管理员不用传uid
		// {
			//emaol/phone
			// uid
		// }
		return Utils.api('/users', {
			env: 'online',
			method: 'put',
			data: data
		});
	};

	function _bindEvents_() {
		$('.change_email').on('click', function (e) {
			$('#modalUpdateEmail').modal('show');
		});

		$('.btn-get-email-code').on('click', function (e) {
			var email = $(this).parents('.modal-content').find('input.email').val();
			if(!email) {
				return show_notify('请输入邮箱');
			}
			getCode({
				email: email
			}).done(function (rs) {
				if(rs['status']>0) {
					show_notify('验证码已发送到邮箱');
				} else {
					show_notify(rs['data']['msg']);
				}
			});
		});

		$('.btn-bind-email').on('click', function (e) {
			var email = $(this).parents('.modal-content').find('input.email').val();
			if(!email) {
				return show_notify('请输入邮箱');
			}
			var data = {
				email: email
			}
			if(__UID__ == $('input[name=uid]').val()) {
				var vcode = $(this).parents('.modal-content').find('input.vcode').val();
				if(!vcode) {
					return show_notify('请输入验证码');
				}
				data['vcode'] = vcode;
				
			} else {
				data['uid'] = $('input[name=uid]').val();
			}

			bindSelfEmail(data).done(function (rs) {
				if(rs['status']>0) {
					show_notify('邮箱已经绑定');
					window.location.reload();
				} else {
					show_notify(rs['data']['msg']);
				}
			});
		});
	};

	return  {
		init: function () {
			_bindEvents_();
		}
	}
}()).init()