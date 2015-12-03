<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
-->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/jquery.json.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>


<div class="page-content">
<div class="page-content-area">
    <form class="form-horizontal"> 
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">名称</label>
                            <div class="col-xs-3 col-sm-3">
                                <input type="text" class="form-controller col-xs-12" id="name" value=<?php echo $policies['name']?> placeholder="输入名称"></div>
                        </div>

                        

                        
                        <label style="left:0;position: absolute;" class="col-sm-2 control-label no-padding-rigtht">可审批人员</label>
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

                        <div class="form-group" id="addLinePosition">
                            <div style="border-radius:10px;" onclick="addCate(this.parentNode)" class="col-sm-1 col-xs-1 col-sm-offset-2 col-xs-offset-2 btn-primary addDrop">添加+</div>    
                        </div>
                        
                        <label class="col-sm-2 control-label no-padding-rigtht" style="position:absolute;left:0px;">适用范围</label>
                        <div class="form-group">
                            <div class="col-xs-4 col-sm-4 col-xs-offset-2">
                                <select id="group" class="chosen-select range tag-input-style" name="groups[]"  data-placeholder="请选择部门">
                                <?php
                                    $open = 0;
                                    foreach($gnames as $ug)
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

                                    <option value='-1'>公司</option>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    foreach($gnames as $ug){
                                    ?>
                                    <option selected value="<?php echo $ug['id']; ?>">
                                        <?php echo $ug['name']; ?></option>
                                    <?php
                                    }


                                    ?></select>
                            </div>
                        </div>
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


<div id="modal-table" class="modal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">添加审批人员</h4>
</div>
    <div class="modal-body">
    <div class="container">
    <div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="form-group">
            <label class="col-sm-2 col-xl-2">人员</label>
            <div class="col-xs-6 col-sm-6">
                                <select id="member" class="chosen-select range tag-input-style" name="member[]" multiple  data-placeholder="请选择员工">
                                    <?php
                                    foreach($members as $m){
                                    ?>
                                    <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>

                                    <?php } ?></select>
        </div>
        
    </div>
    <br>
    <div class="form-group" style="clear: both;margin-top: 15px;">
        <label class="col-sm-2 col-xl-2">限额</label>
        <div class="col-xs-3 col-sm-3">
            <input class="quota" type="text" style="width:100%" placeholder="请输入限额">
        </div>
        <div class="col-xs-2 col-sm-2" style="position: relative;top: 6px;vertical-align: middle;">
            <label><input type="checkbox" style="margin-top: -3px;margin-right: 5px;">无限额</label>
        </div>
        
    </div>

    </div>
    </div>
    </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
                取消
        </button>
        <div class="btn btn-sm btn-primary" onclick="createPeople()">确定</div>
    </div>
    <input type="text" name="pid" class="hidden">
</div>
</div>
</div>
<!-- PAGE CONTENT ENDS -->

<script type="text/javascript">
    var fid = "<?php echo $fid ;?>";
   $(document).ready(function(){
        $("#group").val(policies.gid);
        $('#group').trigger("chosen:updated");
        for (item1 in policies.step) {
            addPeopleLine(addToDist(policies.step[item1]));
        }
        $('.renew').click(function(){
            var id = policies.id;
            var name = $('#name').val();
            var group = $('#group').val();
            var step = new Array();
            for (item1 in peoples) {
                if (item1 != null || item1 != undefined) {
                    step.push(peoples[item1]);
                }
            }
            if(name == '')
            {
                $('#name').focus();
                show_notify("请输入名称");
                return false;
            }
            if(step.length == 0)
            {
                show_notify("请添加人员");
                return false;
            }
                  $.ajax({
                type:"post",
                url:__BASE+"company/flow_finance_update/"+id,
                data:{
                    gids:group,
                    name:name,
                    steps:$.toJSON(step)
                },
                dataType:'json',
                success:function(data){
                        if(data.status == 1)
                            show_notify('保存成功');
                        else
                            show_notify('保存失败');
                      // window.location.href=__BASE+"category/account_set";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    },            });
     
           }); 
        $('.chosen-select').chosen({allow_single_deselect:true , width:"100%"});
       
        $('.cancel').click(function(){
            history.go(-1);
        });
        $("#modal-table").find("label input").click(function(event) {
            var DOM = $("#modal-table").find(".quota");
            DOM.attr('disabled', !DOM.attr('disabled'));
        });
    });
    function createPeople() {
        var selectDom = $("#modal-table");
        var uids = selectDom.find("#member").val();
        var nickname = getNickname(uids);
        var quota = -1;
        if (!selectDom.find("label input").is(":checked")) {
            quota = selectDom.find(".quota").val();
        }
        if (pointer == 0) {
            addPeopleLine(addToDist({
                "uids":uids,
                "quota":Number(quota).toFixed(2),
                "nicknames":nickname
            }));
        } else {
            peoples[pointer].quota = quota;
            peoples[pointer].uids = uids;
            peoples[pointer].nicknames = nickname;
            changePeopleLine();
        }
        
        $('#modal-table').modal('hide');
    }
    function addToDist(data) {
        peopleIndex += 1;
        peoples[String(peopleIndex)] = data;
        return peopleIndex;
    }
    function changePeopleLine() {
        var data = peoples[String(pointer)];
        if (pointer != 0) {
            var dom = $("#peopleLine_"+pointer);
            dom.find(".quota").text('限额：'+((data["quota"] == -1)?('无限额'):(Number(data["quota"]).toFixed(2))));
            dom.find(".dropdown-toggle").empty().text(data["nicknames"]).append($(
                    '<span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>'));
        }
    }
    function addPeopleLine(index) {
        var positionLine = $("#addLinePosition");
        var data = peoples[String(index)];
        var dom = '<div class="form-group" id="peopleLine_'+ index +'"><div class="col-xs-6 col-sm-6 col-sm-offset-2">'+

                                '<div class="dropdown col-xs-9 col-sm-9 ">'+
                                    '<div class="dropdown-toggle drop-cata" data-toggle="dropdown">'+
                                        data["nicknames"]+
                                        '<span class="caret" style="float: right; top: 30px; margin-top: 20px; margin-right: 20px;"></span>'+
                                    '</div>'+
                                    '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:90%;margin-left:15px;">'+
                                        '<li role="presentation">'+
                                            '<a href="#" onclick="showPeople('+index+')" role="menuitem" tabindex="-1">修改</a>'+
                                        '</li>'+
                                        '<li role="presentation" class="divider"></li>'+
                                        '<li role="presentation">'+
                                        '    <a href="#" class="quota" role="menuitem" tabindex="-1">限额：'+((data["quota"] == -1)?('无限额'):(data["quota"]))+'</a>'+
                                        '</li>'+
                                        '<li role="presentation" class="divider"></li>'+
                                        '<li role="presentation">'+
                                            '<a href="#" onclick="deletePeople('+index+',$(this).parent().parent().parent().parent().parent())" role="menuitem" tabindex="-1">删除</a>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                            
        '</div>';
        positionLine.before(dom);
    }
    function deletePeople(index, dom) {
        delete peoples[index];
        dom.remove();
    }
    function addCate(dom) {
        $('#modal-table').find('.chosen-select').val([]).trigger("chosen:updated");
        $('#modal-table').find('.quota').val('');
        $('#modal-table').find("label input").attr('checked',false);
        pointer = 0;
        $('#modal-table').modal('show');
    }
    function showPeople(index) {
        var dom = $("#modal-table");
        var data = peoples[index];
        if (data['quota'] == -1) {
            dom.find("label input").attr('checked',true);
            dom.find(".quota").attr('disabled', true);
            dom.find(".quota").val("");
        } else {
            dom.find("label input").attr('checked',false);
            dom.find(".quota").attr('disabled', false);
            dom.find(".quota").val(data['quota']);
        }
        $('#member').val(data.uids).trigger("chosen:updated");;

        pointer = index;
        $('#modal-table').modal('show');
    }
    var policies = <?php echo json_encode($policies); ?>;
    var peoples = new Array();
    var peopleIndex = 0;
    var pointer = 0;
    var gmember = <?php echo json_encode($members); ?>;
    function getNickname(uids) {
        var nickname = new Array();
        for (var i = 0; i < uids.length; i++) {
            for(item1 in gmember) {
                if (gmember[item1].id == uids[i])
                    nickname.push(gmember[item1].nickname);
            }
        }
        return nickname.join('|');
    }
</script>
