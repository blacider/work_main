<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<div class="page-content">
    <div class="page-content-area">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                        	<div class="form-group">
                        	<label class="col-sm-1 control-label no-padding-rigtht" style="color:red">员工</label>
                            <div class="col-xs-4 col-sm-4">
                                <select id="member" class="chosen-select tag-input-style" style="width:95%" multiple="multiple" name="member[]"  data-placeholder="请选择员工">
                                    <?php
                                    foreach($members as $ug){
                                    ?>
                                    <option  value="<?php echo $ug['id']; ?>
                                        ">
                                        <?php echo $ug['nickname']; ?>
                                        (<?php echo $ug['email']; ?>)</option>
                                    <?php
                                    }

                                    ?></select>
                            </div>
                            <div class="btn btn-primary" id="submit">开始删除</div>
                        	</div>

                        	<div class="form-group" style="clear:both">
                        		<label class="col-sm-2 control-label no-padding-right">结果:</label>

                        	</div>
                        		
                        		
                        </div>

                    </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.chosen-select').chosen(); 
		$('#submit').click(function(event) {
			var members = $('#members').val();
		});
	});
</script>