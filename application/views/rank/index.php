<div class="main-content">

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                     <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>职位名称</th>
                          <th>最后修改时间</th>
                          <th class="hidden-680">
                            <a href="#modal-table2" role="button" class="green" data-toggle="modal">
                              <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                            </a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
//echo json_encode($acc_sets);

                        foreach($ranks as $item){
                          $img = "";
                          $str = '<tr>';
                          $username = '<td class="u_username">' . $item['name'] . '</td>';
                          $role_id =  '<td class="u_role_name">' .  $item['lastdt'] . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
                          $operation_upd = '<td style="width:80px;">   <a href="#modal-table4" data-toggle="modal" class="redit"  data-name="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>  <a href="javascript:void(0);" class="del" data-rank="1" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
                          $operation = '<td style="width:80px;"><a class="btn btn-xs btn-danger" href="' .  base_url('category/remove_sob/?id='. $item['id']) .'">
                          <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </a></td>';
                        $str = $str . $username . $role_id . $operation_upd . '</tr>';
                        echo $str;

                      }?>
                    </tbody>
                  </table>


                  <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>级别名称</th>
                        <th>最后修改时间</th>
                        <th class="hidden-680">
                          <a href="#modal-table1" role="button" class="green" data-toggle="modal">
                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                          </a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
//echo json_encode($acc_sets);

                      foreach($levels as $item){
                        $img = "";
                        $str = '<tr>';
                        $username = '<td class="u_username">' . $item['name'] . '</td>';
                        $role_id =  '<td class="u_role_name">' .  $item['lastdt'] . '</td>';
    //$role_id = '<td class="u_role_name">' . $item->role_name . '</td>';
                        $operation_upd = '<td style="width:80px;">   <a href="#modal-table3" data-toggle="modal" class="ledit"  data-name="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>  <a href="javascript:void(0);" class="del" data-rank="0" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
                        $operation = '<td style="width:80px;"><a class="btn btn-xs btn-danger" href="' .  base_url('category/remove_sob/?id='. $item['id']) .'">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                      </a></td>';
                      $str = $str . $username . $role_id . $operation_upd . '</tr>';
                      echo $str;

                    }?>
                  </tbody>
                </table>


        

</div><!-- /.span -->
</div><!-- /.row -->


</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->

<div id="modal-table1" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('members/create_rank_level/0')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 新建级别 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">输入级别名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="name" name="name" class="form-control" />
                      </div>
                  </div>   
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="新建" />
         </div>
        </div>
        </form>
  </div>
</div><!-- PAGE CONTENT ENDS -->


<div id="modal-table2" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('members/create_rank_level/1')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 新建职位 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">输入职位名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="name" name="name" class="form-control" />
                      </div>
                  </div>   
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="新建" />
         </div>
        </div>
        </form>
  </div>
</div><!-- PAGE CONTENT ENDS -->

<div id="modal-table3" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('members/update_rank_level/0')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 修改级别 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">级别名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="level_name" name="name" class="form-control" />
                      </div>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="hidden" id="level_id" name="rank_level_id" class="form-control" />
                      </div>
                  </div>   
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="修改" />
         </div>
        </div>
        </form>
  </div>
</div><!-- PAGE CONTENT ENDS -->

<div id="modal-table4" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('members/update_rank_level/1')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 修改职位 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">职位名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="rank_name" name="name" class="form-control" />
                      </div>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="hidden" id="rank_id" name="rank_level_id" class="form-control" />
                      </div>
                  </div>   
                </div>    <!-- row -->
              </div>    <!-- col-xs-12 -->
           </div> <!--- container -->
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="修改" />
         </div>
        </div>
        </form>
  </div>
</div><!-- PAGE CONTENT ENDS -->
<script language="javascript">
var __BASEURL = "<?php echo $base_url; ?>";
var error = "<?php echo $error; ?> ";
$(document).ready(function(){
    if(error.trim())
    {
        show_notify(error);
    }

    $('#send').click(function(){
        /*
    $.ajax({
      url:__BASE+'category/copy_sob'
      ,method:"post"
      ,dataType:"json"
      ,data:{sob_id:$('#sob_id').val(),cp_name:$('#cp_name').val()}
      ,success:function(data){
          if(data.status== 1) {
            $('#modal-table1').modal('hide')
            show_notify("复制成功");
          }
          else
          {
              if(data.data.msg != undefined) {
                show_notify(data.data.msg);
              }
              else {
                show_notify("输入邮箱错误");
              }
          }
      }
    }); */
});

    $('.redit').each(function(idx, item){
        $(item).click(function(){
		
            var _id = $(this).data('id');
	    var _name =$(this).data('name');
	    $('#rank_id').val(_id);
	    $('#rank_name').val(_name);
        });
    });
    $('.ledit').each(function(idx, item){
        $(item).click(function(){
		
            var _id = $(this).data('id');
	    var _name =$(this).data('name');
	    $('#level_id').val(_id);
	    $('#level_name').val(_name);
        });
    });
    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
	    	var _rank = $(this).data('rank');
                var _id = $(this).data('id');
                location.href = __BASEURL + "members/del_rank_level/" + _rank + "/"  + _id;
            }
        });
    });


    $('.copy').each(function(){
        $(this).click(function(){
            
                var _id = $(this).data('id');
                $('#sob_id').val(_id)
        });
    });
    $('.delno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许删除')){
              
            }
        });
    });
    $('.copyno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许复制')){
              
            }
        });
    });

      $('.editno').each(function(){
        $(this).click(function(){
            if(confirm('默认帐套不允许修改')){
              
            }
        });
    });

});
</script>
