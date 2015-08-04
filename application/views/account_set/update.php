<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
-->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>

<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>

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
                        <label style="left:0;position: absolute;" class="col-sm-2 control-label no-padding-rigtht">类目</label>
                        <script type="text/javascript">
                            var _subSob = [];
                            var sob_keys = <?php echo json_encode($sob_keys);?>;
                            var all_categories = <?php echo json_encode($all_categories);?>;
                            function showSob(sobID) {

                                $('#modal_sob').modal('show');
                            }
                            function showSob(sobId) {
                                if (sobId != -1) {
                                    var name = all_categories[sobId]['name'], img = all_categories[sobId]['avatar'], id = all_categories[sobId]['id'];
                                    $("#form_moda").find('input[name="name"]').val(name);
                                    $("#menuImg").attr('src', img);
                                    $("#form_moda").find('input[name="id"]').val(id);
                                } else {
                                    $("#form_moda").find('input[name="name"]').val('');
                                    $("#menuImg").attr('src', 'http://api.cloudbaoxiao.com/online/static/1.png');
                                    $("#form_moda").find('input[name="id"]').val('');
                                }
                                $('#modal_sob').modal('show');
                            }
                            function addSub(dom, id_) {
                                $('#modal-table').find('input[name="pid"]').val(id_);
                                $('#modal-table').modal('show');
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
                        </style>
                        <?php foreach($sob_keys as $item) {?>
                        <div class="form-group">
                            <div class="col-xs-2 col-sm-2 col-sm-offset-2">

                                <div class="dropdown">
                                    <div class="dropdown-toggle drop-cata" data-toggle="dropdown">
                                        <?php echo $all_categories[$item]['name']; ?>
                                        <span class="caret"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="presentation">
                                            <a href="#" onclick="showSob(<?php echo $all_categories[$item]['id'] ?>)" role="menuitem" tabindex="-1">修改</a>
                                        </li>
                                        <li role="presentation" class="divider"></li>
                                        <?php foreach ($all_categories[$item]['child'] as $item_) {?>
                                        <li role="presentation">
                                            <a href="#" showSob(<?php echo $item_.id ?>
                                                ) role="menuitem" tabindex="
                                                <?php echo $item_.id; ?>
                                                ">
                                                <?php echo $item_.name ;?></a>
                                        </li>
                                        <?php } ?>
                                        <li role="presentation">
                                            <a href="#" onclick="addSub(this, <?php echo $all_categories[$item]['id']; ?>)" role="menuitem" tabindex="-1">添加下级类目</a>
                                        </li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation">
                                            <a href="#" onclick="delectSob(this)" role="menuitem" tabindex="-1">删除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div style="border-radius:10px;" class="col-sm-1 col-xs-1 btn btn-primary addDrop">添加+</div>
                        </div>
                        <?php }?>
                        <label class="col-sm-2 control-label no-padding-rigtht" style="position:absolute;left:0px;">适用范围</label>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="0" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                    <option value="0">公司</option>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['group_id']; ?>
                                        ">
                                        <?php echo $ug['group_name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                    <option select value="<?php echo $ug['id']; ?>
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
                                <input type="radio" name="range" value="1" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                    <option value="0">公司</option>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['group_id']; ?>
                                        ">
                                        <?php echo $ug['group_name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                    <option select value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                        }
                                    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">职级</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="2" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                    <option value="0">公司</option>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['group_id']; ?>
                                        ">
                                        <?php echo $ug['group_name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                    <option select value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                        }
                                    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">人</label>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-2 col-xs-offset-2">
                                <input type="radio" name="range" value="3" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder="请选择部门">
                                    <option value="0">公司</option>
                                    <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['group_id']; ?>
                                        ">
                                        <?php echo $ug['group_name']; ?></option>
                                    <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                                    <option select value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                        }
                                    }

                                    ?></select>
                            </div>
                            <label class="col-sm-1 control-label no-padding-rigtht" style="color:red">部门</label>
                        </div>
                        <!--
                            <div class="form-group">trol-label no-padding-rigtht">部门选择</label>
                    <div class="col-xs-4 col-sm-4">
                        <select id="group" class="chosen-select tag-input-style" multiple="multiple" name="groups[]"  data-placeholder /option>
                            <?php
                                      $exit = array();
                                    foreach($sob_data as $ug){
                                    ?>
                            <option selected value="<?php echo $ug['group_id']; ?>
                                ">
                                <?php echo $ug['group_name']; ?></option>
                            <?php
                                        array_push($exit, $ug['group_id']);
                                    }

                                    foreach($ugroups as $ug){
                                        if(!in_array($ug['id'], $exit))
                                        {
                                            ?>
                            <option select value="<?php echo $ug['id']; ?>
                                ">
                                <?php echo $ug['name']; ?></option>
                            <?php
                                        }
                                    }

                                    ?></select>
                    </div>
                </div>
                -->
                <input type="hidden" id="sob_id" name="sob_id" value="<?php echo $sob_id?>
                " />
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
    <h4 class="modal-title">类目信息</h4>
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
<form action="/" id="form_moda">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-2 col-xl-2">图片</label>
            <div class="dropdown col-sm-3 col-xl-3">
                <div class="dropdown-toggle down-image" data-toggle="dropdown" id="dropdownMenuImg">
                    <span>
                        <img id="menuImg" class="img-select" src="http://api.cloudbaoxiao.com/online/static/9.png" alt="png"></span>
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuImg">
                    <?php for($i = 1; $i <= 11; $i++){ ?>
                    <li role="presentation">
                        <a href="#" onclick="changeImg(this)" role="menuitem" tabindex="-1">
                            <span>
                                <img class="img-select" src="http://api.cloudbaoxiao.com/online/static/<?php echo $i;?>.png" alt="png"></span>
                        </a>
                    </li>
                    <?php } ?></ul>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">类目ID</label>
            <input name="id" type="text" data-placeholder="请输入名称"></div>
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <a class="btn btn-white btn-primary new_card" data-renew="0">
                    <i class="ace-icon fa fa-save "></i>
                    退回
                </a>
            </div>
        </div>
    </div>
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
    <h4 class="modal-title">类目信息</h4>
</div>
<form method="post" action="<?php echo base_url('category/create'); ?>">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-2 col-xl-2">图片</label>
            <div class="dropdown col-sm-3 col-xl-3">
                <div class="dropdown-toggle down-image" data-toggle="dropdown" id="dropdownMenuImg">
                    <span>
                        <img id="menuImg" class="img-select" src="http://api.cloudbaoxiao.com/online/static/9.png" alt="png"></span>
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuImg">
                    <?php for($i = 1; $i <= 11; $i++){ ?>
                    <li role="presentation">
                        <a href="#" onclick="changeImg(this)" role="menuitem" tabindex="-1">
                            <span>
                                <img class="img-select" src="http://api.cloudbaoxiao.com/online/static/<?php echo $i;?>.png" alt="png"></span>
                        </a>
                    </li>
                    <?php } ?></ul>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">类目代码</label>
            <input name="id" type="text" data-placeholder="请输入名称"></div>
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
}
var __BASE = "<?php echo $base_url; ?>";
var _sob_id = "<?php echo $sob_id ?>";
   $(document).ready(function(){
   /*   $('.renew').click(function(){
    var _checked = $('#isadmin').is('checked');
    console.log("checked" + _checked);
    $('#profile').submit();
    });*/
        $.ajax({
            type:"get",
            url:__BASE+"category/getsobs",
            dataType:"json",
            success:function(data){
                console.log(data);
                console.log(data[_sob_id]);
                _sob_data = data[_sob_id];
                _sob_name = _sob_data['sob_name'];
                _sob_groups = _sob_data['groups'];
                console.log(_sob_name);
                $('#sob_name').val(_sob_name);
                console.log(_sob_groups);
            },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
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
            if(sgroups == null)
            {
                $('#group').focus();
                show_notify("请选择部门");
                return false;
            }

                  $.ajax({
                type:"post",
                url:__BASE+"category/update_sob",
                data:{sob_name:$('#sob_name').val(),groups:$('#group').val(),sid:$('#sob_id').val()},
                dataType:'json',
                success:function(data){
                       show_notify('保存成功');
                       window.location.href=__BASE+"category/account_set";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },            });
     
           }); 

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