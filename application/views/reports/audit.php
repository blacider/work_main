<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<style>
    .chosen-container  {
        min-width: 400px;
        width: 400px;
    }
</style>
<style type="text/css">
    #globalSearchText{
position: absolute;
  left: 75%;
  top: 60px;
  z-index: 2;
  height: 26px;
  width: 12%;
  border-style: ridge;
    }
    #globalSearch {
  background-color: #fe575f;
  position: absolute;
  left: 88%;
  top: 60px;
  border: 0;
  color: white;
  height: 25px;
  border-radius: 3px;   
  font-size: 12px;
   }
   #globalSearch:hover {
    background-color: #ff7075;
   }
</style>
    <input name="key" placeholder="ID、标题或发起人" value="" type='text' id="globalSearchText">
    <button type="button" id="globalSearch">搜索</button>
<div class="page-content">
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12">
                <table id="grid-table"></table>
                <div id="grid-pager"></div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="comment_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">退回理由</h4>
            </div>
            <form action="<?php echo base_url('/reports/permit'); ?>" method="post" id="form_discard">
                <div class="modal-body">
                    <input type="hidden" id="div_id" class="thumbnail" name="rid" style="display:none;" value=""/>
                    <input type="hidden" id="status"  name="status" style="display:none;" value="3" />
                    <div class="form-group">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <a class="btn btn-white btn-primary new_card" data-renew="0"><i class="ace-icon fa fa-save "></i>退回</a>
                            <a style="margin-left: 80px;" class="btn btn-white cancel" data-renew="-1"><i class="ace-icon fa fa-undo gray bigger-110"></i>取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="modal_next">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('reports/permit'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择后续审批人</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="2" id="status">
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-xs-9 col-sm-9">
                        <select class="chosen-select tag-input-style form-control col-xs-12 col-sm-12" name="receiver[]" multiple="multiple" id="modal_managers" style="width:300px;">
                            <?php foreach($members as $m) { ?>
                            <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="pass" name="pass" value="0" />
                <input type="submit" class="btn btn-primary pass" value="直接通过" />
                <input type="submit" class="btn btn-primary" value="提交" />
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>


<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
    $('.new_card').click(function(){
        $('#form_discard').submit();
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
    $('.pass').click(function(){
        $('#pass').val(1);
    });
});
</script>

<script src="/static/js/base.js" ></script>
<script src="/static/js/audit.js" ></script>
<script type="text/javascript">
$grid = $('#grid-table');
$("#globalSearch").click(function () {
    console.log('11111');
    var rules = [], i, cm, postData = $grid.jqGrid("getGridParam", "postData"),
        colModel = $grid.jqGrid("getGridParam", "colModel"),
        searchText = $("#globalSearchText").val(),
        l = colModel.length;
    for (i = 0; i < l; i++) {
        cm = colModel[i];
        if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
            rules.push({
                field: cm.name,
                op: "cn",
                data: searchText
            });
        }
    }
    postData.filters = JSON.stringify({
        groupOp: "OR",
        rules: rules
    });
    $grid.jqGrid("setGridParam", { search: true });
    $grid.trigger("reloadGrid", [{page: 1, current: true}]);
    return false;
});
</script>

