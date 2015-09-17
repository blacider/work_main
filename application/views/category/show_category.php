
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
                                       
                                        <i class='red backinfo'>未导入</i>

                                    </td>
                                
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                       
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="imports_sob">
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
var _sob_info = '<?php echo json_encode($sob_info);?>';
var sob_info = [];
var sum = 0;
if(_sob_info)
{
    sob_info = JSON.parse(_sob_info);
}
for(var i in sob_info)
{
    sum += sob_info[i]['cates'].length;
}

    $(document).ready(function(){
        $('#imports_sob').click(function(){
            for(var idx in sob_info)
            {
                console.log(idx);
                console.log(sob_info[idx]['uids']);
             (function(idx)
             {
                $.ajax({
                    url:__BASE + 'category/batch_create_account',
                    method:"POST",
                    data:{'sobname':idx,'uids':sob_info[idx]['uids']},
                    success:function(d){
                        var data = JSON.parse(d);

                        console.log(data);
                        for(var c_idx in sob_info[idx]['cates'])
                        {
                            create_category(data['sob_id'],sob_info[idx]['cates'][c_idx]);
                        }
                    },
                    error:function(a,b,c){
                        console.log(a);
                        console.log(b);
                        console.log(c);
                    }
                });
            })(idx);

            }
        });

    });

function create_category(sid,cate)
{
    $.ajax({
        url:__BASE + 'category/batch_create_category',
        method:"POST",
        data:{'sid':sid,'cate':cate},
        success:function(data){
            sum--;
            console.log(sum);
            if(sum == 0)
            {
                $('.backinfo').each(function(idx,item){
                    $(this).removeClass('red').addClass('green').text('已导入');
                });
                show_notify('导入完成');
            }
        },
        error:function(a,b,c){
            console.log(a);
            console.log(b);
            console.log(c);
        }
    });
}




</script>