
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
        <form role="form" action="<?php echo base_url('groups/update');  ?>" method="post"  class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">部门名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" placeholder="组名称" class="col-xs-12" required="required" name="gname">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">员工</label>
                                <div class="col-xs-9 col-sm-9">
                                    <select class="chosen-select tag-input-style" name="uids[]" multiple="multiple" data-placeholder="请选择标签">
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row" style="margin-bottom: 10px;min-weight:40px;">
                                    <center>
                                        <button class="btn btn-success">提交</button>
                                    </center>
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
});
</script>
