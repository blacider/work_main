<link rel="stylesheet" type="text/css" href="/static/datatables/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/static/datatables/TableTools/css/dataTables.tableTools.css" />
<div class="clear box mainpart">
    <div class="fl mainpart_left">
        <div class="main_choose">
            <div class="main_choose_hd" style="color:black;"><span class="fl tit">筛选</span>
                <!--<span class="fr btn_reset"><a href="javascript:void(0)" class="br3">重置</a></span> -->
            </div>
            <div class="main_choose_bd">
                <div class="clear br3 main_choose_search">
                    <input aria-controls="example" id="search_prop" type="search" class="fl inp" placeholder="姓名、邮箱、电话" />
                    <input name="" type="button"  class="fr btn"/>
                </div>
            </div>
        </div>
    </div>
    <div class="fr mainpart_right">
        <div class="main_table main_table_2" style="height:605px">
            <div class="main_table_nav"> 
                <span class="fl link"><i class="tit">成员列表</i></span>
                <span class="fr " id="master">
                    <div class="btn DTTT_container">
                        <a href="javascript:void(0)" data-type=1 class="br3 creatBtn_3">设置为员工</a>
                    </div>
                    <div class=" btn DTTT_container">
                    <a href="javascript:void(0)" data-type=2 class="br3 creatBtn_3">设置为管理员</a>
                    </div>
                </span> 
            </div>
            <table id="data" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align:left;"><input type="checkbox" id="sall"></th>
                        <th style="text-align:left;">姓名</th>
                        <th style="text-align:left;">邮箱</th>
                        <th style="text-align:left;">电话</th>
                        <th style="">身份</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($members as $item){
                    ?>
                    <tr data-id="<?php echo $item['id']; ?>">
                        <td style="width:20px">
                            <input type="checkbox" class="chb" data-id="<?php echo $item['id']; ?>">
                        </td>
                        <td><div style="padding:8px;"><?php echo $item['nickname']; ?></div></td>
                        <td><div style="padding:8px;"><?php echo $item['email']; ?></div></td>
                        <td><div style="padding:8px;"><?php echo $item['phone']; ?></div></td>
                        <td>
                            <div style="padding:8px;">
<?php 
                                if($item['admin'] == 1){
                                    echo "管理员";
                                } else {
                                    echo "员工";
                                }
                            ?>
                            </div>
                        </td>
                    </tr>
                    </span> 
                    
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="report_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">用户详情</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
<div id="darkbg" style="display:none;"></div>
<div id=""  style="display:none;" class="pop_creat pop_creat_1">
    <div class="row">
        <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">销售总监</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>有五年以上知名互联网公司的工作经验，学历本科以上，理科生优先</li>
                    <li>正直诚实，热爱互联网行业，熟悉互联网产品</li>
                    <li>有优秀的沟通能力和团队配合精神</li>
                    <li>工作积极主动，有强烈的责任心，乐于接受挑战，能很好的承担压力</li>
                    <li>善于思考，逻辑思维缜密，有很强的学习能力</li>
                    <li>对数据敏感，有较强的数据分析能力，能熟练使用 Excel 等工具进行较复杂的数据分析</li>
                    <li>有独立把控和协调重要项目的能力</li>
                    <li>在移动互联网某一细分领域有出色的推广经验并有成功案例</li>
                </ul>
                如果您对此职位感兴趣，请将您的简历和在线作品集发送至 contact@cloudbaoxiao.com。
                <br />
            </div>
        </div>
        </div>
    </div>
</div>
    -->




<script language="javascript" src="/static/datatables/js/jquery.dataTables.js"></script>
<script language="javascript" src="/static/js/bootstrap.min.js"></script>
<script language="javascript" src="/static/datatables/TableTools/js/dataTables.tableTools.js"></script>
<script language="javascript">
                    var selected = [];
                    var _BASE = "<?php echo base_url(); ?>";
$(document).ready(function(){
    $('#data tbody').on('click', 'tr', function (e, data) {
        try{
            var _sch = $($(this).find('input').get(0)).attr('checked');
            if(_sch){
                $($(this).find('input').get(0)).attr('checked', false);
            } else {
                $($(this).find('input').get(0)).attr('checked', true);
            }
        }catch(e){}
        var id = $(this).data('id');
        $('#report_detail').modal();


        $.getJSON(_BASE + "users/detail/" + id).success(function(data){
            if(data.status > 0){
                $('#itemlists').html('');
                $('#back').hide();
                $('#reportname').val(_data['title']);
                $('#darkbg').show();
                $('#report_detail').show();
            }
        }).error(function(data){});;

        var index = $.inArray(id, selected);
        if (index === -1) {
            $(this).addClass('reimclick');
            selected.push( id );
        } else {
            $(this).removeClass('reimclick');
            selected.splice(index, 1);
        }
        $(this).toggleClass('selected');
            $('#darkbg').show();
            $('#report_detail').show();
    } );

    $('#sall').change(function(){
        if($("#sall").attr("checked")) {
            $('#data tbody tr').each(function(){
                $(this).addClass('selected');
            });
            $('.chb').each(function(){
                $(this).attr('checked', true);
            });
        } else {
            $('#data tbody tr').each(function(){
                $(this).removeClass('selected');
            });
            $('.chb').each(function(){

                $(this).attr('checked', false);
            });
        } 
    });
    var table = $('#data').DataTable({
        'info' : false,
            'ordering' : false,
            'pagingType' : 'full_numbers',
            'searching' : true,
            "rowCallback": function(row, data) {
                if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                    $(row).addClass('selected');
                }
            },
            "language": {
                "lengthMenu": "每页展示: _MENU_ 条",
                    "zeroRecords": "没有满足要求的数据",
                    "info": "_PAGE_ / _PAGES_",
                    "infoEmpty": "没有数据",
                    "infoFiltered": "(从 _MAX_ 中过滤到)",
                    "paginate" :  {
                        "first"  : '第一页',
                        "last"  : '末页',
                        "next"  : '下一页',
                        "previous"  : '上一页',
                    },
    },
    });
    $('.creatBtn_3').click(function(){
        if(selected.length == 0){
            return false;
        }
        var _ids = [];
        var _type = $(this).data('type');
        $('.reimclick').each(function(){
            var _id = $(this).data('id');
            _ids.push(_id);
        });
        try{
        var url = _BASE + 'groups/setadmin';
        $.ajax(url, {
            'method' : 'POST',
                //'dataType': 'json',
                'type': "post",
                'data' : {'data' : _ids, 'type' : _type},
                'success' : function(data){
                    location.replace(location.href);
                },
                    'error' : function(){
                        alert("提醒失败");
                    }
        });
        }catch(e){}
    });
    var tt = new $.fn.dataTable.TableTools(
        table, {
        "sSwfPath": "/static/datatables/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons" : [

                                {
                                    "sExtends":    "xls",
                                        "sButtonText": '<div class="br3" style="display: inline-block; height: 24px; line-height: 24px; color: #fff; background-color: #ef8587; text-align: center; padding: 0 10px; margin-left: 0px;" id="btnExport">批量导出</div>',
                                }
        ]
        }
    );
    $(tt.fnContainer()).appendTo($('#master'));
    $('.showmore').click(function(){
        $('.showmorep').hide();
        $('.main_table ').css('height', '100%');
    });
    $('#search_prop').on('keyup', function(){
        var _key = $(this).val();
        $('#data').DataTable().search(_key).draw();
    });
});
</script>

