(function  ($, exports) {
	function InputSuggestion (el, opts) {
		this.init();
		
		this.$el = $(el);
		this.options = $.extend({
			itemTemplate: "<option value='<%= text %>' data-prefix='<%= prefix %>'><%= text %></option>",
			onDataLoaded: function  () {
				
			}
		}, opts);
	};

	$.extend(InputSuggestion.prototype, {
		init: function () {
			var _self = this;
			this.fetchRemoteData().done(function  () {
				$(_self.$el).chosen({
					width: '300px'
				});
				// $(_self.$el).val('');
			});
		},
		fetchRemoteData: function (callback) {
			var _self = this;
			return $.ajax({
				url: '/bank/get_banks/0',
				dataType: 'json',
				success: function (rs, opts) {
					var data = {
						'暂无可用银行信息': []
					}
					if(rs['status']>0) {
						data = rs['data']['bank_dic'];
					}
					var tmpl = _self.options.itemTemplate
					// _self.$el.empty()
					for(var name in data) {
						var item = {};
						item.prefix = data[name].join(',');
						item.text = name;
						_self._renderItem_(tmpl, item);
					}

					_self.options.onDataLoaded.call(_self, data);
				},
				error: function  () {
					// body...
				}
			})		
		},
		_renderItem_: function (tmpl, data) {
			this.$el.append(_.template(tmpl)(data));
		}

	});

	return exports.InputSuggestion = InputSuggestion;

})($, window);