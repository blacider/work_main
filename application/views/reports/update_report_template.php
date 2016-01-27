<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/js/util.js"></script>



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
                                <input id="sob_name" type="text" class="form-controller col-xs-12" value="<?php echo $report_template["name"];?>" name="sob_name" placeholder="输入报销单模板名"></div>
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
                        foreach ($report_template["config"] as $data) {?>
                        <div class="form-group" id="_<?php echo $data['id'];?>">
                            <div class="col-xs-6 col-sm-6 col-sm-offset-2">
                                <div class="dropdown col-xs-9 col-sm-9 ">
                                    <div class="dropdown-toggle drop-cata" data-toggle="dropdown">
                                        <?php echo $data["name"];?>
                                        <span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>
                                    </div>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:90%;margin-left:15px;">
                                        <?php 
                                        if(array_key_exists('children', $data)){
                                        foreach ($data["children"] as $child){ ?>
                                        <li role="presentation" data-subId="_<?php echo $child['id']; ?>">
                                            <a href="#" onclick="showSob(<?php echo $data['id'];?>,<?php echo $child['id']; ?>)" role="menuitem" tabindex="">
                                                <?php echo $child["name"]; ?>
                                            </a>
                                        </li>
                                        <?php 
                                        } }?>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation">
                                            <a href="#" onclick="addSub(<?php echo $data['id'];?>)" role="menuitem" tabindex="-1">添加字段</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#" onclick="showGroup(<?php echo $data['id']; ?>)" role="menuitem" tabindex="-1">修改</a>
                                        </li>
                                        <li role="presentation">
                                            <a href="#" onclick="delectGroup(<?php echo $data['id']; ?>)" role="menuitem" tabindex="-1">删除字段组</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php 
                        } ?>
                        <div class="form-group">
                            <div style="border-radius:10px;" onclick="addCate(this.parentNode)" class="col-sm-1 col-xs-1 col-sm-offset-2 col-xs-offset-2 btn-primary addDrop">添加+</div>    
                        </div>
                        <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">使用范围</label>
                        <div class="col-xs-5 col-sm-5">
                                    <select class="chosen-select tag-input-style" id="type" multiple="multiple" data-placeholder="请选择类型" placeholder="请选择类型">
                                        <option value="0"><?php echo $item_type_dic[0];?></option>
                                        <option value="1"><?php echo $item_type_dic[1];?></option>
                                        <option value="2"><?php echo $item_type_dic[2];?></option>
                                    </select>
                                </div>
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
    .addOption, .removeOption {
        cursor: pointer;
        margin-left: 33px;
        color: black;
        font-weight: bolder;
    }
</style>
<form action="#" method="post" id="form_moda">
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
                   
        </div><label id="options_label" class="col-sm-2 control-label no-padding-right">选项：</label>
        <div id="options">
        </div>
        <div id="bank">
            <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否为付款银行账户</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="bank" class="ace ace-switch btn-rotate" type="checkbox" style="margin-top:4px;" />
                                            <span class="lbl"></span>
                                        </label>
                                </div>
            </div>
        </div>
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
            <input type="button" value="删除" id="deleteSub" class="btn btn-sm hidden">
                <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
                取消
        </button>
        <input type="button" id="createSub" value="提交" class="btn btn-sm btn-primary">
            </div>
        </div>
    </div>
    <input type="text" name="groupId" class="hidden">
    <input type="text" name="subId" class="hidden">
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
<form id="create_form" method="post" action="">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">名称</label>
            <input type="text" name='name' data-placeholder="请输入名称"></div>
        <div class="form-group" style="height:30px">
            <label class="col-sm-3 control-label no-padding-right">是否打印</label>
                                <div class="col-xs-6 col-sm-6">
                                        <label style="margin-top:8px;">
                                            <input name="printable" class="ace ace-switch btn-rotate" type="checkbox" id="force_attach" style="margin-top:4px;" />
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
        <input type="submit" id="createGroup" class="btn btn-sm btn-primary">
    </div>
    <input type="text" name="groupId" class="hidden"></form>
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->

<script type="text/javascript">
    var __dataUpload = <?php echo json_encode($report_template);?>;
    var __nid = -1;
    function getSubIndexById(groupId, id) {
        var index = getGroupIndexById(groupId);
        var data = __dataUpload["config"][index]["children"];
        for (var i = 0; i < data.length; i++) {
            if (data[i].id == id || data[i].nid == id) return i;
        }
        return -1;
    }
    function getGroupIndexById(id) {
        var data = __dataUpload["config"];
        for (var i = 0; i < data.length; i++) {
            if (data[i].id == id || data[i].nid == id) return i;
        }
        return -1;
    }
   $(document).ready(function(){
        $("#deleteSub").click(function(event) {
            var groupId = $('#modal_1').find('input[name="groupId"]').val();
            var subId = $('#modal_1').find('input[name="subId"]').val();
            var gIndex = getGroupIndexById(groupId);
            var sIndex = getSubIndexById(groupId,subId);
            __dataUpload['config'][gIndex]['children'].splice(sIndex,1);
            //下面删除元素
            $("li[data-subid='_"+ subId +"']").remove()
            $('#modal_1').modal('hide');
        });
        if (__dataUpload['type'].length == 0) {
            __dataUpload['type'].push("0");
        };
        $("#type").val(__dataUpload['type']).trigger("chosen:updated").change(function(event) {
            __dataUpload['type'] = $("#type").val();
        });
        $("#createSub").click(function(event) {
            var groupId = $('#modal_1').find('input[name="groupId"]').val();
            var subId = $('#modal_1').find('input[name="subId"]').val();
            var name = $('#modal_1').find('input[name="name"]').val();
            var explanation = $('#modal_1').find('input[name="explanation"]').val();
            var required = $('#modal_1').find('input[name="required"]')[0].checked;
            var type = $('#modal_1').find('select').val();
            var option = [];
            var data = {
                explanation: explanation,
                name: name,
                required: (required?1:0),
                type: type
            };
            if (type == 2) {
                $("#options").find("input").each(function(index, el) {
                    option.push(el.value);
                });
                data.property = {};
                data.property.options = option;
            } else if (type == 4) {
                data.property = {};
                var bank_account_type_temp = $('#modal_1').find('input[name="bank"]')[0].checked;
                data.property.bank_account_type = (bank_account_type_temp?1:0);
            }
            var index = getGroupIndexById(groupId);
            if (ifCreate) {
                data.nid = __nid;
                __dataUpload['config'][index]['children'].push(data);
            } else {
                var subIndex = getSubIndexById(groupId, subId);
                var _data = __dataUpload['config'][index]['children'][subIndex];
                if (_data.id != undefined) data.id = _data.id;
                else data.nid = _data.nid;
                __dataUpload['config'][index]['children'][subIndex] = data;
            }
            //下面是添加到页面上
            if (!ifCreate) {
                $("li[data-subId='_"+subId+"']").find('a').text(name);
            } else {
                if (subId == "") subId = __nid;
                $("#_"+groupId).find(".divider").before(
                    '<li role="presentation" data-subId="_'+subId+'">'+
                                            '<a href="#" onclick="showSob('+groupId+','+subId+')" role="menuitem" tabindex="">'+
                                                name+
                                            '</a>'+
                    '</li>'
                );
            }
            $('#modal_1').modal('hide');
            __nid--;
            return false;
        });
        $("#createGroup").click(function(event) {
            var name = $("#create_form").find("input[name='name']").val();
            var printable = $('#modal_0').find('input[name="printable"]')[0].checked;
            if (name == "") {
                $("#create_form").find("input[name='name']").focus();
                show_notify("请输入字段组名称");
                return false;
            };
            var data = {
                children:[],
                name:name,
                type:0,
                printable:(printable?1:0)
            };
            var groupId = $('#modal_0').find('input[name="groupId"]').val();
        if (groupId == "") {
            data.nid = __nid;
            var index = __nid;
            __nid--;
            $(".addDrop").parent().before(
                    '<div class="form-group" id="_'+ index +'">'+
                            '<div class="col-xs-6 col-sm-6 col-sm-offset-2">'+
                                '<div class="dropdown col-xs-9 col-sm-9 ">'+
                                    '<div class="dropdown-toggle drop-cata" data-toggle="dropdown">'+
                                        name+
                                        '<span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>'+
                                    '</div>'+
                                    '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:90%;margin-left:15px;">'+
                                        '<li role="presentation" class="divider"></li>'+
                                        '<li role="presentation">'+    
                                            '<a href="#" onclick="addSub('+index+')" role="menuitem" tabindex="-1">添加字段</a>'+
                                        '</li>'+
                                        '<li role="presentation">'+
                                            '<a href="#" onclick="showGroup('+index+')" role="menuitem" tabindex="-1">修改</a>'+
                                        '</li>'+
                                        '<li role="presentation">'+
                                            '<a href="#" onclick="delectGroup('+index+')" role="menuitem" tabindex="-1">删除字段组</a>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                );
            __dataUpload['config'].push(data);
        } else {
            __dataUpload['config'][getGroupIndexById(groupId)].name = data.name;
            __dataUpload['config'][getGroupIndexById(groupId)].printable = data.printable;
            $("#_"+groupId).find(".dropdown-toggle").empty().append(data.name).append('<span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>');
        }
            $('#modal_0').modal('hide');
            return false;
        });
        $('.renew').click(function(){

            var sname = $('#sob_name').val();
            var sgroups = $('#group').val();
            //if(sname)
            if (__dataUpload['type'] == null || __dataUpload['type'].length == 0) {
                $('#type').focus();
                show_notify("请选择使用范围");
                return false;
            }
            if(trim(sname) == '')
            {
                $('#sob_name').focus();
                show_notify("请输入用户名");
                return false;
            }
            __dataUpload['name'] = sname;

        
            $.ajax({
                type:"post",
                url:__BASE+"company/doupdate_report_template",
                data:{temp_info:__dataUpload},
                dataType:'json',
                success:function(data){
                       if(data['status'] == 1)
                       {
                            show_notify(data['msg']);
                            window.location.href=__BASE+"company/report_template_list";
                       }
                       else
                       {
                            show_notify(data['msg']);
                       }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        console.log(textStatus);
                        console.log(errorThrown);
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
                            var ifCreate = false;
                            function showSob(groupId, subId) {
                                var index = getSubIndexById(groupId, subId);
                                var data = __dataUpload['config'][getGroupIndexById(groupId)].children[index];
                                if (index != -1) {
                                    $('#modal_1').find('input[name="subId"]').val(subId);
                                    $('#modal_1').find('input[name="groupId"]').val(groupId);
                                    $('#modal_1').find('input[name="name"]').val(data.name);
                                    $('#modal_1').find('input[name="explanation"]').val(data.explanation);
                                    $('#modal_1').find('input[name="required"]')[0].checked = (data.required == "1");
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
                                    
                                    } else if (data.type == 4) {

                                        $('#modal_1').find('input[name="bank"]')[0].checked = (data.property.bank_account_type == "1");
                                        $('#modal_1').find('input[name="bank"]').trigger("chosen:updated");
                                    }
                                    $('#extra_type').attr("disabled","true").trigger("chosen:updated");
                                }
                                ifCreate = false;
                                $("#deleteSub").removeClass('hidden')
                                $('#modal_1').modal('show');
                            }
                            function showGroup(groupId) {
                                var index = getGroupIndexById(groupId);
                                var data = __dataUpload['config'][index];
                                $('#modal_0').find('input[name="name"]').val(data['name']);
                                $('#modal_0').find('input[name="groupId"]').val(groupId);

                                $('#modal_0').find('input[name="printable"]')[0].checked = (data.printable == "1");
                                ifCreateGroup = false;
                                $('#modal_0').modal('show');
                            }
                            function addSub(groupId) {
                                ifCreate = true;
                                $('#modal_1').find('input[name="groupId"]').val(groupId);
                                $('#modal_1').find('input[name="name"]').val("");
                                $('#modal_1').find('input[name="subId"]').val("");
                                $('#modal_1').find('input[name="explanation"]').val("");
                                $('#modal_1').find('input[name="required"]')[0].checked = 0;
                                $('#modal_1').find('select').val(1).trigger("chosen:updated");
                                $('#modal_1').find('select').change();
                                $("#options").empty();
                                $("#options").append('<div class="form-group">'+
                                                    '<input name="code" type="text" data-placeholder="请输入选项">'+
                                                    '<a onclick="addOption(this.parentNode)" class="addOption">+</a>'+
                                                    '</div>');
                                $('#extra_type').removeAttr("disabled").trigger("chosen:updated");
                                $("#deleteSub").addClass('hidden');
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
                                var index = getGroupIndexById(id_);
                                __dataUpload['config'].splice(index,1);
                                //下面是删除页面元素
                                $("#_"+id_).remove();
                            }
                            function addCate(dom) {
                                $('#modal_0').find('input[name="groupId"]').val("");
                                $('#modal_0').find('input[name="pid"]').val(0);
                                $('#modal_0').find('input[name="name"]').val("");
                                $('#modal_0').find('input[name="printable"]')[0].checked = 0;
                                ifCreateGroup = true;
                                $('#modal_0').modal('show');
                            }
                            $("#extra_type").change(function(event) {
                                if (this.value == 2) {
                                    $("#options_label").css('display', 'block');
                                    $("#options").css('display', 'block');
                                    $("#bank").css('display', 'none');
                                } else if (this.value == 4) {
                                    $("#options").css('display', 'none');
                                    $("#options_label").css('display', 'none');
                                    $("#bank").css('display', 'block');
                                } else {
                                    $("#options_label").css('display', 'none');
                                    $("#options").css('display', 'none');
                                    $("#bank").css('display', 'none');
                                }
                            });
</script>
