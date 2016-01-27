
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
             <div><h4 class='blue' >待导入数据<em data-nums = "<?php echo count($sobs);?>" id="all_count"><?php echo count($sobs);?></em>条&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已导入数据<em id='insert_count'>0</em>条&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未导入数据<em id='uninsert_count'><?php echo count($sobs);?></em>条 </h4></div> 
                <div class="panel panel-primary">
                    <form role="form" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform">
                        <div class="form-contorller">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>邮箱</th>
                                    <th>手机</th>
                                    <th>类目</th>
                                    <th>导入提示语</th>
                                </tr>
                                <?php foreach($sobs as $d){ ?>
                                <tr >
                                   
                                    <td><?php echo $d['id'];?></td>
                                    <td><?php echo $d['name']; ?></td>
                                    <td><?php echo $d['email']; ?></td>
                                    <td><?php echo $d['phone'];?></td>
                                    <td><?php echo $d['str_desc']; ?></td>
                                    <td class="<?php echo $d['sob_hash']; ?>  <?php echo $d['sob_id']; ?>" data-hash="<?php echo trim($d['email']); ?>">
<?php if($d['sob_id'] == -1){ ?>
                                        <i class='red backinfo'>未导入</i>
<?php } else { ?>
<i class='backinfo'><?php echo $d['sob_name']; ?></i>
<?php } ?>
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
                                <button class="btn btn-info" type="button" id="end_sob" style="display:none;">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    导入完成
                                </button>
                              

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php 
foreach($sob_exists as $h => $s){
?>
    <input type="hidden" class="exist_sob" value="<?php echo $s; ?>" data-hash="<?php echo $h; ?>" />
<?php } ?>
<?php 
foreach($sob_info as $h => $s){
?>
    <input type="hidden" class="new_sob" value="<?php echo $s; ?>" data-hash="<?php echo $h; ?>" />
<?php } ?>
<script type="text/javascript">
var __BASE = "<?php echo $base_url;?>";
//var _sob_info = '<?php echo json_encode($sob_info);?>';
var sob_info = [];
var insert_count = 0;
var all_count = $('#all_count').data('nums');
    $(document).ready(function(){
        $('#imports_sob').click(function(){
            $('.exist_sob').each(function(idx, item){
                var info = $(this).val();
                var _hash = $(this).data('hash');
                $.ajax({
                    url:__BASE + 'category/batch_update_account',
                    method:"POST",
                    dataType: 'json',
                    data:{'sob':info, 'id' : _hash},
                    success:function(d){
                        try{
                            if(d['status'] > 0) {
                                _emails = d['data']['emails'];
                                $('.' + _hash).each(function(){
                                    var _e = $(this).data('hash');
                                    if($.inArray(_e, _emails) > -1) {
                                        $(this).removeClass('green').addClass('red').text('导入出错');
                                    } else{
                                        $(this).removeClass('red').addClass('green').text('已导入');
                                        insert_count++;
                                        $('#insert_count').text(insert_count);
                                        $('#uninsert_count').text(all_count - insert_count);
                                    }
                                });
                            } else {
                                show_notify("导入失败");
                            }
                        }catch(e){
                        }
                    },
                    error:function(a,b,c){
                    }
                });
            });

            $('.new_sob').each(function(idx, item){
                var info = $(this).val();
                var _hash = $(this).data('hash');
                $.ajax({
                    url:__BASE + 'category/batch_create_account',
                    dataType: 'json',
                    method:"POST",
                    data:{'sob':info},
                    success:function(d){
                        try{
                            if(d['status'] > 0) {
                                _emails = d['data']['emails'];
                                $('.' + _hash).each(function(){
                                    var _e = $(this).data('hash');
                                    if($.inArray(_e, _emails) > -1) {
                                        $(this).removeClass('green').addClass('red').text('用户不存在');
                                    } else{
                                        $(this).removeClass('red').addClass('green').text('已导入');
                                        insert_count++;
                                        $('#insert_count').text(insert_count);
                                        $('#uninsert_count').text(all_count - insert_count);
                                    }
                                });
                            } else {
                                show_notify("导入失败");
                            }
                        }catch(e){
                        }
                    },
                    error:function(a,b,c){
                    }
                });
            });
            $('#imports_sob').hide();
            $('#end_sob').click(function(){
                location.href= __BASE + "category/cexport";
                //history.go(-1);
            });
            $('#end_sob').show();
        });

    });

</script>
