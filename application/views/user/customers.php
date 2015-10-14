    <style type="text/css">
        .add_new_pannel {
            width:600px;
            height:400px;
            display:none;
            z-index:2;
            margin:auto;
            position:absolute;
            left:50%;
            top:50%;
            margin-left:-300px;
            margin-top:-200px;
        }
        .update_pannel {
            width:600px;
            height:400px;
            display:none;
            z-index:2;
            margin:auto;
            position:absolute;
            left:50%;
            top:50%;
            margin-left:-300px;
            margin-top:-200px;
        }
    </style>
<div class="bs-doc-section">
            <div class="well page-header">
                <div class="col-md-3">
                <h4>客户列表</h4>
                </div>
                <div class="col-md-3" style="float:right;padding-top:5px;">
                    <button id="add_new_btn" class="btn btn-sm btn-primary" style="float:right;" type="button">添加客户</button>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
     客户名称
                            </th>
                            <th>
                                操作
                            </th>
                        </tr>
<?php
foreach($alist as $item){
        $str = '<tr>';
            $username = '<td class="u_username">' . $item['name'] . '</td>';
            $operation_upd = '<td style="width:50px;">   <a href="javascript:;" class="edit" data-name="' . $item['name'] . '" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:;" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>';

                $str = $str . $username . $operation_upd . '</tr>';
                echo $str;
}
?>
                    </tbody> <!-- /tbody -->
                </table> <!-- /table -->
            </div> <!-- /.well -->
        </div><!--/span-->
      </div><!--/row-->


<div class="modal fade" id="new_museum_dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo base_url('customers/create');?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">添加新客户</h4>
      </div>
      <div class="modal-body">
    <input type="text" name="name" placeholder="客户名称" required />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-success" >创建</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="modal fade" id="update_museum_dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo base_url('customers/update');?>" method="post">
      <div class="modal-header">
    <input type="hidden" id="mid" name="id" />
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">添加新客户</h4>
      </div>
      <div class="modal-body">
    <input type="text" id="mname" name="name" placeholder="客户名称" required />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-success" >更新</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <script type="text/javascript" >
        $(document).ready(function(){
        $('#add_new_btn').click(function(){
            $('#new_museum_dialog').modal();
            });
    $('.edit').each(function() {
    $(this).click(function(){
    var _id = $(this).data('id');
    var _name = $(this).data('name');
    $('#mid').val(_id);
    $('#mname').val(_name);
    $('#update_museum_dialog').modal('show');

        });
        });
            $('.del').each(function(){
                    $(this).click(function(){
                            if(confirm('真的要删除吗?')){
                                    var _id = $(this).data('id');
                                        location.href = __BASEURL + 'customers/delete/' + _id;
                                        }
                    });
                        });
                });
    </script>
