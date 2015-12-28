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
        <form role="form" class="form-horizontal"  enctype="multipart/form-data" >
            <div class="row">
            <div class="container col-xs-11 col-sm-11">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['title']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交至</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['managers']; ?>" disabled>
                                </div>
                            </div>
                            <?php if (!isset($company_config['enable_report_cc']) || $company_config['enable_report_cc']) { ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-10 col-sm-10">
                                    <input type="text" class="form-controller col-xs-12" name="title" placeholder="名称" value="<?php echo $report['receivers']['cc']; ?>" disabled>
                                </div>
                            </div>
                            <?php } ?>

<?php
                        if(!empty($config)) {
?>
                            <input type="hidden" id="template_id" name="template_id" value="<?php echo $config['id']; ?>">
                            <?php
                            if($config['config'])
                            {
                                ?>
                            <hr>
                                <?php
                            }
                            foreach($config['config'] as $field_group){
                            ?>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right blue"><?php if(array_key_exists('name', $field_group)){echo $field_group['name'];}?></label>
                                </div>
                                <?php
                                    if(array_key_exists('children', $field_group))
                                    {
                                    foreach($field_group['children'] as $field)
                                    {
                                ?>

                                <?php
                                    switch(intval($field['type']))
                                    {

                                        case 1:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 field_value" data-type="1" data-id="<?php echo $field['id'];?>" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){echo $extra_dic[$field['id']]['value'];}?>" disabled/>
                                                </div>
                                            </div>

                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 2:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-3 col-sm-3">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <select class="chosen-select tag-input-style col-xs-6 field_value" data-type="2" data-id="<?php echo $field['id'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?> disabled>
                                                        <?php foreach($field['property']['options'] as $m) {
                                                                if(array_key_exists($field['id'], $extra_dic) && $m == $extra_dic[$field['id']]['value'])
                                                                {
                                                            ?>
                                                                <option selected value="<?php echo $m; ?>"><?php echo $m; ?></option>

                                                        <?php
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                                <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                                        <?php
                                                                }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 3:
                                ?>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 period field_value date-timepicker1" data-type="3" data-id="<?php echo $field['id'];?>" name="dt"
                                                            placeholder="时间" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){echo date('Y-m-d',$extra_dic[$field['id']]['value']);}?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                        case 4:
                                ?>
                                        <?php
                                            $value = array();
                                            if(array_key_exists($field['id'], $extra_dic))
                                            {
                                                $value = json_decode($extra_dic[$field['id']]['value'],True);
                                            }
                                        ?>
                                        <div class="field_value" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>">
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 account" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>"
                                                        placeholder="银行户名" value="<?php if($value && array_key_exists('account', $value)){ echo $value['account'];}?>" <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 cardno" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>"
                                                        placeholder="银行账号" value="<?php if($value && array_key_exists('cardno', $value)){ echo $value['cardno'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>

                                        </div>


                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankname" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>"
                                                        placeholder="开户行名" value="<?php if($value && array_key_exists('bankname', $value)){ echo $value['bankname'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>

                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 bankloc" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>"
                                                        placeholder="开户地" value="<?php if($value && array_key_exists('bankloc', $value)){ echo $value['bankloc'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>

                                        </div>

                                          <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"></label>
                                            <div class="col-xs-9 col-sm-9">
                                                <div class="radio col-xs-12 col-sm-12">
                                                    <input type="text" class="form-controller col-xs-8 subbranch" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>"
                                                        placeholder="支行" value="<?php if($value && array_key_exists('subbranch', $value)){ echo $value['subbranch'];}?>"  <?php if($field['required'] == 1){echo 'required';}?> disabled/>
                                                </div>
                                            </div>

                                        </div>
                                        </div>

                                <?php
                                        break;
                                ?>

                                <?php
                                    }
                                ?>

                                <?php
                                    }
                                ?>
                            <hr>
<?php
                            }
                        }
                    }
?>



                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">总额</label>
                                <div class="col-xs-10 col-sm-10">
<?php
$amount = 0;
foreach($report['items'] as $i) {
    $rate = 1.0;
    if($i['currency'] && strtolower($i['currency']) != 'cny') {
        $rate = $i['rate'] / 100;
    }
    $amount += $i['amount'] * $rate;
}
    $amount = sprintf("%.02f", $amount);
?>
    <span class="middle" id="tamount">￥  <?php echo $amount; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">消费列表</label>
                                <div class="col-xs-10 col-sm-10">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td>消费时间</td>
                                            <td>类别</td>
                                            <td>金额</td>
                                            <td>类型</td>
                                            <td>商家</td>
                                            <td>备注</td>
                                            <td>附件</td>
                                            <td>详情</td>
                                            <!--
                                            <td>操作</td>
                                            -->
                                        </tr>
                                        <?php foreach($report['items'] as $i){
                                            $_date_str = strftime('%Y-%m-%d %H:%M', $i['dt']);
                                            $_extra_amount = '';
                                            $_extra_dt = '';
                                            if(count($i['extra'])) {
                                                // TODO 目前情况下每个元素都只有一个了
                                                foreach($i['extra'] as $e) {
                                                    if($e['type']  == 2) {
                                                        // 多时间的
                                                        $sdt = $i['dt'];
                                                        $edt = $e['value'];
                                                        $_day_delta = abs(($sdt - $sdt % 86400) - ($edt - $edt % 86400)) / 86400;
                                                        if(date('H', $sdt) < 12) $_day_delta += 1;
                                                        if(date('H', $edt) > 12) $_day_delta += 1;
                                                        // 都切换到12点去
                                                        $_date_str = strftime('%Y-%m-%d %H:%M', $i['dt']) . '至' . strftime('%Y-%m-%d %H:%M', $edt);

                                                        if ($_day_delta > 0) {
                                                            $_date_str = $_date_str . "(共" . $_day_delta . "天)";
                                                            $_extra_amount = '（' . sprintf("%.2f", $i['amount'] / $_day_delta) . "元/天）";
                                                        }
                                                    }
                                                    if($e['type'] == 5) {
                                                        // 多人的
                                                        $members = $e['value'];
                            if ($members > 0) {
                                                            $_extra_amount = '（' . sprintf("%.2f", $i['amount'] / $members) . "元/人 共" . $members . "人）";
                            }
                                                    }
                                                }
                                            }
?>
                                        <tr>
                                            <td><?php echo $_date_str; ?></td>
                                            <td>
                                            <?php echo $i['category_name']; ?></td>
<?php
                                                $update_amount = '';
                                                if($i['src_amount'] > 0) {
                                                    $update_amount = "[" . $i['currency_logo'] . $i['src_amount'] . " 由  ". $i['lastmodifier'] . "修改]";
                                                }
?>
    <td><?php echo $i['currency_logo']; ?> &nbsp;<?php echo $i['amount']; ?> <?php echo  $update_amount . $_extra_amount; ?> </td>
                                            <td><?php
                                                echo $item_type_dic[$i['prove_ahead']];
                                                ?></td>
                                            <td><?php echo $i['merchants']; ?></td>
                                            <td><?php echo $i['note'];?></td>
                                            <td>
                                                <?php
                                                    echo $i['attachment'];
                                                ?>

                                            <td><?php $link = base_url('items/show/' . $i['id'] . "/1"); ?><a href="<?php echo $link; ?>">详情</a></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

