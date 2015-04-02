$(document).ready(function(){
	$.getJSON(__BASEURL + 'api/article/list_group', function(data){
		// console.log(data);
		var _sub = '<select name="pid"><option value="0">顶级分类</option>';
		var _count = data['total'];
		var _data = data['data'];
		var _tbl = '';
		for(var i = 0; i < _count; i++){
		_tbl += '<tr>';
			var j = _data[i];
			_sub += "<option value='" + j['id'] + "'>" + j['name'] + '</option>';
			_tbl += '<td>[ ' + j['name'] + ']</td><td>' + j['create_time'] + '</td><td><a href="' + __BASEURL + 'admin/article/del_group/' + j['id'] + '">删除</a>';

		_tbl += '</tr>';
		}
		_sub += '</select>';
		$('#subjects').append(_tbl);
		var _config = {
			'id' : 'add_menu'
		,'method' : 'post'
		,'target' : __BASEURL + 'admin/article/add_group'
		,'title' : '添加组'
		,'_class' : 'add_group'
		,'body' : new Array(
			{cate : 'input', type : 'text', name : "name", placeholder : 'name'}
			)
		,'footer' : '提交'
		};
		auto_dialog(_config);

		var _config_update_group = {
			'id' : 'update_menu'
				,'method' : 'post'
				,'target' : $("#updateurl").val()
				,'title' : '更新组'
				,'_class' : 'update_group'
				,'body' : new Array(
						{cate : 'input', type : 'text', name : "name",  _class : 'abc'}
						,{cate : 'input', type : 'hidden', name: 'id' }
						)
				,'footer' : '提交'
		};
		auto_dialog(_config_update_group);

		$('#add_new_btn').click(function(){
			$('#add_menu').modal();
		});
		$('[name="update_fire"]').click(function(){
			$('#update_menu input[name="id"]').val($(this).closest("tr").find('[name = id]').val());
			$('#update_menu input[name="name"]').val($(this).closest("tr").find('[name = name]').val());
			$('#update_menu').modal();
		});
	});

});


