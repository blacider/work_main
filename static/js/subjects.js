$('document').ready(function(){
	$.getJSON(__BASEURL + 'api/subjects/lists', function(data){
		var _sub = '<select name="pid"><option value="0">顶级分类</option>';
		var _count = data['total'];
		var _data = data['data'];
		var _tbl = '';
		for(var i = 0; i < _count; i++){
		_tbl += '<tr>';
			var j = _data[i];
			_sub += "<option value='" + j['id'] + "'>" + j['name'] + '</option>';
			_tbl += '<td>[ ' + j['pname'] + " ] - [ " + j['name'] + ']</td><td>' + j['creat_dt'] + '</td><td><a href="' + __BASEURL + 'admin/subjects/del?i=' + j['id'] + '">删除</a>';
		_tbl += '</tr>';
		}
		_sub += '</select>';
		$('#subjects').append(_tbl);
		var _config = {
			'id' : 'subject_menu'
		,'title' : '创建新课程分类'
		,'_class' : ''
		,'method' : 'post'
		,'target' : __BASEURL + 'admin/subjects/new_item'
		,'body' : new Array(
			{cate : 'input', type : 'text', name : "name", value : "", placeholder : '课程分类名称', id : 'subject_name'}
			,{cate : 'desc', value : _sub}
			)
		,'footer' : '创建'
		};
		auto_dialog(_config);
		$('#add_new_btn').click(function(){
			$('#subject_menu').modal();
		});
	});
});
