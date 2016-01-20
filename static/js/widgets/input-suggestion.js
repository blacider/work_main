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
				url: '/static/js/data/bank_db.js',
				dataType: 'json',
				success: function (rs, opts) {
					var tmpl = _self.options.itemTemplate
					// _self.$el.empty()
					for(var name in rs) {
						var data = {};
						data.prefix = rs[name].join(',');
						data.text = name;
						_self._renderItem_(tmpl, data);
					}

					_self.options.onDataLoaded.call(_self, rs);
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