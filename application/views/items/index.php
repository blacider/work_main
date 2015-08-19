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





<!-- page specific plugin scripts -->
<script src="/static/ace/js/date-time/bootstrap-datepicker.min.js"></script>


<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
var _error = "<?php echo $error; ?>";
</script>
<script src="/static/js/base.js" ></script>
<script src="/static/js/items.js" ></script>
<script language="javascript">
$(document).ready(function(){
    if(_error) show_notify(_error);

});
</script>
