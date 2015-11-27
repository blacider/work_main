<link rel="stylesheet" type="text/css" href="/static/datatables/css/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="/static/datatables/TableTools/css/dataTables.tableTools.css" />
<script language="javascript" src="/static/js/jquery-ui.min.js"></script>
<div class="clear box mainpart">
    <div class="fl mainpart_left">
        <div class="main_choose" style="height:510px">
            <div class="main_choose_hd"><span class="fl tit">筛选</span>
                <!-- <span class="fr btn_reset"><a href="javascript:void(0)" class="br3">重置</a></span> -->
            </div>
            <div class="main_choose_bd">
                <div class="clear br3 main_choose_search">
                    <input id="search_prop" type="search" class="fl inp" placeholder="商家，价格，备注" />
                    <input name="" type="button"  class="fr btn"/>
                </div>
                <div class="clear main_choose_date">
                    <input name="" type="text" class="fl br3 date date_1" value="2014-12-01" id="datepicker_1" />
                    <span class="fl txt">至</span>
                    <input name="" type="text" class="fr br3 date date_2" value="2015-01-01" id="datepicker_2" />
                </div>
                <div class="clear  br3 main_choose_nav main_choose_nav_1">
                    <ul>
                        <li data-pa="-1" class="pa active "><a href="javascript:void(0)">全部</a></li>
                        <li data-pa="0" class="pa"><a href="javascript:void(0)">已消费</a></li>
                        <li data-pa="1" class="pa"><a href="javascript:void(0)">预审批</a></li>
                    </ul>
                </div>
                <div class="clear br3 main_choose_choose">
                    <select id="tag_selector">
                        <option value="-1">所有标签</option>
<?php
$top_category = array();
$tgs = array();
foreach($tags as $item){
    $tgs[$item['id']] = $item;
?>
<option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
<?php
}
?>
                    </select>
                </div>
                <div class="clear br3 main_choose_choose">
                    <select id="cate_selector">
                        <option value="-1">所有类别</option>
<?php
$top_category = array();
$cates = array();
foreach($category as $item){
    if($item['pid'] == 0){
        $top_category[$item['id']] = $item;
        $cates[$item['id']] = $item;
?>
<option value="<?php echo $item['id']; ?>"><?php echo $item['category_name']; ?></option>
<?php
    }
}
?>
                    </select>
                </div>
                <div class="clear  br3 main_choose_check" id="main_choose_checker"> 
                    <a href="javascript:void(0)" class="br3 st btn btn_0"> <input data-st="0" name="" type="checkbox" checked="checked" /> 待提交</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_1"> <input data-st="1" name="" type="checkbox" checked="checked" /> 审核中</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_2"> <input data-st="2" name="" type="checkbox" checked="checked"  /> 已通过</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_3"> <input data-st="3" name="" type="checkbox" checked="checked"  /> 被退回</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_6"> <input data-st="6" name="" type="checkbox" checked="checked"  /> 待支付</a>
                    <a href="javascript:void(0)" class="br3 st btn btn_4"> <input data-st="4" name="" type="checkbox" checked="checked"  /> 已完成</a>
                </div>
            </div>
        </div>
    </div>
    <div class="fr mainpart_right">
        <div class="main_table main_table_3" style="height:985px">
            <div class="main_table_nav"> 
                <span class="fl link"><i class="tit">消费详情</i></span>
                <!--
                <span class="fl btn"><a href="javascript:void(0)" class="br3 creatBtn_2">+添加费用</a></span>
                <span class="fr pages"><i class="num"></i>
                    <a href="javascript:void(0)" class="br3 prev"></a>
                    <a href="javascript:void(0)" class="br3 next"></a>
                </span> 
                -->
            </div>
            <div class="main_table_bd">
            <table id="data" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>日期</th>
                        <th>商家</th>
                        <th>类别</th>
                        <th>标签</th>
                        <th>备注</th>
                        <th>金额</th>
                        <th style="display:none;">状态</th>
                        <th style="display:none;">PA</th>
                        <th style="display:none;">TAGS</th>
                        <th style="display:none;">CATES</th>
                        <th style="display:none;">DT</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($items as $item){
                    ?>
                    <tr>
                        <Td>
                            <?php if($item['prove_ahead']){ ?>
                            <span class="icon">
                                <i class="icon_yu"><img src="/static/images/icon_yu.png" /></i>
                            </span> 
                            <?php } ?>
                            </td>
                        <td style="width: 116px; padding-left: 14px; overflow: hidden;">
                            <?php echo date('m月d日', $item['dt'])  ?></td>
                        <td style="width: 90px;
                            text-align: center;
                            overflow: hidden;
                            }"><?php echo $item['merchants']; ?></td>
                        <td style="width: 110px;
                            text-align: center;
                            overflow: hidden;"><?php 
                            if(array_key_exists($item['category'], $cates)){
                        echo $cates[$item['category']]['category_name']; 
                            } else {
                                echo "已删除的分类";
                            }
?></td>
                        <td style="
                            width: 80px;
                            text-align: center;
                            overflow: hidden;
                            "> <?php 
                            if(array_key_exists($item['tags'], $tgs))
                            echo $tgs[$item['tags']]['name']; 
                            else
                                echo "";
?></td>
                        <td style="width: 120px;
                            text-align: center;
                            overflow: hidden;"> <?php echo $item['note']; ?></td>
                        <td style="width: 80px;
                            text-align: right;
                            line-height: 35px;
                            overflow: hidden;
                            ">
                            <i class="tstatus tstatus_<?php echo $item['status']; ?>"></i>
                             <strong class="price">&nbsp;&nbsp;&yen;<?php echo $item['amount']; ?> </strong>
                        </td>
                        <td style="display:none;"><?php echo $item['status']; ?></td>
                        <td style="display:none;"><?php echo $item['prove_ahead']; ?></td>
                        <td style="display:none;"><?php echo $item['tags']; ?></td>
                        <td style="display:none;"><?php echo $item['category']; ?></td>
                        <td style="display:none;"><?php echo $item['dt']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<script language="javascript" src="/static/datatables/js/jquery.dataTables.js"></script>
<script language="javascript" src="/static/datatables/TableTools/js/dataTables.tableTools.js"></script>
<script language="javascript">
$(document).ready(function(){
    var table = $('#data').DataTable({
        'info' : false,
            'ordering' : false,
            'pagingType' : 'full_numbers',
            'searching' : true,
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
    $('.pa').each(function(){
        $(this).click(function(){
            var _pa = $(this).data('pa');
            if(_pa > -1){
                $('#data').DataTable().column(8).search(_pa).draw();
            } else {
                $('#data').DataTable().column(8).search('').draw();
            }
        
        });
    });
    $('#tag_selector').change(function(){
        var tg = $(this).children('option:selected').val();
        if(tg > 0)
            $('#data').DataTable().column(9).search(tg).draw();
        else 
            $('#data').DataTable().column(9).search('').draw();
    });
    $('#cate_selector').change(function(){
        var tg = $(this).children('option:selected').val();
        if(tg > 0)
        $('#data').DataTable().column(10).search(tg).draw();
        else 
        $('#data').DataTable().column(10).search('').draw();
    });
    $('.st').each(function(){
        $(this).click(function(){
            var _st = '';
            var _an = $(this).children("input:checkbox").data('st');
            if($(this).children("input:checkbox").attr('checked')){
                _st = '';
            } else {
                _st = _an + "|";
            }
            $("#main_choose_checker input:checkbox").each(function () { 
                var __st = $(this).data('st');
                if (__st != _an && $(this).attr("checked")) { 
                    _st += __st + "|";
                } 
            }); 
            _st = _st.substr(0, _st.length-1);
            if(_st)
                $('#data').DataTable().column(7).search(_st, true, false).draw();
            else
                $('#data').DataTable().column(7).search('').draw();
        });
    });
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = strDate2Timestamp($('#datepicker_1').val() + " 00:00:00");
            var max = strDate2Timestamp($('#datepicker_2').val() + " 00:00:00");
            var age = parseFloat(data[11] ) * 1000 || 0; // use data for the age column

            if ( ( isNaN( min ) && isNaN( max ) ) ||
                ( isNaN( min ) && age <= max ) ||
                ( min <= age   && isNaN( max ) ) ||
                ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
        var _today = new Date().format('yyyy-MM-dd');
        var _start = strDate2Timestamp(_today + " 00:00:00");
        _start = new Date(_start - 86400 * 1000 * 90).format('yyyy-MM-dd');
        $('#datepicker_1').datepicker({onSelect:function(){table.draw();}});
        $('#datepicker_2').datepicker({onSelect:function(){table.draw();}});
        $('#datepicker_1').val(_start);
        $('#datepicker_2').val(_today);
    $('#search_prop').on('keyup', function(){
        var _key = $(this).val();
        $('#data').DataTable().search(_key).draw();
    });
    $('#datepicker_1').datepicker({onSelect:function(){table.draw();}});
    $('#datepicker_2').datepicker({onSelect:function(){table.draw();}});
});
</script>
