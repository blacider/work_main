<script src="/static/ace/js/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
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
                    <th>部门名称</th>
                    <th>
                      <input type='checkbox' id='mul_edit'>对象名称</th>
                    <th class="hidden-680">
                      <a href="#modal-table2" role="button" class="green" data-toggle="modal"> <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                        foreach($fee_afford['gdetail'] as $key=>
                  $gd)
                        {
                      ?>
                  <tr>
                    <td>
                      <?php 
                            if(array_key_exists($key, $group_dic)) 
                            {
                                 echo $group_dic[$key]; 
                            }
                            else
                            {
                                 echo '';
                            }
                            ?></td>
                    <td>
                      <table class="table table-striped table-bordered table-hover">
                        <?php 
                            foreach($gd as $_gd)
                            {
                          ?>
                        <tr>
                          <td>
                            <?php echo $_gd['oname']; ?></td>
                          <td style="width:80px;">
                            <a href="#modal-table2" data-toggle="modal" class="edit"  data-pid="<?php echo $_gd['pid'];?>
                              " data-id="
                              <?php echo $_gd['id'];?>
                              ">
                              <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="javascript:void(0);" class="del" data-id="<?php echo $_gd['id']?>
                              " data-pid="
                              <?php echo $_gd['pid'];?>
                              ">
                              <span class="glyphicon glyphicon-trash"></span>
                            </a>
                          </td>
                        </tr>

                        <?php 
                            }
                          ?></table>
                    </td>

                  </tr>

                  <?php
                       }
                      ?></tbody>
              </table>

            </div>
            <!-- /.span --> </div>
          <!-- /.row --> </div>
        <!-- /.col --> </div>
      <!-- /.row --> </div>
    <!-- /.page-content-area --> </div>
  <!-- /.page-content -->
</div>
<!-- /.main-content -->

<div id="modal-table2" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?php echo base_url('category/create_fee_afford')?>
      " method='post'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="blue bigger">新建对象</h4>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="col-xs-12 col-sm-12">
              <div class="row">
                <label for="form-field-username" class="col-sm-12 col-xl-12">导入对应部门和员工:</label>
                <div class="form-group">

                  <div class="col-xs-9 col-sm-9">
                    <select id="gid" class="chosen-select" name="gid"  data-placeholder="请选择部门">
                      <?php foreach($groups as $m) { ?>
                      <option value="<?php echo $m['id']; ?>
                        ">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="oid[]" multiple="multiple" id="oid" data-placeholder="选择对象">></select>

                  </div>
                </div>
                <label for="form-field-username" class="col-sm-12 col-xl-12">对象展示范围:</label>
                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="gids[]" multiple="multiple" id="gids" data-placeholder="选择部门">
                      <?php foreach($groups as $m) { ?>
                      <option value="<?php echo $m['id']; ?>
                        ">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="uids[]" multiple="multiple" id="uids"data-placeholder="选择员工">
                      <?php foreach($members as $m) { ?>
                      <option value="<?php echo $m['id']; ?>
                        ">
                        <?php echo $m['nickname']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="ranks[]" multiple="multiple" id="ranks"data-placeholder="选择级别">
                      <?php foreach($ranks as $m) { ?>
                      <option value="<?php echo $m['id']; ?>
                        ">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="levels[]" multiple="multiple" id="levels" data-placeholder="选择职位">
                      <?php foreach($ranks as $m) { ?>
                      <option value="<?php echo $m['id']; ?>
                        ">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">
                    <input type="checkbox" class="col-sm-2">
                    全体员工
                    <input class="col-sm-2" type="hidden" name='pid' value="<?php echo $pid;?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                    
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="oid[]" multiple="multiple" id="oid" style="width:400px;" data-placeholder="选择对象">>
                         
                        </select>

                    </div>
            </div>
            <label for="form-field-username">导入对应部门和员工:</label>
            <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                    
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="gids[]" multiple="multiple" id="gids" style="width:400px;" data-placeholder="选择部门">
                            <?php foreach($groups as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                            <?php } ?>
                        </select>

                    </div>
            </div>

             <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                    
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="uids[]" multiple="multiple" id="uids" style="width:400px;" data-placeholder="选择员工">
                            <?php foreach($members as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                            <?php } ?>
                        </select>

                    </div>
            </div>
           
            <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                    
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="ranks[]" multiple="multiple" id="ranks" style="width:400px;" data-placeholder="选择级别">
                            <?php foreach($ranks as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                            <?php } ?>
                        </select>

                    </div>
            </div>

            <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                    
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="levels[]" multiple="multiple" id="levels" style="width:400px;" data-placeholder="选择职位">
                            <?php foreach($ranks as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                            <?php } ?>
                        </select>

                    </div>
            </div>

            <div>
              <input type="checkbox"> 全体员工
            </div>
            <input type="hidden" name='pid' value="<?php echo $pid;?>">
            <input type="hidden" name="fid" id='fid' value='-1'>
           
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm" data-dismiss="modal">
             <i class="ace-icon fa fa-times"></i>
             取消
           </button>
           <input type="submit" id='send' class="btn btn-sm btn-primary" value="新建" />
         </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- PAGE CONTENT ENDS -->




<div id="modal-table3" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?php echo base_url('members/update_rank_level/0')?>
      " method='post'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="blue bigger">修改职位</h4>
        </div>
        <div class="modal-body">
          <div class="container">

            <div class="col-xs-12 col-sm-12">
              <div class="row">
                <div class="form-group">
                  <label for="form-field-username">职位名称:</label>
                  <div>
                    <input class="col-xs-4 col-sm-4" type="text" id="level_name" name="name" class="form-control" />
                  </div>
                  <div>
                    <input class="col-xs-4 col-sm-4" type="hidden" id="level_id" name="rank_level_id" class="form-control" />
                  </div>
                </div>
              </div>
              <!-- row --> </div>
            <!-- col-xs-12 --> </div>
          <!--- container --> </div>
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
</div>
<!-- PAGE CONTENT ENDS -->

<div id="modal-table4" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?php echo base_url('members/update_rank_level/1')?>
      " method='post'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="blue bigger">修改级别</h4>
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
              </div>
              <!-- row --> </div>
            <!-- col-xs-12 --> </div>
          <!--- container --> </div>
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
</div>
<!-- PAGE CONTENT ENDS -->
<p>
  <?php echo json_encode($fee_afford);?></p>
<script type="text/javascript">
var __BASE = "<?php echo base_url();?>";
var error = "<?php echo $error;?>";
if(error)
{
  show_notify(error);
}
  $(document).ready(function(){
    $('.chosen-select').chosen({allow_single_deselect:true,width:"95%"}); 
    $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': $this.parent().width()});
            })
        }).trigger('resize.chosen');

        $('#gid').change(function(){
          var _gid = $('#gid').val();
          $.ajax({
              url:__BASE + '/category/get_ug_members/'+ _gid,
              method:'get',
              dataType:'json',
              success:function(data){
                
                var _h = '';
                for(var i = 0 ; i < data.length; i++)
                {
                  _h += "<option value=" + "'"+data[i].id + ","+data[i].nickname+"'"+">" + data[i].nickname + "</option>";
                }
             
                $('#oid').empty().append(_h).trigger("chosen:updated");
              },
              error:function(a,b,c){
                console.log(a);
                console.log(b);
                console.log(c);
              }
          });
        });
       $('#gid').trigger('change');
       $('#gid').trigger('chosen:updated');


       $('.del').each(function(){
          $(this).click(function(){
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
            console.log('pid:' + _pid);
            console.log('oid:' + _id);
            location.href = __BASE + "category/delete_fee_afford/" + _id + '/' + _pid;
          });
       });

         $('.edit').each(function(){
          $(this).click(function(){
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
            $('#fid').val(_id);
            console.log('pid:' + _pid);
            console.log('oid:' + _id);
            $.ajax({
              url:__BASE + 'category/get_fee_afford/' + _id,
              method:'get',
              dataType:'json',
              success:function(data){
                  console.log(data);
                  if(data.pid == 1)
                  {
                      
                  }
              },
              error:function(){}
            });
          });
       });

  });
</script>
