<link rel="stylesheet" type="text/css" href="/static/datatables/css/jquery.dataTables.css" />
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
                <!--
                <div class="clear br3 main_choose_choose">
                    <select name="">
                        <option>所有职位</option>
                    </select>
                </div>
                <div class="clear br3 main_choose_choose">
                    <select name="">
                        <option>适用规则</option>
                    </select>
                </div>
                <div class="clear br3 main_choose_choose">
                    <select name="">
                        <option>所有权限</option>
                    </select>
                </div>
                -->
            </div>
        </div>
    </div>
    <div class="fr mainpart_right">
        <div class="main_table main_table_2" style="height:605px">
            <div class="main_table_nav"> 
                <span class="fl link"><i class="tit">成员列表</i></span>
                <span class="fr btn" id="master">
                    <div class="DTTT_container">
                        <a href="javascript:void(0)" data-type=1 class="br3 creatBtn_3">设置为员工</a>
                    </div>
                    <div class="DTTT_container">
                    <a href="javascript:void(0)" data-type=2 class="br3 creatBtn_3">设置为管理员</a>
                    </div>
                </span> 
            </div>
            <table id="data" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
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
<script language="javascript" src="/static/datatables/js/jquery.dataTables.js"></script>
<script language="javascript" src="/static/datatables/TableTools/js/dataTables.tableTools.js"></script>
<script language="javascript">
                    var selected = [];
                    var _BASE = "<?php echo base_url(); ?>";
$(document).ready(function(){
    $('#data tbody').on('click', 'tr', function (e, data) {
        var id = $(this).data('id');
        var index = $.inArray(id, selected);
        if (index === -1) {
            $(this).addClass('reimclick');
            selected.push( id );
        } else {
            $(this).removeClass('reimclick');
            selected.splice(index, 1);
        }
        $(this).toggleClass('selected');
    } );
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

