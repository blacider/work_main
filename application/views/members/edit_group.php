


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
        <form role="form" action="<?php echo base_url('members/updategroup');  ?>" method="post"  class="form-horizontal"  enctype="multipart/form-data" id="mainform">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                         <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门管理员</label>
                                <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" id="manager" name="manager" data-placeholder="请选择标签">
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
                                    <select class="chosen-select tag-input-style" id="pgroups" name= "pgroup"  data-placeholder="请选择部门">
                                    <option value=0>顶级部门</option>
                                    <?php 
                                    foreach($gnames as $m){
                                        if($m['id'] != $group['id']){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门名称</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门名称" class="col-xs-12" required="required" name="gname" value="<?php echo $group['name']; ?>">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门代码</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="text" placeholder="部门代码" class="col-xs-12" required="required" name="gcode" value="<?php echo $group['code']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">员工</label>
                                <div class="col-xs-6 col-sm-6">
                                    <input type="hidden" name="gid" value="<?php echo $group['id']; ?>" >
                                    <select class="chosen-select tag-input-style" name="uids[]" multiple="multiple" data-placeholder="请选择标签">
                                    <?php 
                                    foreach($member as $m){
                                        if(in_array($m['id'], $smember)){
                                    ?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . "[" . $m['email'] . "]"; ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>

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
<script type="text/javascript">var _pid="<?php echo $pid ?>" ;</script>
<script type="text/javascript">var _manager="<?php echo $manager ?>" ;</script>
<script language="javascript">
function move_list_items(sourceid, destinationid) {
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
}

var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    $("#manager").val( _manager ).attr('selected',true);
    $("#manager").trigger("chosen:updated");

    $("#pgroups").val(_pid).attr('selected',true);
    $("#pgroups").trigger("chosen:updated");
    //$("#year option[text="+_pid+"]").attr("selected",true);


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
        $('#mainform').submit();
    });
    $('.cancel').click(function(){
        history.go(-1);
    });
});
</script>
