
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
                                    <th>状态</th>
                                </tr>
                                <?php foreach($members as $d){ ?>
                                <tr >
                                   
                                    <td>
                                    <?php
                                        $member = array();
                                        array_push($member,$d);
                                    ?>
                                        <input type="hidden" data-id="m_<?php echo md5($d['email']); ?>"  class="data-maintainer" value="<?php echo base64_encode(json_encode($member)); ?>" data-value="<?php echo base64_encode(json_encode($d)); ?>" data-uid="<?php echo $d['id']?>">
                                    
                                         <?php echo $d['id'];?></td>
                                    <td><?php echo $d['nickname']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['phone']; ?></td>

                                    <td>
                                       
                                        <i id="<?php echo $d['email']?>" class='red'>未删除</i>

                                    </td>
                                
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <input type="hidden" id="all_members" value="<?php echo base64_encode(json_encode($members)); ?>">
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="excute_batch_del">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    删除
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
<script type="text/javascript">
var __BASE = "<?php echo $base_url;?>";
    $(document).ready(function(){
        $('#excute_batch_del').click(function(){
            $('.data-maintainer').each(function(idx,item){
                var member = $(this).val();
                make_del(member);
            });
           // make_invite();
        });

    });

    function make_del(members)
        {
            $.ajax({
                url:__BASE + 'members/excute_batch_del',
                method:"POST",
                data:{'members':members},
                success:function(data){
                    var del_back = [];
                    if(data)
                    {
                        del_back = JSON.parse(data);
                    }
                    for(var item in del_back)
                    {
                        if(del_back[item]['status'])
                        {
                            $('i[id="' + del_back[item]['email'] + '"]').removeClass('red').addClass('green').text('已删除');
                        }
                       else
                        {
                              $('i[id="' + del_back[item]['email'] + '"]').removeClass('red').text('员工不在本公司');
                        }
                    }

                },
                error:function(a,b,c){
                
                }
            });
        }




</script>