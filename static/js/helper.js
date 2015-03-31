

function auto_dialog(config){
	var _config = {
		'id' : 'auto_generate_modal'
		,'_class' :''
		,'target' :'/user/login'
		,'method' :'GET'
		,'title' : '默认标题'
		,'body' : new Array(
				)
		,'footer' : '提交'
	};
	$.extend(true, _config, config);
	// 有值了，开始搞起来
    var _doc = '';
	_doc += '<div class="modal hide fade ' + config._class + '" id="' + config.id + '">' ;
	_doc += '<form method="' + config.method + '" action="' + config.target + '">';
    _doc +=  '<div class="modal-header">' 
		+ '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
		+ '<h3>' + config.title + '</h3>'
		+ '</div>'
		+ '<div class="modal-body">';
	$(_config.body).each(function(idx, item){
		var _cate = item.cate;
		if(_cate == "desc"){
			_doc += "<p>" + item['value'] + "</p>";
		} else {
			_doc += '<p><' + item.cate + ' ';
			delete(item.cate);
			for(var k in item){
				v = k == "_class" ? '_class' : k;
				k = k == "_class" ? 'class' : k;
				_doc += k + "='" + item[v] +"' ";
			}
			_doc  += ' >';
			if(_cate != 'input'){
				_doc += item['value'] + "</" + _cate + ">";
			}
			'</p>';
		}
	});
	_doc += '</div>'
		+ '<div class="modal-footer">'
		+ '<button type="button" class="btn btn-close">关闭</button>'
		+ '<input type="submit" name="submit" class="btn btn-primary" value="' + config.footer + '" />'
        + '</form>'
		+ '</div>'
		+ '</div>';
	$('body').append(_doc);
	$('#' + config.id).modal({'show' : false});
    var popup_dom = document.getElementById(config.id);
    $(popup_dom).find('.btn-close').click(function(){
	    $('#' + config.id).modal('hide');
        return false;
    });
}

/*
var _config = {
	'id' : 'try_menu'
		,'title' : '修改标题'
		,'_class' : 'xxx'
		,'body' : new Array(
				{cate : 'input', type : 'text', name : "test", value : "xxx", placeholder : '特斯拉A', id : 'abc', _class : 'abc'}
				, {cate : 'desc', value : '<select id="test" name="goodday"><option value="1">测试</option></select>'}
				, {cate : 'button', name : "test", value : "xxx", placeholder : '特斯拉B'}
				, {cate : 'input', type : 'text', name : "test", value : "xxx", placeholder : '特斯拉C'}
				, {cate : 'input', type : 'text', name : "test", value : "xxx", placeholder : '特斯拉D'}
				)
		,'footer' : '提交'
};

auto_dialog(_config);
*/
