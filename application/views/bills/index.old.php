




<!-- /section:basics/sidebar -->
<div class="main-content">
    <!-- #section:basics/content.breadcrumbs -->
<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
    <!-- #section:settings.box -->

    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                报销条目管理
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="row">
                    <div class="col-xs-12">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>消费金额</th>
                                    <th>消费地点</th>
                                    <th>消费时间</th>
                                    <th>预审批</th>
                                    <th>发票</th>
                                    <th class="hidden-680">
                                        <a href="#modal-table" role="button" class="green" data-toggle="modal">
                                            <i id="add_new_btn" class="ace glyphicon glyphicon-plus-sign" ></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$m_dict = array();
$top_category = array();
/*
foreach($category as $item){
if($item['pid'] == 0){
$top_category[$item['id']] = $item;
}
}
 */
foreach($items as $item){
    $img = "<a href='javascript:void(0)' class='invoice' data-src='" . $item['image_paths'] . "'> 有发票</a>";
    if($item['image_id'] == 0){
        $img = "无发票";
    }
    $images = explode(',', $item['image_paths']);
    $billable = $item['prove_ahead'] == 0 ? '不需要预审批' : '需要预审批';
    $str = '<tr>';
    $username = '<td class="u_username">' . $item['amount'] . '</td>';
    $nickname = '<td class="u_nickname">' . $item['merchants'] . '</td>';
    $role_id =  '<td class="u_role_name">' . date('Y-m-d H:i:s', $item['lastdt']) . '</td>';
    $ascription =  '<td class="u_role_name">' . $billable . '</td>';
    $image =  '<td class="u_role_name">' . $img  . '</td>';
    $operation_upd = '<td style="width:50px;">   <a href="javascript:void(0);" class="edit" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span></a>   <a href="javascript:void(0);" class="del" data-id="'.$item['id'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';

    $str = $str . $username . $nickname . $role_id . $ascription . $image . $operation_upd . '</tr>';
    echo $str;
}
?>
</tbody>
</table>
</div><!-- /.span -->
</div><!-- /.row -->

<div id="modal-table" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger"> 创建报销 </h4>
            </div>
            <form method="post" encrypt="multipart/form-data" action="<?php echo base_url('items/create'); ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="form-field-username">费用</label>
                                    <div>
                                        <input class="input-large" type="text"  placeholder="费用" id="amount" name="amount" />
                                        <input type="hidden"  id="item_id" name="item_id" value="0" required />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label for="form-field-username">分类</label>
                                    <div>
                                        <input class="input-large" type="text" placeholder="消费限制" id="max_limit" name="max_limit" />
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="form-field-username">发票照片</label>
                                    <div>
                                        <input class="input-large" type="file"  id="img" name="img" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label for="form-field-username">消费地点</label>
                                    <div>
                                        <input class="input-large" type="text"  id="place" name="place" placeholder="消费地点" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="form-field-username">消费商家</label>
                                    <div>
                                        <input class="input-large" type="text"  id="merchants" name="merchants" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label for="form-field-username">标签</label>
                                    <div>
                                        <input class="input-large" type="text"  id="tags" name="tags" />
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="form-field-username">消费时间</label>
                                    <div>
                                        <input class="input-large" type="text"  id="date" name="date"  data-date-format="YYYY-MM-DD" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label for="form-field-username">陪同消费人员</label>
                                    <div>
                                        <input class="input-large" type="text"  id="relates" name="relates" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="form-field-username">备注</label>
                                    <div>
                                        <input class="input-large" type="text"  id="comment" name="comment" />
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label for="form-field-username">预审批</label>
                                    <div>
                                        <select name="prove_ahead" class="form-control" id="prove_ahead">
                                            <option value="0">不需要预审核</option>
                                            <option value="1">需要预审核</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        取消
                    </button>
                    <input type="submit" class="btn btn-sm btn-primary">
                </div>
            </form>
        </div>
    </div>
</div><!-- PAGE CONTENT ENDS -->

</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content-area -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->



<div id="modal-form" class="modal in" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="blue bigger">发票</h4>
            </div>

            <div class="modal-body">
                <div class="row center" id="img_invoice">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

            </div>
        </div>
    </div>
</div>





<link rel="stylesheet" href="/static/assets/css/datepicker.css" />
<link rel="stylesheet" href="/static/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/static/assets/css/daterangepicker.css" />
<link rel="stylesheet" href="/static/assets/css/bootstrap-datetimepicker.css" />


<script src="/static/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/static/assets/js/date-time/moment.min.js"></script>
<script src="/static/assets/js/date-time/daterangepicker.min.js"></script>

<script src="/static/assets/js/date-time/bootstrap-datetimepicker.min.js"></script>




<script language="javascript">

$(document).ready(function(){
    $('#date').datetimepicker();

    $('.del').each(function(){
        $(this).click(function(){
            if(confirm('确认要删除吗?')){
                var _id = $(this).data('id');
                location.href = __BASEURL + "/category/drop/" + _id;
            }
        });
    });
    $('.edit').each(function(){
        $(this).click(function(){
            var _title = $(this).data('title');
            var _pid = $(this).data('pid');
            var _id = $(this).data('id');
            var _pa = $(this).data('pb');
            var _max_limit = $(this).data('max');


            $('#category_name').val(_title);
            $('#category_id').val(_id);
            $('#max_limit').val(_max_limit);
            $('#prove_ahead').val(_pa);
            $('#pid').val(_pid);
        $('#modal-table').modal();

        });
    });
    $('.invoice').each(function(idx, item){
        $(item).click(function(){
            var info = $(this).data('src');
            $('#img_invoice').html('<img src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' + info + '">');
            $('#modal-form').modal({backdrop: 'static', show : true});
        });
    });
});
</script>
