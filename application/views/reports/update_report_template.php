<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>



<div class="page-content">
<div class="page-content-area">
    <form role="form"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">名称</label>
                            <div class="col-xs-3 col-sm-3">
                                <input id="sob_name" type="text" class="form-controller col-xs-12" value="<?php echo $report_template["name"];?>" name="sob_name" placeholder="输入报告模板名"></div>
                        </div>

                        

                        
                        <label style="left:0;position: absolute;" class="col-sm-2 control-label no-padding-rigtht">字段组</label>
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
                        <?php 
                        $index = 0;
                        foreach ($report_template["config"] as $data) {?>
                        <div class="form-group">
                            <div class="col-xs-6 col-sm-6 col-sm-offset-2">
                                <div class="dropdown col-xs-9 col-sm-9 ">
                                    <div class="dropdown-toggle drop-cata" data-toggle="dropdown">
                                        <?php echo $data["name"];?>
                                        <span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:90%;margin-left:15px;">
                                        <?php 
                                        $index2 = 0;
                                        foreach ($data["children"] as $child){ ?>
                                        <li role="presentation">
                                            <a href="#" onclick="showSob(<?php echo $index; ?>,<?php echo $index2; ?>)" role="menuitem" tabindex="">
                                                <?php echo $child["name"]; ?>
                                            </a>
                                        </li>
                                        <?php 
                                        $index2++;
                                        } ?>
                                        
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation">
                                            <a href="#" onclick="addSub(this, <?php echo $data["id"]?>)" role="menuitem" tabindex="-1">添加字段</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#" onclick="showGroup(<?php echo $index; ?>)" role="menuitem" tabindex="-1">修改</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#" onclick="delectGroup()" role="menuitem" tabindex="-1">删除字段组</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php 
                            $index++;
                        } ?>
                        <div class="form-group">
                            <div style="border-radius:10px;" onclick="addCate(this.parentNode)" class="col-sm-1 col-xs-1 col-sm-offset-2 col-xs-offset-2 btn-primary addDrop">添加+</div>    
                        </div>
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

<div class="modal fade" id="modal_1">
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
    .addOption, .removeOption {
        cursor: pointer;
        margin-left: 33px;
        color: black;
        font-weight: bolder;
    }
</style>
<form action="<?php echo base_url('category/create_category')?>" method="post" id="form_moda">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-rigtht">说明</label>
                            
            <input id="note" type="text" name="explanation" placeholder="输入说明">
        </div>



        <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否必填</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="required" class="ace ace-switch btn-rotate" type="checkbox" id="force_attach" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
        </div>
     <div class="form-group" style="height:30px;">
                    <label class="col-sm-2 control-label no-padding-right">类型 </label>
                                <div class="col-sm-4"  style="padding:0;">
                                    <select class="chosen-select-niu tag-input-style" style="width:95%;" id="extra_type" name="extra_type">

                                        <option value='1'>文本框</option>
                                        <option value='2'>单选</option>
                                        <option value='3'>时间</option>
                                        <option value='4'>银行账号</option>

                                    </select>
                    </div>
                   
        </div><label class="col-sm-2 control-label no-padding-right">选项：</label>
        <div id="options">
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
    <input type="text" name="sob_id" class="hidden" value="">
    <input type="text" name="pid" class="hidden">
    <input type="text" name="cid" class="hidden">
</form>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="modal_0" class="modal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">字段组</h4>
</div>
<form id="create_form" method="post" action="<?php echo base_url('category/create_category'); ?>">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否打印</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="force_attach" class="ace ace-switch btn-rotate" type="checkbox" id="force_attach" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
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
    <input type="text" name="pid" class="hidden"></form>
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->

<script type="text/javascript">
    var __data = <?php echo json_encode($report_template['config']);?>;
   $(document).ready(function(){

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

                            function showSob(groupId, sobId) {
                                var data = __data[groupId].children[sobId];
                                if (sobId != -1) {
                                    $('#modal_1').find('input[name="pid"]').val(data.id);
                                    $('#modal_1').find('input[name="name"]').val(data.name);
                                    $('#modal_1').find('input[name="explanation"]').val(data.explanation);
                                    $('#modal_1').find('input[name="required"]').val(data.required);
                                    $('#modal_1').find('select').val(data.type).trigger("chosen:updated");
                                    $('#modal_1').find('select').change();
                                    if (data.type == 2) {
                                        var options = data.property.options;
                                        $("#options").empty();
                                        for (var i = 0; i < options.length-1; i++) {
                                            $("#options").append('<div class="form-group col-sm-offset-2 col-xs-offset-2">'+
                                                    '<input name="code" value="'+ options[i] +'" type="text" data-placeholder="请输入选项">'+
                                                    '<a onclick="removeOption(this.parentNode)" class="addOption">-</a>'+
                                                    '</div>');
                                        }
                                        $("#options").append('<div class="form-group col-sm-offset-2 col-xs-offset-2">'+
                                                    '<input name="code" value="'+ options[i] +'" type="text" data-placeholder="请输入选项">'+
                                                    '<a onclick="addOption(this.parentNode)" class="addOption">+</a>'+
                                                    '</div>');
                                    }
                                }
                                $('#modal_1').modal('show');
                            }
                            function showGroup(groupId) {
                                var data = __data[groupId];
                                $('#modal_0').find('input[name="name"]').val(data['name']);
                                $('#modal_0').modal('show');
                            }
                            function addSub(dom, id_) {
                                $('#modal_1').find('input[name="pid"]').val(id_);
                                $('#modal_1').find('input[name="name"]').val("");
                                $('#modal_1').find('input[name="explanation"]').val("");
                                $('#modal_1').find('input[name="required"]').val(0);
                                $('#modal_1').find('select').val(1).trigger("chosen:updated");
                                $('#modal_1').find('select').change();
                                $("#options").empty();
                                $("#options").append('<div class="form-group">'+
                                                    '<input name="code" type="text" data-placeholder="请输入选项">'+
                                                    '<a onclick="addOption(this.parentNode)" class="addOption">+</a>'+
                                                    '</div>');
                                $('#modal_1').modal('show');
                            }
                            function addOption(dom) {
                                $(dom).after(
                                    '<div class="form-group col-sm-offset-2 col-xs-offset-2">'+
                                        '<input name="code" type="text" data-placeholder="请输入选项">'+
                                        '<a onclick="addOption(this.parentNode)" class="addOption">+</a>'+
                                    '</div>');
                                $(dom).find('a').attr('onclick', 'removeOption(this.parentNode)').text("-");
                            }
                            function removeOption(dom) {
                                $(dom).remove();
                            }
                            function delectGroup(id_) {
                                if(confirm('确认要删除吗?')){
                                    location.href = __BASE + "/category/drop/" + id_ + "/" + _sob_id;
                                }
                            }
                            function addCate(dom) {
                                $('#modal_0').find('input[name="pid"]').val(0);
                                $('#modal_0').modal('show');
                            }
                            $("#extra_type").change(function(event) {
                                if (this.value == 2) {
                                    $("#options").css('display', 'block');
                                } else {
                                    $("#options").css('display', 'none');
                                }
                            });
</script>
