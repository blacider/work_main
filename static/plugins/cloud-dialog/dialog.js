(function  () {
	var dialogIDPrefix = 'cloud-bx-dialog-';
	var dialogCount = 0;

	var dialogTemplate = [
		'<div id="" class="cloud-bx-dialog-mask">',
		'    <div class="cloud-bx-dialog">',
		'        <div class="dialog-header">',
		'            <p class="title"></p>',
		'            <button tabindex="1" class="close" title="cancel">×</button>',
		'        </div>',
		'        <div class="dialog-body">',
		'        </div>',
		'        <div class="dialog-footer">',
		// '            <button>取消</button>',
		// '            <button class="positive">确定</button>',
		'        </div>',
		'    </div>',
		'</div>',
	].join('');

	function Dialog (opts) {
		this.options = $.extend({
			title: '',
			quickClose: false,
			autoDestroy: true,
			className: '',
			content: '',
			width: 240,
			offset: {
				left: 0,
				top: 0
			},
			className: 'text-align',
			buttonAlign: 'center',
			buttons: [
				// {
				// 	text: '1',
				// 	disabled: false
				// 	className: '',
				// 	icon: '',
				// 	handler: function  () {
				// 	}
				// }
			],
			ok: function  () {
				return true;
			},
			cancel: function  () {
				return true;
			},
			onShow: function  () {
				// body...
			},
			onHide: function  () {
				// body...
			},
			onDestroy: function  (argument) {
				
			},
			okIcon:'',
			okClassName:'',
			okDisabled: false,
			okValue: '确定',

			cancelIcon:'',
			cancelClassName:'',
			cancelDisabled: false,
			cancelValue: '取消'
		}, opts);
		this.$mask = $(dialogTemplate);
		this.$el = this.$mask.find('.cloud-bx-dialog');
		this.$title = this.$el.find('.dialog-header .title');
		this.$content = this.$el.find('.dialog-body');
		this.$footer = this.$el.find('.dialog-footer').css('text-align', this.options['buttonAlign']);
		this.init();
	};


	$.extend(Dialog.prototype, {
		init: function  (e) {
			// init title
			if(!this.options.title) {
				this.$title.addClass('none');
			} else {
				this.title(this.options.title);
			}

			// init content
			this.content(this.options.content);

			this.$mask.appendTo(document.body);
			this.$el.attr('id', dialogIDPrefix+dialogCount++);

			this.$el.addClass(this.options.className);

			this._bindEvents_();
			this.addButtons()
		},
		setContentWithElement: function (el) {
			var $content = this.$el.find('.dialog-body');
			$content.empty();
			$content.append(el);
		},
		addButtons: function () {
			var buttons = this.options.buttons;

			if(this.options.cancel) {
				var cancelButton = {
					text: this.options.cancelValue,
					disabled: this.options.cancelDisabled,
					icon: this.options.cancelIcon,
					className: this.options.cancelClassName || 'cancel',
					handler: this.options.cancel
				}
				buttons.push(cancelButton);
			}

			if(this.options.ok) {
				var okButton = {
					text: this.options.okValue,
					handler: this.options.ok,
					disabled: this.options.okDisabled,
					icon: this.options.okIcon,
					className: 'positive ok ' + this.options.okClassName
				}
				buttons.push(okButton);
			}

			for(var i=0;i<buttons.length;i++) {
				var button = buttons[i];
				var $button = $('<button>').text(button['text']);
				$button.addClass(button.className || '');

				if(button.disabled) {
					$button.attr('disabled', true);
					$button.attr('tabindex', i+2);
				}

				if(i==buttons.length-1) {
					$button.addClass('last');
				}

				$button.addClass(button.className);

				if(button.align) {
					$button.css({
						float: button.align
					})
				}

				if(button.icon) {
					$button.prepend('<i class="icon" />');
				}

				this.$footer.append($button);
			}
		},
		show: function  () {
			this.$mask.addClass('none').show();
			this.$el.addClass('animated zoomIn')
			this.options.onShow.call(this);
			$(window).trigger('resize');

			$('body').addClass('no-scroll');

			return this;
		},
		showModal: function  () {
			var _self = this;
			this.$mask.show();
			$('body').addClass('no-scroll');
			this.options.onShow.call(this);
			_self.$mask.addClass('animated fadeIn')
			_self.$el.addClass('animated zoomIn')
			$(window).trigger('resize');
			return this;
		},
		close: function  (isDestroy) {
			this.$mask.hide();
			this.options.onHide.call(this);
			$('body').removeClass('no-scroll');
			if(isDestroy) {
				this.$mask.remove()
				this.options.onDestroy.call(this);
			}
			return this;
		},
		desotry: function  () {
			this.$mask.remove()
			$('body').removeClass('no-scroll');
			this.options.onDestroy.call(this);
			return this;
		},
		title: function (title) {
			if(title) {
				this.$el.find('.dialog-header .title').html(title);
			} else {
				return this.$el.find('.dialog-header .title').html();
			}
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
		_bindEvents_: function  () {
			var _self = this;

			this.$el.on('click', '.close', function  (e) {
				if(_self.options['autoDestroy']) {
					_self.close(true);
				} else {
					_self.close();
				}
			});

			this.$el.on('click', '.dialog-footer button', function  (e) {
				var index = $(this).parent().find('button').index(e.currentTarget);
				var handler = _self.options.buttons[index].handler || function  () {
					// body...
				};
				if(handler.call(_self, e)) {
					_self.$el.find('.close').trigger('click');
				}
			});

			// can quick close
			this.$mask.on('click', function  (e) {
				if(!$(e.target).hasClass('cloud-bx-dialog-mask')) {
					return;
				}
				if(_self.options.quickClose) {
					_self.$el.find('.close').trigger('click');
				}
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

			$(window).on('resize', function (e) {
				setTimeout(function() {
					var width = window.innerWidth || document.body.clientWidth;
					var height = window.innerHeight || document.body.clientHeight;
					_self.$mask.width(width);
					_self.$mask.height(height);

					_self.$el.css({
						left: (width - _self.$el.width()) /2,
						top: (height - _self.$el.height()) /2
					})
				}, 0);
			});

		}
	});

	window.CloudDialog = Dialog;
})()