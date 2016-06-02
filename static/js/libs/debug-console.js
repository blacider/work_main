(function  (exports) {
	var style = [
		'.debug-console {',
		'	position: fixed;',
		'	width: 100%;',
		'	height: 100%;',
		'	top: 0;',
		'	left: 0;',
		'	background: #000;',
		'	-webkit-transition: .1s linear all;',
		'	-o-transition: .1s linear all;',
		'	-moz-transition: .1s linear all;',
		'	-ms-transition: .1s linear all;',
		'	color: #fff;',
		'	z-index: 9999;',
		'	overflow: scroll;',
		'}',
		'.debug-console .close, .debug-console .clear {',
		'	position: absolute;',
		'	left: 0;',
		'	top: 0;',
		'	background: red;',
		'	content: "x";',
		'	width: 30px;',
		'	height: 30px;',
		'	color: #fff;',
		'	display: block;',
		'	text-align: center;',
		'	line-height: 30px;',
		'	z-index: 9;',
		'}',
		'.debug-console .clear {',
		'	right: 0;',
		'	left: auto;',
		'	background: blue;',
		'	z-index: 1;',
		'}',
		'.debug-console.mini {',
		'	width: 30px;',
		'	height: 30px;',
		'	overflow: hidden;',
		'}',
		
		'.debug-console .content {',
		'	margin: 30px;',
		'}',
		'.debug-console .content .row {',
		'	margin: 2px;',
		'}',
		'.debug-console .content .row span {',
		'	padding: 3px;',
		'	background: gray;',
		'}',
	].join('');

	var tmpl = [
		'<div class="debug-console" style="display: block">',
		'	<div class="close">关</div>',
		'	<div class="clear">清</div>',
		'	<div class="content">',
		'	</div>',
		'</div>',
	].join('')

	function DebugConsole(opts) {
		this.opts = $.extend({
			autoShow: false,
			debug: false
		}, opts);
		this.$el = $(tmpl).appendTo('body');
		if(!this.opts['autoShow']) {
			this.$el.addClass('mini')
		}
		this.setStyle();
		this._bindEvents_();
		if(!this.opts['debug']) {
			this.$el.css({'z-index': -99, width: 1, height: 1}).hide();
		}
	};
	$.extend(DebugConsole.prototype, {
		setStyle: function  (e) {
			$('<style>').text(style).appendTo('body')
		},
		log: function  (content) {
			if(!this.opts['debug']) {
				return
			}
			this.$el.find('.content').append($('<div/>').html(content))
		},
		row: function  (title, content) {
			this.log('<div class="row"><span>{{title}}</span><p>{{content}}</p></div>'.replace('{{title}}', title).replace('{{content}}', content));
		},
		_bindEvents_: function  (e) {
			var _this = this;
			this.$el.find('.close').on('click', function  (e) {
				$(_this.$el).hasClass('mini') ? $(_this.$el).removeClass('mini'):$(_this.$el).addClass('mini');
			});
			this.$el.find('.clear').on('click', function  (e) {
				$(_this.$el).find('.content').empty()
			});
		}
	});

	exports.DebugConsole = DebugConsole

})(window)