
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
                                    <th>职级</th>
                                    <th>职位</th>
                                    <th>状态</th>
                                </tr>
                                <?php foreach($members as $d){ ?>
                                <tr class="member"  data-id="<?php echo $d['status'];?>" >
                                   
                                    <td>
                                        <input type="hidden" data-id="m_<?php echo md5($d['email']); ?>" data-exist="<?php echo $d['status']; ?>"  class="data-maintainer " value="<?php echo base64_encode(json_encode($d)); ?>" data-value="<?php echo base64_encode(json_encode($d)); ?>">
                                       
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
                                        <a alt="<?php echo $d['status'] == 1 ? '已经是同一个公司的同事' : '还不是一个公司的同事'; ?>"><i id="m_<?php echo md5($d['email']); ?>"   
                                              data-id="<?php echo $d['id'];?>"  class="<?php echo $d['status'] == 1 ? 'green fa-check' : 'fa-times red' ; ?> menu-icon fa judge"></i></a>
                                    </td>
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
    var no_ranks = '';
    if(_no_ranks)
    { no_ranks = JSON.parse(_no_ranks);}

    var no_levels = '';
    if(_no_levels)
    { no_levels = JSON.parse(_no_levels);}

    var no_groups = '';
    if(_no_groups)
    { no_groups = JSON.parse(_no_groups);}

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
     var members = new Array();

    $('.data-maintainer').each(function(idx, item) {
        var v = $(item).data('value');
        members.push(v);
    });
        $.ajax({
            url : __BASE  + "members/batch_load"
                ,method: 'POST'
                ,dataType: 'json'
                ,data : {'member' : members}
                ,success : function(data){
                    var back_info = data['data'];
                            $('.judge').each(function(){
                                //console.log($(this).data('id'));
                                var _id = $(this).data('id');
                                if(back_info[_id] != undefined)
                                {
                                    $(this).removeClass('fa-times red').addClass('fa-check green');
                                }
                            });
                        show_notify('员工创建成功');
                    
                }
            ,error:function(a,b,c)
                    {
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
