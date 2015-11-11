
<div class="page-content">
    <div class="page-content-area">
        <div class="row">

            <div class="col-xs-12">
            <div><h4 class='blue' >待导入总人数:<em data-nums = "<?php echo count($members);?>" id="all_count"><?php echo count($members);?></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已导入人数:<em id='insert_count'>0</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未导入人数:<em id='uninsert_count'><?php echo count($members);?></em> </h4></div> 
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
                                    <th>默认审批人ID</th>
                                    <th>默认审批人姓名</th>
                                    <th>默认审批人Email</th>
                                    <th>级别</th>
                                    <th>职位</th>
                                    <th>一级审批</th>
                                    <th>二级审批</th>
                                    <th>三级审批</th>
                                    <th>四级审批</th>
                                    <th>五级审批</th>
                                    <th>状态</th>
                                    <th>错误信息</th>
                                </tr>
                                <?php foreach($members as $d){ ?>
                                <tr class="member"  data-id="<?php echo $d['status'];?>" >
                                   
                                    <td>
                                        <input type="hidden" data-id="m_<?php echo md5($d['email']); ?>" data-exist="<?php echo $d['status']; ?>"  class="data-maintainer " value="<?php echo base64_encode(json_encode($d)); ?>" data-value="<?php echo base64_encode(json_encode($d)); ?>" data-manager="<?php echo $d['manager_email']?>" data-uid="<?php echo $d['id']?>">
                                       
                                         <?php echo $d['id'];?></td>
                                    <td><?php echo $d['name']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['phone']; ?></td>
                                    <!--<td><?php echo $d['accounts']; ?></td> -->
                                    <td><?php echo $d['cardno']; ?></td>
                                    <td><?php echo $d['cardbank']; ?></td>
                                    <!--<td><?php echo $d['cardloc']; ?></td> -->
                                    <td><?php echo $d['group_name'];?></td>
                                    <td><?php echo $d['display_manager_id'];?></td>
                                    <td><?php echo $d['display_manager'];?></td>
                                    <td><?php echo $d['display_manager_email'];?></td>
                                    <td><?php echo $d['rank'];?></td>
                                    <td><?php echo $d['level'];?></td>
                                    <td><?php echo $d['manager_email'];?></td>
                                    <td><?php echo $d['second'];?></td>
                                    <td><?php echo $d['third'];?></td>
                                    <td><?php echo $d['fourth'];?></td>
                                    <td><?php echo $d['fifth'];?></td>
                                    <td>
                                        <!-- <a alt="<?php echo $d['status'] == 1 ? '已经是同一个公司的同事' : '还不是一个公司的同事'; ?>"><i id="m_<?php echo md5($d['email']); ?>"   -->
                                        <a alt=""><i
                                            data-value="<?php echo base64_encode(json_encode($d)); ?>" data-manager="<?php echo $d['manager_email']?>" data-status="<?php echo $d['status'];?>" data-uid="<?php echo $d['id']?>"  data-id="<?php echo $d['id'];?>"  class="<?php echo $d['status']&1 == 1 ? 'green' : 'red' ; ?> menu-icon fa judge"><?php echo $d['status']&1 == 1?'已导入(更新数据)' : '未导入';?></i><span class="red" id="<?php echo 'error_'.$d['id']; ?>"></span></a>

                                    </td>
                                    <td class="red"><?php 
                                        if($d['status']&4)
                                        {
                                            echo '员工默认审批人信息缺失或有误，导入后将无默认审批人信息。';
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
                                <button class="btn btn-info" type="button" id="save_with_mail">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    导入并发送邮件
                                </button>
                                 <button class="btn btn-info" type="button" id="save_without_mail">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    导入不发送邮件
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
    
    var all_count = $('#all_count').data('nums');

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


    function make_invite(){
        $('.data-maintainer').each(function(idx, val){
            var _status = $(this).data('exist');
            if(1 == _status) {
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
function travel(is_mail)
{
    is_quiet_mail = is_mail;
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
        $.ajax({
            url : __BASE  + "members/imports_create_group"
                    ,method: 'POST'
                    ,dataType: 'json'
                    ,data : {'name' : no_groups[i]}
                    ,success : function(data){
                       count_groups--;
                       if(count_groups == 0)
                       {
                       // $('#' + __id).removeClass('fa-times red').addClass('fa-check green');
                       
                        show_notify('部门创建成功');
                        sum-=1;
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
    // 提交所有的员工

   

}

function insertMem()
{
    var insert_count_globle = 0;
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
                ,data : {'member' : load_mem,'quiet':is_quiet_mail}
                ,success : function(data){
                    /*var back_info = data['data'];
                            $('.judge').each(function(){
                                var _id = $(this).data('id');
                                if(back_info[_id] != undefined)
                                {
                                    $(this).removeClass('fa-times red').addClass('fa-check green');
                                }
                            });
                        show_notify('员工创建成功');*/
                         insert_count++;
                         
                        var back_info = data['data'];

                        if(back_info.status>0)
                        {
                          
                          for(var p in back_info['data'])
                          {
                           //var back_id = back_info['data'][uid];
                           if(back_info['data'][p]['status'] <= 0)
                           {
                               // $(this).removeClass('fa-times red').addClass('fa-check green');
                               myself.text(back_info['data'][p]['status_text']);
                           }
                           
                            if((back_info['data'][p]['status'])>0)
                            {

                                  if(manager_name)
                                  {
                                        var person = {'id':back_info['data'][p]['uid'],'manager':manager_name};
                                        in_members.push(person);
                                    }
                                  myself.removeClass('red').addClass('green');
                                  insert_count_globle++;
                                  
                                  $('#insert_count').text(insert_count_globle);
                                  $('#uninsert_count').text((all_count - insert_count_globle));
                                  if(_status&1 == 1)
                                  {
                                    myself.text('已更新');
                                    }
                                    else
                                    {
                                        myself.text('已导入');
                                    }
                                  //$('#error_'+uid).html('导入成功');
                                  
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
                                if(old_insert == insert_count)
                                {
                                    set_manager(in_members);
                                }
                            },3000);
                        }

                    
                }
            ,error:function(a,b,c)
                    {
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
                $('#save').prop('disabled',false);
                show_notify('导入完成');
          }
          ,error:function(a,b,c)
          {
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
    var is_quiet_mail = 0;
    $('#save_with_mail').click(function(){
        travel(0);
    });
    $('#save_without_mail').click(function(){
        travel(1);
    });
    //$('#resave').click(make_invite);
});
</script>
