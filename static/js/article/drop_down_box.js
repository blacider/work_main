$(document).ready(function(){
   var group={};
   var _last  = '';
   var url = __BASEURL;
   $.getJSON(__BASEURL+ "/api/article/get_group/" + __TOP_GID,function(data){
       $.each(data,function(k,item){
            var _i = item.id;
            if(!group[_i]){
                group[_i] = []
            group[_i]['children'] = []
            }
            (group[_i]).push(item); // = item.name;
            if(group[item['pid']]){
                (group[item['pid']]['children']).push(item);
            }
            //if(item['pid'] == 0 || item['pid'] == __TOP_GID){
                $("#g").append( "<option value="+ item.id +">"+ item.name +" </option>");
            //}
        });
        if(__ARTICLE_GROUP_ID !== -1){
            $('#g').val(__ARTICLE_GROUP_ID);
            $('#g').attr('readonly', 'readonly');
        }

    });
 
   function show_filter(group_id){
       if(group_id!=-1) {
        $.getJSON(url+"/api/article/list_group_by_id/"+group_id,function(data){
            if(data.picture == 0) {
                $("#picture").hide();} else { 
                    if(data.article_tip){
                    $('#imgtips').html('上传图片([' + data.article_tip + "]):");
                        } else {
                    $('#imgtips').html('上传图片:');
                        }
                    $("#picture").show();
                } 
            if(data.file == 0) $("#f").hide();else $("#f").show();
            if(data.video == 0) $("#v").hide();else $("#v").show();
        });
       }else{
            $("#picture,#f,#v").hide();
       }
    }

    function make_option(gid){
        $('#' + _last).remove();
        _last = 'p_' + gid;
        if(group[gid]){
            if((group[gid]['children']).length == 0) return;
            _id = 'p_' + gid
                $("#a").append("<select id='" + _id + "'><option val='-1'>请选择</option>");
            $.each($(group[gid]['children']), function(idx, item){
                $("#" + _id).append("<option value="+item.id+">" + item.name+"</option>");
            });
        }
        $('#' + gid).change(make_change_event);
    }
    function make_change_event(){
        gid = $(this).find("option:selected").val();
        make_option(gid);
    }

    $("#g").change(function(){
        $("#p,#r").remove();
        gid = $("#g").find("option:selected").val();
        show_filter(gid);
        make_option(gid);
    });
});


