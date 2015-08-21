
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <form role="form" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                        <div class="form-contorller">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>邮箱</th>
                                    <th>手机</th>
                                   <!-- <th>开户名</th> -->
                                    <th>银行卡号</th>
                                    <th>开户行</th>
                                 <!--   <th>开户地</th> -->
                                    <th>部门</th>
                                    <th>上级姓名</th>
                                    <th>级别</th>
                                    <th>职位</th>
                                    <th>状态</th>
                                    <th>错误信息</th>
                                </tr>
                                <?php foreach($members as $d){ ?>
                                <tr class="member"  data-id="<?php echo $d['status'];?>" >
                                   
                                    <td>
                                        <input type="hidden" data-id="m_<?php echo md5($d['email']); ?>" data-exist="<?php echo $d['status']; ?>"  class="data-maintainer " value="<?php echo base64_encode(json_encode($d)); ?>" data-value="<?php echo base64_encode(json_encode($d)); ?>" data-manager="<?php echo $d['manager']?>" data-uid="<?php echo $d['id']?>">
                                       
                                         <?php echo $d['id'];?></td>
                                    <td><?php echo $d['name']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['phone']; ?></td>
                                    <!--<td><?php echo $d['accounts']; ?></td> -->
                                    <td><?php echo $d['cardno']; ?></td>
                                    <td><?php echo $d['cardbank']; ?></td>
                                    <!--<td><?php echo $d['cardloc']; ?></td> -->
                                    <td><?php echo $d['group_name'];?></td>
                                    <td><?php echo $d['manager'];?></td>
                                    <td><?php echo $d['rank'];?></td>
                                    <td><?php echo $d['level'];?></td>
                                    <td>
                                        <!-- <a alt="<?php echo $d['status'] == 1 ? '已经是同一个公司的同事' : '还不是一个公司的同事'; ?>"><i id="m_<?php echo md5($d['email']); ?>"   -->
                                        <a alt=""><i
                                            data-value="<?php echo base64_encode(json_encode($d)); ?>" data-manager="<?php echo $d['manager']?>" data-status="<?php echo $d['status'];?>" data-uid="<?php echo $d['id']?>"  data-id="<?php echo $d['id'];?>"  class="<?php echo $d['status']&1 == 1 ? 'green' : 'red' ; ?> menu-icon fa judge"><?php echo $d['status']&1 == 1?'已导入(更新数据)' : '未导入';?></i><span class="red" id="<?php echo 'error_'.$d['id']; ?>"></span></a>

                                    </td>
                                    <td class="red"><?php 
                                        if($d['status']&4)
                                        {
                                            echo '上级重复或者不存在';
                                        }
                                        else if($d['status']&2)
                                        {
                                            echo '名字重复';
                                        }

                                    ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="save">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    保存
                                </button>

                            </div>

                           <!--  <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="set_manager">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    设置上级
                                </button>

                            </div>
                            -->
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<script language="javascript">
    var __BASE = "<?php echo base_url(); ?>";
    var _no_ranks = '<?php echo json_encode($no_ranks)?>';
    var _no_levels = '<?php echo json_encode($no_levels)?>';
    var _no_groups = '<?php echo json_encode($no_groups)?>';
    var _members = '<?php echo json_encode($members)?>';

    var no_ranks = '';
    if(_no_ranks)
    { no_ranks = JSON.parse(_no_ranks);}

    var no_levels = '';
    if(_no_levels)
    { no_levels = JSON.parse(_no_levels);}

    var no_groups = '';
    if(_no_groups)
    { no_groups = JSON.parse(_no_groups);}

    var members = '';
    if(_members)
    { members = JSON.parse(_members);}

    var members_count = 0;
    if(members)
    {
        members_count = members.length;
    }

    console.log('memebers_count:' + members_count);
  //  console.log(no_ranks);
   // console.log(no_levels);
    //console.log(no_groups);
    function make_invite(){
        $('.data-maintainer').each(function(idx, val){
            var _status = $(this).data('exist');
            if(1 == _status) {
             //   console.log('skip');
                return;
            }
            var _member = $(this).val();
            var _id = $(this).data('id');
            $.ajax({
                url : __BASE  + "members/import_single"
                    ,method: 'POST'
                    ,dataType: 'json'
                    ,data : {'member' : _member, 'id' : _id}
                    ,success : function(data){
                        if(data.status) {
                            var __id = data.id;
                          
                            $('#' + __id).removeClass('fa-times red').addClass('fa-check green');
                        } else {
                            var __id = data.id;
                            $('#' + __id).innerHTML(data.msg);
                        }
                    }
                    ,error:function(a,b,c)
                    {

                    }
            });
            
        });
 
    }
function travel()
{
    $('#save').prop("disabled",true);
    var sum = 0;
    if((no_ranks.length == 0)&&(no_levels.length == 0)&&(no_groups.length==0) )
    {
        insertMem();
    }
    if(no_ranks.length != 0)
    {
        sum+=1;
    }
    if(no_levels.length != 0)
    {
        sum+=1;
    }
    if(no_groups.length != 0)
    {
        sum+=1;
    }
    for(var i=0;i<no_ranks.length;i++)
    {
        var count_ranks = no_ranks.length;
      //  console.log('count_ranks:' + count_ranks);
        $.ajax({
            url : __BASE  + "members/imports_create_rank_level/1"
                    ,method: 'POST'
                    ,dataType: 'json'
                    ,data : {'name' : no_ranks[i]}
                    ,success : function(data){
                       count_ranks--;
                       if(count_ranks == 0)
                       {
                        show_notify('职位创建成功');
                        sum-=1;
                    //    console.log('sum:'+sum);
                        if(sum == 0)
                        {
                            insertMem();
                        }
                       }
                    }
                    ,error:function(a,b,c)
                    {

                    }
        });
    }

    for(var i=0;i<no_levels.length;i++)
    {
        var count_level = no_levels.length;
       // console.log('count_level:' + count_level);
        $.ajax({
            url : __BASE  + "members/imports_create_rank_level/0"
                    ,method: 'POST'
                    ,dataType: 'json'
                    ,data : {'name' : no_levels[i]}
                    ,success : function(data){
                       count_level--;
                       if(count_level == 0)
                       {
                     
                        show_notify('级别创建成功');
                        sum-=1;
                  //      console.log('sum:'+sum);
                   
                          if(sum == 0)
                        {
                            insertMem();
                        }
                       }
                    }
                    ,error:function(a,b,c)
                    {

                    }
        });
    }


    for(var i=0;i<no_groups.length;i++)
    {
        var count_groups = no_groups.length;
      //  console.log(count_groups);
        $.ajax({
            url : __BASE  + "members/imports_create_group"
                    ,method: 'POST'
                    ,dataType: 'json'
                    ,data : {'name' : no_groups[i]}
                    ,success : function(data){
                        console.log(data.msg);
                       count_groups--;
                       if(count_groups == 0)
                       {
                       // $('#' + __id).removeClass('fa-times red').addClass('fa-check green');
                       
                        show_notify('部门创建成功');
                        sum-=1;
                    //     console.log('sum:'+sum);
                          if(sum == 0)
                        {
                            insertMem();
                        }
                       }
                    }
                    ,error:function(a,b,c)
                    {
              //          console.log(a);
              //          console.log(b);
                    }
        });
    }
    // 提交所有的员工

   

}

function insertMem()
{
     var in_members = new Array();
     var insert_count = 0;
    $('.judge').each(function(idx, item) {
        var load_mem = new Array();
        var v = $(item).data('value');
          var manager_name = $(this).data('manager');
        var uid = $(this).data('uid');
        var _status = $(this).data('status');
        var myself = $(this);
       // members.push(v);
       load_mem.push(v);
       
   
        $.ajax({
            url : __BASE  + "members/batch_load"
                ,method: 'POST'
                ,dataType: 'json'
                ,data : {'member' : load_mem}
                ,success : function(data){
                    /*var back_info = data['data'];
                            $('.judge').each(function(){
                                //console.log($(this).data('id'));
                                var _id = $(this).data('id');
                                if(back_info[_id] != undefined)
                                {
                                    $(this).removeClass('fa-times red').addClass('fa-check green');
                                }
                            });
                        show_notify('员工创建成功');*/
                         insert_count++;
                        var back_info = data['data'];

                       // console.log(data);
                        if(back_info.status>0)
                        {
                          
                         //   console.log('uid:' + uid);
                          //  console.log('manager_name:' + manager_name);
                          for(var p in back_info['data'])
                          {
                           //var back_id = back_info['data'][uid];
                           if(back_info['data'][p] < 0)
                           {
                               // $(this).removeClass('fa-times red').addClass('fa-check green');
                               myself.text('导入出错');
                           }
                           
                            if((back_info['data'][p])>0)
                            {

                                  if(manager_name)
                                  {
                                        var person = {'id':back_info['data'][p],'manager':manager_name};
                                        in_members.push(person);
                                    }
                                  
                                  myself.removeClass('red').addClass('green');
                                  console.log("heloo");
                                  if(_status&1 == 1)
                                  {
                                    myself.text('已更新');
                                    }
                                    else
                                    {
                                        myself.text('已导入');
                                    }
                                  //$('#error_'+uid).html('导入成功');
                                 // console.log($('#error_'+uid).val());
                                  
                            }
                            }
                        }
                       
                        if(insert_count == members_count)
                        {
                            set_manager(in_members);
                        }
                        else
                        {
                            var old_insert = insert_count;
                            setTimeout(function(){
                              //  console.log(old_insert);
                               // console.log(insert_count);
                                if(old_insert == insert_count)
                                {
                                    set_manager(in_members);
                                }
                            },3000);
                        }

                    
                }
            ,error:function(a,b,c)
                    {
                       // console.log(a);
                       // console.log(b);
                    }
        });
    });
}


function set_manager(persons)
{
    $.ajax({
          url : __BASE  + "members/set_managers"
          ,method: 'POST'
          ,dataType: 'json'
          ,data : {'persons' : JSON.stringify(persons)}
          ,success : function(data){
            console.log("success");
                $('#save').prop('disabled',false);
                show_notify('导入完成');
          }
          ,error:function(a,b,c)
          {
                console.log(a);
                console.log(b);
                       // console.log(a);
                       // console.log(b);
          }
    });
}

   
$(document).ready(function(){
    $('.member').each(function(idx,val){
        var _id = $(this).data('id');
        
        if((_id&4) == 4)
        {
            $(this).addClass('danger');
        }
        else if((_id&2) == 2)
        {
            $(this).addClass('warning');
        }
        else if((_id&1) == 1)
        {
            $(this).addClass('success');
        }
    });
    $('#save').click(travel);
    $('#resave').click(make_invite);
});
</script>
