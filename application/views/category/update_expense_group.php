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
             <h4 class="blue bigger" id="pro_title"><?php 
             if(array_key_exists('name', $fee_afford))
             {
                echo $fee_afford['name'];
             }
             ?>
             </h4> 
              <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>部门名称</th>
                    <th>
                    <table class="table table-striped" style="background-color:inherit">
                        <tr>
                          <td style="border:none;background-color:inherit">
                            <input type='checkbox' id='mul_edit' style="vertical-align: baseline;"><a style="vertical-align: middle;">对象名称</a>
                          </td>
                          <td style="border:none;background-color:inherit; width:80px;">
                          <a href="#modal-table2" data-toggle="modal" class="mul_update">
                              <span class="blue glyphicon glyphicon-pencil"></span>
                          </a>
                          <a href="#modal-table2" role="button" class="green" data-toggle="modal"> <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                          </a> 
                          </td>
                        </tr>
                      </table>
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
                      <table class="table table-striped">
                        <?php 
                            foreach($gd as $_gd)
                            {
                          ?>
                        <tr>
                          <td>
                            <input type='checkbox' class='single_edit' data-pid="<?php echo $_gd['pid'];?>" data-id="<?php echo $_gd['id'];?>" data-gid="<?php echo $_gd['gid'];?>"  data-oid="<?php echo $_gd['gid'] . ',' .$_gd['oid'] . ',' . $_gd['oname'];?>" data-gname="<?php echo $_gd['gname'];?>" data-oname="<?php echo $_gd['oname'];?>"> <a style="vertical-align: middle;"><?php echo $_gd['oname']; ?></a></td>
                          <td style="width:80px;">
                            <a href="#modal-table2" data-toggle="modal" class="edit"  data-pid="<?php echo $_gd['pid'];?>" data-id="<?php echo $_gd['id'];?>" data-gid="<?php echo $_gd['gid'];?>"  data-oid="<?php echo $_gd['gid'] . ',' .$_gd['oid'] . ',' . $_gd['oname'];?>">
                              <span class="blue glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="javascript:void(0);" class="del" data-id="<?php echo $_gd['id']?>
                              " data-pid="<?php echo $_gd['pid'];?>">
                              <span class="red glyphicon glyphicon-trash"></span>
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
<style type="text/css">
  input[type="checkbox"] {
    vertical-align: baseline;
    margin-right: 20px;
  }
  a {
    text-decoration: none;
    color: inherit;
  }
  td table tr:first-child td{
    border: none;
  }
</style>
<div id="modal-table2" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?php echo base_url('category/create_fee_afford')?>
      " method='post'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
          <h4 class="blue bigger" id="modal_title">新建对象</h4>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="col-xs-12 col-sm-12">
              <div class="row">
                <label for="form-field-username" class="col-sm-12 col-xl-12" id="obj_lab">导入对应部门和员工:</label>
                <div class="form-group" id="gForm">
                  <div id='g_lab' class="col-xs-9 col-sm-9">部门:</div>
                  <div class="col-xs-9 col-sm-9">
                    <select id="gid" class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="gid[]" multiple="multiple" data-placeholder="请选择部门">
                      <?php foreach($groups as $m) { ?>
                      <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>
                  </div>
                </div>
                <div class="form-group">
                  <div id='o_lab' class="col-xs-9 col-sm-9">对象:</div>
                  <div class="col-xs-9 col-sm-9">
                    
                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="oid[]" multiple="multiple" id="oid" data-placeholder="选择对象">></select>

                  </div>
                </div>
                <label for="form-field-username" class="col-sm-12 col-xl-12">对象展示范围:</label>
                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="gids[]" multiple="multiple" id="gids" data-placeholder="选择部门">
                      <?php foreach($groups as $m) { ?>
                      <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

               

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="ranks[]" multiple="multiple" id="ranks"data-placeholder="选择级别">
                      <?php foreach($ranks as $m) { ?>
                      <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="levels[]" multiple="multiple" id="levels" data-placeholder="选择职位">
                      <?php foreach($levels as $m) { ?>
                      <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['name']; ?></option>
                      <?php } ?></select>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-9 col-sm-9">

                    <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="uids[]" multiple="multiple" id="uids"data-placeholder="选择员工">
                      <?php foreach($members as $m) { ?>
                      <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['nickname']; ?></option>
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
           

          
            <input type="hidden" name='pid' value="<?php echo $pid;?>">
            <input type="hidden" name="fid" id='fid' value='-1'>
            <input type="hidden" name='_gid' id='_gid'>
            <input type='hidden' name='_oid' id='_oid'> 
           
         </div>
         <div class="modal-footer">
           <button class="btn btn-sm close_modal" data-dismiss="modal">
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




<script type="text/javascript">

var __BASE = "<?php echo base_url();?>";
var error = "<?php echo $error;?>";
var _group_dic = '<?php echo json_encode($group_dic);?>';
var group_dic = '';
if(_group_dic)
{
  group_dic = JSON.parse(_group_dic);
}
console.log(group_dic);
var exists = [];
if(error)
{
  show_notify(error);
}

function arr_contains(item,arr)
{
    for(var i = 0 ; i < arr.length ; i++)
    {
      if(item == arr[i])
        return true;
    }

    return false;
}
  $(document).ready(function(){
    $('.chosen-select').chosen({width:"100%"}); 


      $('.close_modal').click(function(){
        $('#oid').empty().trigger('chosen:updated');
        exists=[];
        $('#oid').unbind('change');
      });

        $('#add_new_btn').click(function(){
          $('#g_lab').prop('hidden',false).trigger('chosen:updated');
            $('#o_lab').prop('hidden',false).trigger('chosen:updated');
             $('#gForm').prop('hidden',false).trigger('chosen:updated');
            $('#obj_lab').empty().append('选择部门:');
          $('#modal_title').empty().append('新建对象');
            $('#send').val('新建');
            $('#fid').val(-1);
            $('#gid').prop('disabled',false).trigger('chosen:updated');
            $('#oid').prop('disabled',false).trigger('chosen:updated');
            $('#gid').val('').trigger('chosen:updated');
            $('#oid').val('').trigger('chosen:updated');
            $('#gids').val('').trigger('chosen:updated');
                      
            $('#uids').val('').trigger('chosen:updated');
            $('#ranks').val('').trigger('chosen:updated');
            $('#levels').val('').trigger('chosen:updated');
            $('#oid').unbind('change');

        });

        $('#gid').change(function(){
            var _gid = $('#gid').val();
            if(_gid)
            {
                for(var j = 0 ; j < _gid.length ; j++)
                {
                    if(!arr_contains(_gid[j],exists))
                    {            
                        var _h = '';
                      
                          _h += "<option selected value=" + "'"+ _gid[j] + "," + _gid[j] + ","+ group_dic[_gid[j]]+"'"+">" + '部门' + '-' + group_dic[_gid[j]] + "</option>";
                       
                     
                        $('#oid').append(_h).trigger("chosen:updated");
                        $('#oid').trigger('change');
                        $('#oid').trigger('chosen:updated');
                        exists.push(_gid[j]);
                    }
                    else 
                    {
                     
                      var temp = $('#oid').val();
                      console.log(typeof temp);
                     // temp.push(_gid[j]+","+_gid[j]+","+group_dic[_gid[j]]);
                      //$('#oid').val(temp).trigger('chosen:updated');
                       console.log('already');
                      //$('#oid').val('').trigger('change');
                      $('#oid').trigger('chosen:updated');

                    }
                }
             //   $('#oid').val(_gid+','+group_dic[_gid]).attr('selected',true).trigger('chosen:updated');
                $('#_oid').val(JSON.stringify($('#oid').val()));
            }
        });
       $('#gid').trigger('change');
       $('#gid').trigger('chosen:updated');


       $('.del').each(function(){
          $(this).click(function(){
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
       //     console.log('pid:' + _pid);
         //   console.log('oid:' + _id);
            location.href = __BASE + "category/delete_fee_afford/" + _id + '/' + _pid;
          });
       });

          var _oid;
         $('.edit').each(function(){
          $(this).click(function(){
             $('#modal_title').empty().append('更新对象');
              $('#send').val('更新');
              $('#g_lab').prop('hidden',true).trigger('chosen:updated');
            $('#o_lab').prop('hidden',true).trigger('chosen:updated');
             $('#gForm').prop('hidden',true).trigger('chosen:updated');
             $('#obj_lab').empty().append('所选对象:');
             $('#oid').bind('change',function(){
                        console.log("_oid:" + _oid);
                        $('#oid').val(_oid).attr('selected',true).trigger('chosen:updated');
                        //var arr = [];
                        //arr.push($('#oid').val());
                        $('#_oid').val(JSON.stringify($('#oid').val()));
                      });
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
            var _gid = $(this).data('gid');
            _oid = $(this).data('oid');
            //$('#oid').empty().trigger('chosen:updated');
            $('#fid').val(_id);
 //           console.log('pid:' + _pid);
   //         console.log('id:' + _id);
     //       console.log('gid:' + _gid);
       //     console.log('oid:' + _oid);
            $.ajax({
              url:__BASE + 'category/get_fee_afford/' + _id,
              method:'get',
              dataType:'json',
              success:function(data){
 //                 console.log(data);
                 
                      var privilege = data.privilege;
 //                     console.log(privilege);
                      $('#gid').val(_gid).attr('selected',true).trigger('chosen:updated');
                      $('#gid').trigger('change');
                      $('#gid').trigger('chosen:updated');
                      $('#gid').prop('disabled',true).trigger('chosen:updated');
                      $('#oid').prop('disabled',true).trigger('chosen:updated');

                      $('#gid').prop('disabled',true).trigger('chosen:updated');
                     
                     
                      
                      $('#gids').val(privilege.groups).attr('selected',true).trigger('chosen:updated');
                      
                      $('#uids').val(privilege.users).attr('selected',true).trigger('chosen:updated');
                      $('#ranks').val(privilege.ranks).attr('selected',true).trigger('chosen:updated');
                      $('#levels').val(privilege.levels).attr('selected',true).trigger('chosen:updated');
                      $('#_gid').val($('#gid').val());
                      
                  
              },
              error:function(){}
            });
          });
       });

      $('#mul_edit').click(function(){
        if($('#mul_edit').is(':checked'))
        {
            $('.single_edit').each(function(){
                $(this).prop('checked',true);
            });
        }
        else
        {
            $('.single_edit').each(function(){
                $(this).prop('checked',false);
            });
 
        }
      });


      $('.mul_update').click(function(){
        $('#obj_lab').empty().append('所选对象:');
        $('#modal_title').empty().append('批量更新');
            $('#send').val('更新');
            $('#g_lab').prop('hidden',true).trigger('chosen:updated');
            $('#o_lab').prop('hidden',true).trigger('chosen:updated');
             $('#gForm').prop('hidden',true).trigger('chosen:updated');

             $('#oid').bind('change',function(){
                        $('#oid').val(_oid).attr('selected',true).trigger('chosen:updated');
                        console.log('oid called');
                        //var arr = [];
                        //arr.push($('#oid').val());
                        $('#_oid').val(JSON.stringify($('#oid').val()));
                      });
            $('#fid').val(-2);
            $('#gid').prop('disabled',false).trigger('chosen:updated');
            $('#oid').prop('disabled',false).trigger('chosen:updated');
            $('#gid').val('').trigger('chosen:updated');
            $('#oid').val('').trigger('chosen:updated');
            $('#gids').val('').trigger('chosen:updated');
                      
            $('#uids').val('').trigger('chosen:updated');
            $('#ranks').val('').trigger('chosen:updated');
            $('#levels').val('').trigger('chosen:updated');
            $('#oid').unbind('change');

            var item_arr = [];
            var gid_arr = [];
            $('.single_edit').each(function(){
                if($(this).is(':checked'))
                {
                    var __oid = $(this).data('oid');
                    var __gid = $(this).data('gid');
                    var __oname = $(this).data('oname');
                    var __gname = $(this).data('gname');
                    var _h = '';
                    _h += "<option selected>"+ "部门" + "-" + __oname +"</option>";
                    $('#oid').append(_h);
                    
                    gid_arr.push(__gid);
                    item_arr.push(__oid+"");
                }
            });
            //console.log(item_arr);
            $('#_oid').val(JSON.stringify(item_arr));
           // console.log($('#_oid').val());
            $('#gid').val(gid_arr).trigger('chosen:updated');
            $('#gid').prop('disabled',true).trigger('chosen:updated');
        
            $('#oid').prop('disabled',true).trigger('chosen:updated');

            if(gid_arr.length <= 0)
            {
              confirm('请选择更新的对象');
              return false;
            }
      });

       $('#send').click(function(){
        var __gids = $('#gids').val();
        var __uids = $('#uids').val();
        var __ranks = $('#ranks').val();
        var __levels = $('#levels').val();
        var __oids = $('#oid').val();
        var __fid = $('#fid').val();
        
        if(__oids == null && __fid == -1)
        {
          show_notify("请选择对象");
          return false;
        }
        if(__gids == null && __uids == null && __ranks == null && __levels == null)
        {
            show_notify("请选择对象展示范围");
            return false;
        }
        $('#obj_form').submit();
      });

  });
</script>
