<div class="form-group">
<label class="col-sm-1 control-label no-padding-right">参与人</label>
    <div class="col-xs-6 col-sm-6">
                                    <select class="chosen-select tag-input-style" id="member" name="uids[]" multiple="multiple" data-placeholder="请选择员工">
                                    <?php 
                                    foreach($member as $m){
                                    ?>
                                        <?php if ($m['id'] != $user) {?>
                                        <option value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){echo "[" . $m['email'] . "]";} elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                                        <?php } else { ?>
                                        <option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname'];if($m['email']){ echo "[" . $m['email'] . "]";}elseif($m['phone']){echo "[" . $m['phone'] . "]";}?></option>
                                        <?php } ?>
                                    <?php
                                    }
                                    ?>
                                    </select>
    </div>
</div>