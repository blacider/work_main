
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
                                    <th>类目</th>
                                    <th>导入提示语</th>
                                </tr>
                                <?php foreach($sobs as $d){ ?>
                                <tr >
                                   
                                    <td><?php echo $d['id'];?></td>
                                    <td><?php echo $d['name']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['str_desc']; ?></td>

                                    <td>
                                       
                                        <i class='red'>未导入</i>

                                    </td>
                                
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                       
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="excute_batch_del">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    导入
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
var sob_info = "<?php echo josn_encode($sob_info);?>";
console.log(sob_info);
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
			    if (del_back[item]['status_code'] == 1) {
				$('i[id="' + del_back[item]['email'] + '"]').text('员工不在本公司');
			    } else if (del_back[item]['status_code'] == 2) {
				$('i[id="' + del_back[item]['email'] + '"]').text('员工信息错误');
			    } else {
				$('i[id="' + del_back[item]['email'] + '"]').text('未知错误');
			    }
                        }
                    }

                },
                error:function(a,b,c){
                
                }
            });
        }




</script>