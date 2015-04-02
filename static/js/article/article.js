$(document).ready(function(){
        var _config = {
        'id' : 'add_menu'
        ,'method' : 'post'
        ,'target' : __BASEURL + 'admin/article/add_group/'
        ,'title' : '添加组'
        ,'_class' : 'add_group'
        ,'body' : new Array(
            {cate : 'input', type : 'hidden', name : "pos", placeholder : 'name', _class : 'abc'}
            ,{cate : 'input', type : 'text', name : "name", placeholder : 'name', _class : 'abc'}
            )
        ,'footer' : '提交'
        };
        auto_dialog(_config);
        var _config_update_group = {
        'id' : 'update_menu'
        ,'method' : 'post'
        ,'target' : __BASEURL + 'admin/article/update_group/'
        ,'title' : '更新组'
        ,'_class' : 'update_group'
        ,'body' : new Array(
            {cate : 'input', type : 'text', name : "name",  _class : 'abc'}
            ,{cate : 'input', type : 'hidden', name: 'id' }
            )
        ,'footer' : '提交'
        };
        auto_dialog(_config_update_group);
        $("#add_menu input[name='pos']").after("<div id='a'><select name='pid' id='g'>"
                + " <option value='" + __TOP_GID + "'>新建</option>"
                + " </select></div>");

        $("input[name='name']").after("<div id='types'>"
                + "<input type='checkbox' name='rid1'>Picture</input>"
                + "<input type='checkbox' name='rid2'>File</input>"
                + "<input type='checkbox' name='rid3'>Video</input>");

        var group=[];
        var sub1=[];
        $.getJSON(__BASEURL+ "/api/article/get_group/" + __TOP_GID,function(data){
                $.each(data,function(k,level1){
                    $("#g").append( "<option value="+ level1.id +">"+ level1.name +" </option>");
                    sub1[level1.id]= level1.sub1;
                    /*
                       $(level1).each(function(idx, item){
                       $("#g").append( "<option value="+ item.id +">"+ item.name +" </option>");
                       });
                       */
                    /*
                       group[level1.id] = level1.name;
                       $("#g").append( "<option value="+ level1.id +">"+ level1.name +" </option>");
                       if(level1.sub1.length > 0){
                       sub1[level1.id]= level1.sub1;
                       }else{
                       group['sub1']=[];
                       sub1[level1.id]= [];
                       }    
                       */
                    });
        });
        $("#g").change(function(){
                level1_id = $("#g").find("option:selected").val();
                if(level1_id > 0 && sub1[level1_id].length > 0){
                $("#a").append("<select id='p'>");
                $("#p").prepend("<option val='0'>新建</option>");
                $.each(sub1[level1_id],function(k, sub2){
                    $("#p").append("<option value="+sub2.id+">" + sub2.name+"</option>");
                    });
                }else{
                $("#p").remove();
                }
               // $("form").submit();
                });
 
        $('#add_fire').click(function(){
                $('#add_menu').modal();
                });

        $("add_menu").submit(function(){
                $("#g").attr('name', 'pid');
                if($("#p").length>0){ 
                if($("#p").val() > 0){
                $("#g").removeAttr('name');
                $("#p").attr('name', 'pid');
                }
                }
                if($("input[name='name']").val()=="") return false;
                });
        $('[name="update_fire"]').click(function(){
                $('#update_menu input[name="id"]').val($(this).closest("tr").find('[name = "id"]').val());
                $('#update_menu input[name="name"]').val($(this).closest("tr").find('td:first').text());
                $("#update_menu").find("input:checkbox").prop("checked",false);
                if($(this).closest("tr").find('[name="rid1"]').val()==1) {
                    $("#update_menu input[name='rid1']").prop("checked",true);
                }
                if($(this).closest("tr").find('[name="rid2"]').val()==1) {
                    $("#update_menu input[name='rid2']").prop("checked",true);
                }
                if($(this).closest("tr").find('[name="rid3"]').val()==1) {
                    $("#update_menu input[name='rid3']").prop("checked",true);
                }
                $('#update_menu').modal();
         });
});




