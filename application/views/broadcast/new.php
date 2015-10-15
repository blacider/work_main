
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
<form role="form" action="<?php echo base_url('broadcast/docreate');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="itemform">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right">标题</label>
                <div class="col-xs-6 col-sm-6">
                    <input type="text" class="form-controller col-xs-12" name="title" id="title" placeholder="标题" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right">正文</label>
                <div class="col-xs-6 col-sm-6">
                    <textarea class="col-xs-12 col-sm-12" row="30" name="content"></textarea>
                </div>
            </div>
                        <div class="form-group">
                        
                        <label class="col-sm-1 control-label no-padding-rigtht" style="position:absolute;left:0px;">适用范围</label>
                        <div class="form-group">
                            <div class="col-xs-1 col-sm-1 col-sm-offset-1 col-xs-offset-1">
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
                            <div class="col-xs-1 col-sm-1 col-sm-offset-1 col-xs-offset-1">
                                <input type="radio" name="range" value="1" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="ranks" class="chosen-select range tag-input-style" multiple="multiple" name="ranks[]"  data-placeholder="请选择职位">
                                
                                    <?php
                                    foreach($ranks as $ug){
                                        if(in_array($ug['id'],$sob_ranks)) {
                                    ?>
                                    <option selected value="<?php echo $ug['id']; ?>"><?php echo $ug['name']; ?></option>
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
                            <div class="col-xs-1 col-sm-1 col-sm-offset-1 col-xs-offset-1">
                                <input type="radio" name="range" value="2" onclick="choseRange(this.value)" style="position:relative;top:7px"></div>
                            <div class="col-xs-4 col-sm-4">
                                <select id="levels" class="chosen-select range tag-input-style" multiple="multiple" name="levels[]"  data-placeholder="请选择级别">
                                 
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
                            <div class="col-xs-1 col-sm-1 col-sm-offset-1 col-xs-offset-1">
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
                   
            <div class="clearfix form-actions col-sm-8 col-xs-8">
                <div class="col-md-offset-3 col-md-8">
                    <a class="btn btn-white btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save "></i>保存</a>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>
<script language="javascript">
var range = "0";
function choseRange(value) {
    var selectDom = $('.range');
    for (var i = 0; i <= 3; i++) {
        if (i == value)
            $(selectDom[i]).prop('disabled',false).trigger("chosen:updated");
        else
            $(selectDom[i]).prop('disabled',true).trigger("chosen:updated");
    }
}
$(document).ready(function() {
    $("input[name=range]:eq("+range+")").attr('checked','checked');
    choseRange(range);
    $('.renew').click(function() {
        $('#itemform').submit();
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

});

</script>
