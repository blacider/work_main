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

	function Layer (opts) {
		this.options = $.extend({
			title: '',
			content: '',
			autoDestroy: true,
			margin: 10,
			className: 'text-align',
			onClose: function  () {
			},
			onDestroy: function  (argument) {
				
			}
		}, opts);
		this.$el = $(dialogTemplate);
		this.init();
	};

	$.extend(Layer.prototype, {
		init: function  (e) {

			// init content
			this.content(this.options.content);

			this.$el.appendTo(document.body);

			this._bindEvents();
		},
		show: function  () {
			this.$mask.addClass('none').show();
			this.$el.addClass('animated zoomIn')
			this.options.onShow.call(this);
			$(window).trigger('resize');
			return this;
		},
		close: function  (isDestroy) {
			this.$mask.hide();
			this.options.onHide.call(this);
			if(isDestroy) {
				this.$mask.remove()
				this.options.onDestroy.call(this);
			}
			return this;
		},
		desotry: function  () {
			this.$mask.remove()
			this.options.onDestroy.call(this);
			return this;
		},
		
		content: function  (content) {
			if(content) {
				this.$el.find('.dialog-body').html(content);
			} else {
				return this.$el.find('.dialog-body').html();
			}
			return this;
		},
		_bindEvents: function  () {
			var _self = this;
			
			this.$el.on('click', '.close', function  (e) {
				_self.close(true);
			});
 
			$(document).on('keyup', function  (e) {
				//esc key
				if(e.keyCode == 27) {
					if(_self.$mask.is(':visible')) {
						_self.$el.find('.close').trigger('click');
					}
				}
				if(e.keyCode == 13) {
					_self.$footer.find('button[focus]').trigger('click');
				}
			})
		}
	});

	window.CloudLayer = Layer;
})()