$(document).ready(function(){
        $.getJSON(__BASEURL+"/api/post/get_all_bar",function(data){
            console.log(data);
            $.each(data,function(k,bar){
                $("#sbar").append( "<option value="+ bar.id +">"+ bar.name +" </option>");
                });
            });
        var audit_url = __BASEURL+"admin/post/approved_post";
        var _config = {
        'id' : 'audit_modal'
        ,'method' : 'post'
        ,'target' :  audit_url
        ,'title' : '审核'
        ,'_class' : 'add_group'
        ,'body' : new Array(
            {cate : 'input', type : 'text', name : "name", placeholder : 'name', _class : 'abc'}
            )
        ,'footer' : '提交'
        };
        auto_dialog(_config);
//       $('[name="audit"]').click(function(){
            // $('#audit_modal').modal();
 //       });

});


