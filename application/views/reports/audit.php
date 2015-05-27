<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<style>
    .chosen-container  {
        min-width: 400px;
        width: 400px;
    }
</style>
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



<div class="modal fade" id="modal_next">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="<?php echo base_url('reports/permit'); ?>" method="post" class="form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">选择后续审批人</h4>
                <input type="hidden" name="rid" value="" id="rid">
                <input type="hidden" name="status" value="" id="status">
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
                <input type="submit" class="btn btn-primary" value="提交" />
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/static/ace/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="/static/ace/js/jqGrid/i18n/grid.locale-en.js"></script>


<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
$(document).ready(function(){
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

<script src="/static/js/base.js" ></script>
<script src="/static/js/audit.js" ></script>
