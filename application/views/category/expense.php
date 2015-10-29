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
                          <th>ID</th>
                          <th>组名</th>
                          <th class="hidden-680">
                            <a href="#modal-table2" role="button" class="green" data-toggle="modal">
                              <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                            </a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                    

                      <?php
                        foreach($projects as $key => $pro)
                        {
                          if(array_key_exists('project_type', $pro) && $pro['project_type']!=0 && $pro['project_type']!=1)
                          {
                      ?>
                      <tr>
                        <td><?php echo $key;?></td>
                        <td><?php echo $pro['name'];?></td>
                        <td style="width:80px;">   <a href="#" data-toggle="modal" class="edit"  data-name="" data-id="<?php echo $pro['id'];?>"><span class="ace fa fa-search-plus"></span></a> <a href="#modal-table3" data-toggle="modal" class="edit_pro"  data-name="<?php echo $pro['name']?>" data-id="<?php echo $pro['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a>  <a href="javascript:void(0);" class="del red" data-rank="1" data-id="<?php echo $pro['id'];?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                      </tr>
                      <?php
                          }
                          else
                          {
                      ?>

                       <tr>
                        <td><?php echo $key;?></td>
                        <td><?php echo $pro['name'];?></td>
                        <td style="width:80px;">   <a href="#" data-toggle="modal" class="edit"  data-name="" data-id="<?php echo $pro['id'];?>"><span class="ace fa fa-search-plus"></span></a> </td>
                      </tr>
                      <?php
                          }
                        }
                      ?>
                      

                    </tbody>
                  </table>


        

</div><!-- /.span -->
</div><!-- /.row -->


</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->




<div id="modal-table2" class="modal" tabindex="-1">
  <div class="modal-dialog">
        <form action="<?php echo base_url('category/create_expense')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 新建组 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">输入组名称:</label>
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
        <form action="<?php echo base_url('category/update_fee_afford_project')?>" method='post'>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger"> 修改组名 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">组名称:</label>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="text" id="pro_name" name="pro_name" class="form-control" />
                      </div>
                      <div>
                        <input class="col-xs-4 col-sm-4" type="hidden" id="pro_id" name="pro_id" class="form-control" value="-1" />
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
            <h4 class="blue bigger"> 修改级别 </h4>
          </div>
         <div class="modal-body">
           <div class="container">

              <div class="col-xs-12 col-sm-12">
                <div class="row">
                  <div class="form-group">
                      <label for="form-field-username">级别名称:</label>
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
<script type="text/javascript">
  var __BASE = "<?php echo $base_url;?>";
  var __ERROR = "<?php echo $error?>";

  $(document).ready(function(){

    if(__ERROR)
    {
        show_notify(__ERROR);
    }

      $('.del').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            if(_id == 1 || _id == 2)
            {
                confirm('默认对象不能删除');
            }
            else
            {
                if(confirm('确认要删除吗?')){
                    location.href = __BASE + "category/del_expense/" + _id;
                }
            }
        });
      });


     $('.edit').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            location.href = __BASE + "category/update_expense/" + _id;
        });
      });

     $('.edit_pro').each(function(){
        $(this).click(function(){
            var _id = $(this).data('id');
            var _name = $(this).data('name');
            $('#pro_name').val(_name);
            $('#pro_id').val(_id);
        });
      });


  });
</script>