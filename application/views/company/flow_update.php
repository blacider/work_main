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
    <form role="form"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
        <div class="row" style="overflow:hidden;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-rigtht">名称</label>
                            <div class="col-xs-3 col-sm-3">
                                <input id="sob_name" type="text" class="form-controller col-xs-12" name="sob_name" placeholder="输入名称"></div>
                        </div>

                        

                        
                        <label style="left:0;position: absolute;" class="col-sm-2 control-label no-padding-rigtht">审批人员</label>
                        <script type="text/javascript">
                            function addCate(dom) {
                                $('#modal-table').find('.chosen-select').trigger("chosen:updated");
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
                                      $exit = array();
                                    foreach($members as $ug){
                                    ?>
                                    <option value="<?php echo $ug['id']; ?>"><?php echo $ug['nickname'] . " - [" . $ug['email'] . "]"; ?></option>

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
                url:__BASE+"company/flow_finance_update/"+fid,
                data:{},
                dataType:'json',
                success:function(data){
                       show_notify('保存成功');
                      // window.location.href=__BASE+"category/account_set";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(textStatus);
                    },            });
     
           }); 
        $('.chosen-select').chosen({allow_single_deselect:true , width:"100%"});
       
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
        $("#modal-table").find("label input").click(function(event) {
            var DOM = $("#modal-table").find(".quota");
            DOM.attr('disabled', !DOM.attr('disabled'));
        });
    });
    function createPeople() {
        var selectDom = $("#modal-table");
        var uids = selectDom.find("#member").val();
        var quota = 0;
        if (!selectDom.find("label input").is(":checked")) {
            quota = selectDom.find(".quota").val();
        }
    }
</script>
