
<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />
<script src="/static/ace/js/date-time/moment.min.js"></script>
<!-- <script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script> -->
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>


<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locales/bootstrap-datepicker.zh-CN.js" charset="UTF-8"></script>



<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('groups/update');  ?>" method="post"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                          <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门管理员</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="manager" data-placeholder="请选择标签">
                                        <option value=0>无</option>
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">上级部门</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name= "pgroup"  data-placeholder="请选择部门">
                                    <option value=0>顶级部门</option>
                                    <?php 
                                    foreach($group as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right" >部门名称</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门名称" id="gname" class="col-xs-12" required="required" name="gname" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right" >部门代码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门代码" id="code" class="col-xs-12" required="required" name="gcode" >
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">员工</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
<!--
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right" >部门代码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="code" id="code" class="col-xs-12" required="required" name="部门代码" >
                                </div>
                            </div>
-->
                          

                            <input type="hidden" id="renew" name="renew" value="0" />
                            <input type="reset" style="display:none;" id="reset">
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>

                                    <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script language="javascript">
function move_list_items(sourceid, destinationid) {
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
}

var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    $('#moveleft').click(function(){
        move_list_items('uids', 'srcs');
    });
    $('#moveright').click(function(){
        move_list_items('srcs', 'uids');
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
    $('.renew').click(function(){
        $('#renew').val($(this).data('renew'));

        var gname = $('#gname').val();
       
        if(gname.replace(/(^\s*)|(\s*$)/g,"") == ""){
         show_notify('请输入部门名称');
         $('#receiver').focus();
         return false;
        }
        if(gname.indexOf('-') >= 0)
        {
            show_notify("部门名称中不能包含'-'");
            $('receiver').focus();
            return false;
        }
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        $('#reset').click();
    });
});
</script>
