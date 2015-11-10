<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
-->
<script src="/static/ace/js/chosen.jquery.min.js"></script>

<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>
<!-- <script type="text/javascript" src="/static/js/jquery.form.js"></script> -->
<!-- <?php
if($last_error) {
?>
<script type="text/javascript">
	alert("<?php echo $last_error; ?>");
</script>
<?php
}
?> -->

<div class="page-content">
<div class="page-content-area">
    <form role="form"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
        <div class="row" style="overflow:hidden;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">名称</label>
                            <div class="col-xs-3 col-sm-3">
                                <input id="sob_name" type="text" class="form-controller col-xs-12" name="sob_name" placeholder="输入帐套名"></div>
                        </div>

                        

                        
                        <label style="left:0;position: absolute;" class="col-sm-2 control-label no-padding-rigtht">类别</label>
                        <script type="text/javascript">
                            var _subSob = [];
                            var sob_keys = <?php echo json_encode($sob_keys);?>;
                            var all_categories = <?php echo json_encode($all_categories);?>;

                            function showSob(sobId) {
                                if (sobId != -1) {
                                    var extra_type = all_categories[sobId]['extra_type'],name = all_categories[sobId]['name'], note = all_categories[sobId]['note'],force_attach=all_categories[sobId]['force_attach'],code = all_categories[sobId]['sob_code'], img = all_categories[sobId]['avatar'], id = all_categories[sobId]['id'], name = all_categories[sobId]['name'], max_limit = all_categories[sobId]['max_limit'], pid = all_categories[sobId]['pid'],alias_type=all_categories[sobId]['alias_type'];
                                    $("#form_moda").find('input[name="name"]').val(name);
                                    $("#menuImg").attr('src', img);
                                    $('#form_moda').find('input[name="avatar"]').val(all_categories[sobId]['avatar_']);
                                    $("#form_moda").find('input[name="cid"]').val(id);
                                    $("#form_moda").find('input[name="code"]').val(code);
                                    $("#form_moda").find('input[name="note"]').val(note);
                                    $("#form_moda").find('input[name="max_limit"]').val(max_limit);
                                    $("#form_moda").find('input[name="pid"]').val(pid);
                                    $("#form_moda").find('select[name="alias_type"]').val(alias_type).attr('selected',true).trigger('chosen:updated');

                                    if(force_attach == 1)
                                    {
                                        $("#form_moda").find('input[name="force_attach"]').attr('checked',force_attach).trigger('chosen:updated');
                                    } else {
                                        $("#form_moda").find('input[name="force_attach"]').removeAttr('checked').trigger('chosen:updated');
                                    }


                                    if(extra_type)
                                    {
                                         $("#form_moda").find('select[name="extra_type"]').val(extra_type).attr('selected',true).trigger('chosen:updated');
                                    }
                                }
                                $('#modal_sob').modal('show');
                            }
                            function addSub(dom, id_) {
                                $('#modal-table').find('input[name="pid"]').val(id_);
                                $('#modal-table').modal('show');
                            }
                            function delectSob(id_) {
                                if(confirm('确认要删除吗?')){
                                    location.href = __BASE + "/category/drop/" + id_ + "/" + _sob_id;
                                }
                            }
                            function addCate(dom) {
                                $('#modal-table').find('input[name="pid"]').val(0);
                                $('#modal-table').modal('show');
                            }
                            function choseRange(value) {
                                var selectDom = $('.range');
                                for (var i = 0; i <= 3; i++) {
                                    if (i == value)
                                        $(selectDom[i]).prop('disabled',false).trigger("chosen:updated");
                                    else
                                        $(selectDom[i]).prop('disabled',true).trigger("chosen:updated");
                                }
                            }
                        </script>
                        <style type="text/css">
                                    .drop-cata {
                                                height: 42px;
                                                border-radius: 10px;
                                                line-height: 42px;
                                                border: 1px solid gainsboro;
                                                cursor: pointer;
                                                text-align: center;
                                    }
                                    .drop-cata .caret {
                                        
                                    }
                                    .addDrop {
                                            border-radius: 10px;
                                            height: 35px;
                                            line-height: 35px;
                                            text-align: center;
                                            cursor:pointer;
                                    }
                        </style>
                        <?php foreach($sob_keys as $item) {?>
                        <div class="form-group">
                            <div class="col-xs-6 col-sm-6 col-sm-offset-2">

                                <div class="dropdown col-xs-9 col-sm-9 ">
                                    <div class="dropdown-toggle drop-cata" data-toggle="dropdown">
                                        <?php echo $all_categories[$item]['name']; ?>
                                        <span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:90%;margin-left:15px;">
                                        <li role="presentation">
                                            <a href="#" onclick="showSob(<?php echo $all_categories[$item]['id'] ?>)" role="menuitem" tabindex="-1">修改</a>
                                        </li>
                                        <li role="presentation" class="divider"></li>
                                        <?php foreach ($all_categories[$item]['child'] as $item_) {?>
                                        <li role="presentation">
                                            <a href="#" onclick="showSob(<?php echo $item_['id'] ?>)" role="menuitem" tabindex="<?php echo $item_['id']; ?>">
                                                <?php echo $item_['name'] ;?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <li role="presentation">
                                            <a href="#" onclick="addSub(this, <?php echo $all_categories[$item]['id']; ?>)" role="menuitem" tabindex="-1">添加下级类别</a>
                                        </li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation">
                                            <a href="#" onclick="delectSob(<?php echo $all_categories[$item]['id']; ?>)" role="menuitem" tabindex="-1">删除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <?php }?>
                        <div class="form-group">
                            <div style="border-radius:10px;" onclick="addCate(this.parentNode)" class="col-sm-1 col-xs-1 col-sm-offset-2 col-xs-offset-2 btn-primary addDrop">添加+</div>    
                        </div>
                        
                        <label class="col-sm-2 control-label no-padding-rigtht" style="position:absolute;left:0px;">适用范围</label>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="0" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="group" class="chosen-select range tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                <?php
                                    $open = 0;
                                    foreach($sob_data as $ug)
                                    {
                                        if($ug['id'] == 0)
                                        {
                                            $open = 1;
                                        }
                                    }
                                ?>
                                <?php
                                    if($open == 0)
                                    {
                                ?>

                                    <option value='0'>公司</option>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['id']; ?>">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                    <option select value="<?php echo $ug['id']; ?>">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                        }
                                    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">部门</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="1" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="ranks" class="chosen-select range tag-input-style" multiple="multiple" name="ranks[]"  data-placeholder="请选择级别">
                                
                                    <?php
                                      
                                    foreach($ranks as $ug){
				    if(in_array($ug['id'],$sob_ranks))
				    {
				    ?>
                                    <option selected value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
				    <?php
				    }else
				    {
                                    ?>
                                    <option value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                      
                                    }
				    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">级别</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="2" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="levels" class="chosen-select range tag-input-style" multiple="multiple" name="levels[]"  data-placeholder="请选择职位">
                                 
                                    <?php
                                    
                                    foreach($levels as $ug){
				    if(in_array($ug['id'],$sob_levels))
				    {
				    ?>
                                    <option selected value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
				    <?php
				    }else
				    {
                                    ?>
                                    <option value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                    }
				    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">职位</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="3" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="member" class="chosen-select range tag-input-style" multiple="multiple" name="member[]"  data-placeholder="请选择员工">
                                    <?php
                                      $exit = array();
                                    foreach($members as $ug){
                                        if(!in_array($ug['id'],$sob_members))
                                        {
                                    ?>
                                    <option value="<?php echo $ug['id']; ?>"><?php echo $ug['nickname'] . " - [" . $ug['email'] . "]"; ?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                    <option selected value="<?php echo $ug['id']; ?>"><?php echo $ug['nickname'] . " - [" . $ug['email'] . "]"; ?></option>
                                        <?php echo $ug['nickname']; ?></option>
                                    <?php
                                        }
                                    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">员工</label>
                        </div>
                   
                <input type="hidden" id="sob_id" name="sob_id" value="<?php echo $sob_id?>" />
                <input type="hidden" id="renew" name="renew" value="0" />
                <input type="reset" style="display:none;" id="reset">
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <a class="btn btn-white btn-primary renew" data-renew="0"> <i class="ace-icon fa fa-save "></i>
                            保存
                        </a>

                        <a style="position:relative;left:80px;" class="btn btn-white cancel" data-renew="-1"> <i class="ace-icon fa fa-undo gray bigger-110"></i>
                            取消
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>

<div class="modal fade" id="modal_sob">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">类别信息</h4>
</div>
<style>
    .img-select {
        max-height: 30px;
        margin-right: 40px;
    }
    .down-image {
        cursor: pointer;
    }
</style>
<form action="<?php echo base_url('category/create_category')?>" method="post" id="form_moda">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" maxlength="20" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-rigtht">说明</label>
                            
            <input id="note" type="text" name="note" placeholder="输入说明">
        </div>



        <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否需要附件</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="force_attach" class="ace ace-switch btn-rotate" type="checkbox" id="force_attach" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
        </div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-2 col-xl-2">图片</label>
            <div class="dropdown col-sm-3 col-xl-3">
                <div class="dropdown-toggle down-image" data-toggle="dropdown" id="dropdownMenuImg">
                    <span>
                        <input type="text" name="avatar" class="hidden" value="9">
                        <img id="menuImg" class="img-select" src="http://api.cloudbaoxiao.com/online/static/9.png" alt="png"></span>
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuImg">
                    <?php for($i = 1; $i <= 11; $i++){ ?>
                    <li role="presentation">
                        <a href="#" onclick="changeImg(this)" role="menuitem" tabindex="-1">
                            <span>
                                <img class="img-select" src="http://api.cloudbaoxiao.com/online/static/<?php echo $i;?>.png" alt="<?php echo $i;?>"></span>
                        </a>
                    </li>
                    <?php } ?></ul>
            </div>
        </div>
	<div class="form-group">
	    <label class="col-sm-2">限额</label>
	    <input id="max_limit" name="max_limit" type="number" date-placeholder="请输入类别限额" value="0" />
	</div>

     <div class="form-group" style="height:30px;">
                    <label class="col-sm-2 control-label no-padding-right">特殊配置 </label>
                                <div class="col-sm-4"  style="padding:0;">
                                    <select class="chosen-select-niu tag-input-style" style="width:95%;" id="extra_type" name="extra_type" data-placeholder="配置类型" >

                                        <option value='0'>无</option>
                                        <option value='2'>时间段</option>
                                        <option value='5'>人均属性</option>

                                    </select>
                    </div>
                   
        </div>

        <div class="form-group">
            <label class="col-sm-2 col-xl-2">类别ID</label>
            <input name="code" type="text" data-placeholder="请输入类别ID">
        </div>
        <div class="form-group" style="height:30px;">
           <label class="col-sm-2 control-label no-padding-right">关联到:</label>
                    <div class="col-sm-4"  style="padding:0;">
                        <select class="chosen-select-niu tag-input-style" style="width:95%;" id="alias_type" name="alias_type" data-placeholder="关联属性" >
                            <option value="0">无</option>
<?php 
                                    foreach($all_categories as $a) { 
                                        if($a['id'] <= 0) continue;
?>
                            <option value="<?php echo $a['id']; ?>"><?php echo $a['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                   
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
                取消
        </button>
        <input type="submit" class="btn btn-sm btn-primary">
            </div>
        </div>
    </div>
    <input type="text" name="sob_id" class="hidden" value="<?php echo $sob_id; ?>">
    <input type="text" name="pid" class="hidden">
    <input type="text" name="cid" class="hidden">
</form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="modal-table" class="modal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">类别信息</h4>
</div>
<form id="create_form" method="post" action="<?php echo base_url('category/create_category'); ?>">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" maxlength="20" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-rigtht">说明</label>
                            
            <input id="note" type="text" name="note" placeholder="输入说明">
        </div>
            
        <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否需要附件</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="force_attach" class="ace ace-switch btn-rotate" type="checkbox" id="force_attach" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
        </div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-2 col-xl-2">图片</label>
            <div class="dropdown col-sm-3 col-xl-3">
                <div class="dropdown-toggle down-image" data-toggle="dropdown" id="dropdownMenuImg_">
                    <span>
                        <input type="text" name="avatar" class="hidden" value="9">
                        <img id="menuImg_" class="img-select" src="http://api.cloudbaoxiao.com/online/static/9.png" alt="png">
                    </span>
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuImg_">
                    <?php for($i = 1; $i <= 11; $i++){ ?>
                    <li role="presentation">
                        <a href="#" onclick="changeImg_(this)" role="menuitem" tabindex="-1">
                            <span>
                                <img class="img-select" src="http://api.cloudbaoxiao.com/online/static/<?php echo $i;?>.png" alt="<?php echo $i;?>"></span>
                        </a>
                    </li>
                    <?php } ?></ul>
            </div>
        </div>
	<div class="form-group">
            <label class="col-sm-2">限额</label>
            <input id="max_limit" name="max_limit" type="number" data-placeholder="请输入限额" value="0" />
        </div>

        <div class="form-group" style="height:30px;">
                    <label class="col-sm-2 control-label no-padding-right">特殊配置</label>
                                <div class="col-sm-4" style="padding:0;">
                                    <select class="chosen-select-niu tag-input-style" style="width:95%" id="extra_type" name="extra_type" data-placeholder="配置类型" >

                                        <option value='0'>无</option>
                                        <option value='2'>时间段</option>
                                        <option value='5'>人均属性</option>

                                    </select>
                    </div>

        </div>
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">类别代码</label>
            <input name="code" type="text" data-placeholder="请输入名称"></div>
    </div>
        <div class="form-group" style="height:30px;">
           <label class="col-sm-2 control-label no-padding-right">关联到:</label>
                    <div class="col-sm-4"  style="padding:0;">
                        <select class="chosen-select-niu tag-input-style" style="width:95%;" id="alias_type" name="alias_type" data-placeholder="关联属性" >
                            <option value="0">无</option>
<?php 
                                    foreach($all_categories as $a) { 
                                        if($a['id'] <= 0) continue;
?>
                            <option value="<?php echo $a['id']; ?>"><?php echo $a['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                   
        </div>
    <div class="modal-footer">
        <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
                取消
        </button>
        <input type="submit" class="btn btn-sm btn-primary">
    </div>
    <input type="text" name="sob_id" class="hidden" value="<?php echo $sob_id; ?>">
    <input type="text" name="pid" class="hidden"></form>
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->

<script type="text/javascript">
function changeImg(dom) {
    $('#menuImg').attr('src', $(dom).find('.img-select').attr('src'));
    $('#form_moda').find('input[name="avatar"]').val( $(dom).find('.img-select').attr('alt') );
}
function changeImg_(dom) {
    $('#menuImg_').attr('src', $(dom).find('.img-select').attr('src'));
    $('#create_form').find('input[name="avatar"]').val($(dom).find('.img-select').attr('alt'));
}
var __BASE = "<?php echo $base_url; ?>";
var _sob_id = "<?php echo $sob_id ?>";
var range = "<?php echo $range?>";
   $(document).ready(function(){
   /*   $('.renew').click(function(){
    var _checked = $('#isadmin').is('checked');
    $('#profile').submit();
    });*/
 
    $("input[name=range]:eq("+range+")").attr('checked','checked');
    choseRange(range);
  
        $.ajax({
            type:"get",
            url:__BASE+"category/getsobs",
            dataType:"json",
            success:function(data){
                if(_sob_id != 0)
                {
                    _sob_data = data[_sob_id];
                    _sob_name = _sob_data['sob_name'];
                    _sob_groups = _sob_data['groups'];
                    $('#sob_name').val(_sob_name);
                }
                else
                {
                    $('#sob_name').val('默认帐套');
                    $('#sob_name').prop('disabled','disabled').trigger('chosen:updated');
                    $('#group option').eq(0).prop('selected',true).trigger('chosen:updated');
                    $('#group').prop('disabled','disabled').trigger('chosen:updated');
                    $('input[name=range]').prop('disabled','disabled').trigger('chosen:updated');
                }
            },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                    },
        });




        $('.renew').click(function(){

            var sname = $('#sob_name').val();
            var sgroups = $('#group').val();
            //if(sname)
         
            if(sname == '')
            {
                $('#sob_name').focus();
                show_notify("请输入用户名");
                return false;
            }
            /*if(sgroups == null)
            {
                $('#group').focus();
                show_notify("请选择部门");
                return false;
            }*/

                  $.ajax({
                type:"post",
                url:__BASE+"category/update_sob",
                data:{sob_name:$('#sob_name').val()
                      ,groups:$('#group').val()
                      ,sid:$('#sob_id').val()
                      ,ranks:$('#ranks').val()
                      ,levels:$('#levels').val()
                      ,member:$('#member').val()
                      ,range:$("input[name='range']:checked").val()},
                dataType:'json',
                success:function(data){
                       show_notify('保存成功');
                       window.location.href=__BASE+"category/account_set";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    },            });
     
           }); 
        $(".chosen-select-niu").chosen({width:"95%"});
        $('.chosen-select').chosen({allow_single_deselect:true});
        $(window)
            .off('resize.chosen')
            .on('resize.chosen', function() {
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            }).trigger('resize.chosen');
       
        $('.cancel').click(function(){
            $('#sob_name').val(_sob_name);
            $("#group").val('');
            for (var item in _sob_groups) {
                if (item != undefined) {
                    var _id = _sob_groups[item].group_id;
                    $('select').find('option[value="'+ _id +'"]').attr('selected', 'true');
                }
            }
            $('#group').trigger("chosen:updated");

        });
    });

</script>
