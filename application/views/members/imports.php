
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
                                    <th>开户名</th>
                                    <th>银行卡号</th>
                                    <th>开户行</th>
                                    <th>开户地</th>
                                    <th>部门</th>
                                    <th>上级姓名</th>
                                    <th>职级</th>
                                    <th>职位</th>
                                    <th>状态</th>
                                </tr>
                                <?php foreach($members as $d){ ?>
                                <tr class="member"  data-id="<?php echo $d['status'];?>">
                                   
                                    <td>
                                        <input type="hidden" data-id="m_<?php echo md5($d['email']); ?>" data-exist="<?php echo $d['status']; ?>"  class="data-maintainer " value="<?php echo base64_encode(json_encode($d)); ?>">
                                         <?php echo $d['id'];?></td>
                                    <td><?php echo $d['name']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['phone']; ?></td>
                                    <td><?php echo $d['accounts']; ?></td>
                                    <td><?php echo $d['cardno']; ?></td>
                                    <td><?php echo $d['cardbank']; ?></td>
                                    <td><?php echo $d['cardloc']; ?></td>
                                    <td><?php echo $d['group_name'];?></td>
                                    <td><?php echo $d['manager'];?></td>
                                    <td><?php echo $d['rank'];?></td>
                                    <td><?php echo $d['level'];?></td>
                                    <td>
                                        <a alt="<?php echo $d['status'] == 1 ? '已经是同一个公司的同事' : '还不是一个公司的同事'; ?>"><i id="m_<?php echo md5($d['email']); ?>"   
                                                class="<?php echo $d['status'] == 1 ? 'green fa-check' : 'fa-times red' ; ?> menu-icon fa "></i></a>
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
    function make_invite(){
        $('.data-maintainer').each(function(idx, val){
            var _status = $(this).data('exist');
            if(1 == _status) {
                console.log('skip');
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
            });
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
        else if((_id&4) == 1)
        {
            $(this).addClass('success');
        }
    });
    $('#save').click(make_invite);
    $('#resave').click(make_invite);
});
</script>
