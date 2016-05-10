(function  () {
	var dialogIDPrefix = 'cloud-bx-dialog-';
	var dialogCount = 0;

	var dialogTemplate = [
		'<div class="cloud-layer">',
	        '<button class="close">╳</button>',
	        '<div class="cloud-layer-text"></div>',
	        '<div class="cloud-layer-icon"></div>',
	        '<div class="cloud-layer-content"></div>',
	    '</div>'
	].join('');

	var dialogMaskTemplate = '<div class="cloud-layer-mask"></div>';

	function Layer (opts) {
		this.options = $.extend({
			content: '',
			autoDestroy: true,
			offset: {
				top: 10,
				left: 10,
				bottom: 10,
				right: 10
			},
			className: '',
			onHide: function  () {
			},
			onShow: function () {
			}
		}, opts, true);
		this.$mask = $(dialogMaskTemplate);
		this.$el = $(dialogTemplate);
		this.$content = this.$el.find('.cloud-layer-content');
		this.init();
	};

	$.extend(Layer.prototype, {
		init: function  (e) {
			// init content
			this.$el.css(this.options.offset);

			this.content(this.options.content);

			this.$mask.appendTo(document.body);
			this.$el.appendTo(document.body);

			this._bindEvents_();
		},
		show: function  () {
			$(document.body).addClass('overflow-hidden');
			this.$mask.show();
			this.$el.show();
			this.options.onShow.call(this);
			return this;
		},
		close: function  (isDestroy) {
			$(document.body).removeClass('overflow-hidden');
			this.$mask.hide();
			this.$el.hide();
			this.options.onHide.call(this, isDestroy);
			if(isDestroy) {
				this.$mask.remove();
				this.$el.remove();
			}
			return this;
		},
		content: function  (content) {
			if(content) {
				return this.$content.html(content);
			} else {
				return this.$content.html();
			}
		},
		_bindEvents_: function  () {
			var _self = this;
			
			this.$el.on('click', '.close', function  (e) {
				_self.close(_self.options.autoDestroy);
			});
 
			$(document).on('keyup', function  (e) {
				//esc key
				if(e.keyCode == 27) {
					if(_self.$el.is(':visible')) {
						_self.$el.find('.close').trigger('click');
					}
				}
			})
		}
	});

	window.CloudLayer = Layer;
})()