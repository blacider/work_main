$(document).ready(function(){
        var _config = {
        'id' : 'add_menu'
        ,'method' : 'post'
        ,'target' : __BASEURL + 'admin/post/add_bar/'
        ,'title' : '添加贴吧'
        ,'_class' : 'add_bar'
        ,'body' : new Array(
            {cate : 'input', type : 'text', name : "name", placeholder : '贴吧名称', _class : 'abc'}
           ,{cate : 'textarea', name : "desc",_class : 'abc'}
            )
        ,'footer' : '提交'
        };
        auto_dialog(_config);
        var _config_update = {
        'id' : 'update_menu'
        ,'method' : 'post'
        ,'target' : __BASEURL + 'admin/post/update_bar/'
        ,'title' : '更新贴吧'
        ,'_class' : 'update_bar'
        ,'body' : new Array(
            {cate : 'input', type : 'text', name : "name",  _class : 'abc'}
            ,{cate : 'textarea', name : "desc",  _class : 'abc'}
            ,{cate : 'input', type : 'hidden', name: 'id' }
            )
        ,'footer' : '提交'
        };
        auto_dialog(_config_update);

        $('#add_fire').click(function(){
                $('#add_menu textarea[name="desc"]').text('贴吧描述');
                $('#add_menu').modal();
                });

        $('[name="update_fire"]').click(function(){
                $('#update_menu input[name="id"]').val($(this).closest("tr").find('[name = "id"]').val());
                $('#update_menu input[name="name"]').val($(this).closest("tr").find('td:first').text());
                $('#update_menu textarea[name="desc"]').val($(this).closest("tr").find('td').eq(1).text());
                $('#update_menu').modal();
                });

});


