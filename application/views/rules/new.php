<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('rules/update');  ?>" method="post">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-1"><span>选择组</span></div>
                                <div class="col-xs-3">
                                    <select name="src"  class="col-xs-12" id="srcs">
                                        <option value="-1">全部员工</option>
<?php 
foreach($ggroup as $m){
?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
<?php
}
?>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                </div>
                                <div class="col-xs-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-1"><span>选择审批人员</span></div>
                                <div class="col-xs-3">
                                    <select name="dest"  class="col-xs-12" id="srcs">
<?php 
foreach($member as $m){
?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'] . " - [" . $m['email'] . "]"; ?></option>
<?php
}
?>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                </div>
                                <div class="col-xs-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-xs-1"><span>选择分类</span></div>
                                    <div class="col-xs-3">
                                        <select name="cates[]" class="col-xs-12">
<?php
foreach($cates as $m){
?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['category_name'];?></option>
<?php
}
?>
                                    </select>
                                </div>
                                <div class="col-xs-8">
                                    <input type="text" name="threshold[]"  placeholder="最大审核值">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-1"><span>选择分类</span></div>
                                <div class="col-xs-3">
                                    <select name="cates[]" class="col-xs-12">
<?php
foreach($cates as $m){
?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['category_name'];?></option>
<?php
}
?>
                                    </select>
                                </div>
                                <div class="col-xs-8">
                                    <input type="text" name="threshold[]"  placeholder="最大审核值">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-1"><span>选择分类</span></div>
                                <div class="col-xs-3">
                                    <select name="cates[]" class="col-xs-12">
<?php
foreach($cates as $m){
?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['category_name'];?></option>
<?php
}
?>
                                    </select>
                                </div>
                                <div class="col-xs-8">
                                    <input type="text" name="threshold[]"  placeholder="最大审核值">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <a class="btn btn-primary renew" data-renew="0"><i class="ace-icon fa fa-save bigger-110"></i>保存</a>
                                <a class="btn btn-primary renew" data-renew="1"><i class="ace-icon fa fa-check bigger-110"></i>保存再录入</a>
                            </div>
                        </div>
                        <!--
                        <div class="row" style="margin-bottom: 10px;min-weight:40px;">
                            <center>
                                <button class="btn btn-success">提交</button>
                            </center>
                        </div>
                        -->
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
});
</script>
