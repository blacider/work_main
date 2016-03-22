<link rel="stylesheet" href="/static/ace/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/ace/css/dropzone.css" />

<link rel="stylesheet" href="/static/ace/css/ace.min.css" id="main-ace-style" />

<script src="/static/ace/js/date-time/moment.min.js"></script>
<script src="/static/ace/js/chosen.jquery.min.js"></script>
<script src="/static/ace/js/dropzone.min.js"></script>

<script src="/static/ace/js/date-time/moment.js"></script>
<script src="/static/ace/js/date-time/bootstrap-datetimepicker.min.js"></script>
<script  type="text/javascript" src="/static/ace/js/date-time/locale/zh-cn.js" charset="UTF-8"></script>
<script src="/static/js/reports.js"></script>
<script>
    var allow_no_items = '<?php echo $template['options']['allow_no_items'];?>';
</script>

<div class="page-content">
    <div class="page-content-area">
        <form role="form" action="<?php echo base_url('reports/update');  ?>" method="post" class="form-horizontal"  enctype="multipart/form-data" id="mainform" >
            <input type="hidden" name="id" value="<?php echo $report['id']; ?>" id="hrid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">名称</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="text" class="form-controller col-xs-12" id="title" name="title" placeholder="名称" value="<?php echo $report['title']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">提交至</label>
                                <div class="col-xs-9 col-sm-9">
                                    <input type="hidden" name="hidden_receiver" id="hidden_receiver" />
                                    <select class="chosen-select tag-input-style" name="receiver[]" multiple="multiple" data-placeholder="请选择审批人" id="receiver" <?php if($is_other){echo "disabled";}?>>
<?php
$user = $this->session->userdata('user');
$_empty = 0;
    if(!$report['receivers']['managers']){
        $_empty = 1;
    }
foreach($members as $m) {
    if($_empty == 0 && in_array($m['id'], $report['receivers']['managers']) || ($_empty == 1 && $user['manager_id'] == $m['id'])){
?>
<option selected value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php } else { ?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php
}
}
 ?>
                                    </select>
                                </div>
                            </div>
                            <?php if (!isset($company_config['enable_report_cc']) || $company_config['enable_report_cc']) { ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">抄送至</label>
                                <div class="col-xs-9 col-sm-9">
                                <select class="chosen-select tag-input-style" name="cc[]" id="cc"  multiple="multiple" data-placeholder="请选择抄送人" <?php if($is_other){echo "disabled";}?>>
<?php
foreach($members as $m) {
    if(in_array($m['id'], $report['receivers']['cc'])){
?>
<option selected="selected" value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php } else { ?>
<option value="<?php echo $m['id']; ?>"><?php echo $m['nickname']; ?> - [<?php echo $m['email']; ?> ]</option>
<?php }} ?>
                                    </select>
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
                                                    <input type="text" class="form-controller col-xs-8 field_value" data-type="1" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){echo $extra_dic[$field['id']]['value'];}?>"/>
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
                                                    <select class="chosen-select tag-input-style col-xs-6 field_value" data-type="2" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?>>
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
                                                    <input type="text" class="form-controller col-xs-8 period field_value date-timepicker1" data-type="3" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" name="dt"
                                                            placeholder="时间" <?php if($field['required'] == 1){echo 'required';}?> value="<?php if(array_key_exists($field['id'], $extra_dic)){if($extra_dic[$field['id']]['value']){echo date('Y-m-d',$extra_dic[$field['id']]['value']);}}?>">
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
                                                if(is_array($extra_dic[$field['id']]['value']))
                                                {
                                                    $value = $extra_dic[$field['id']]['value'];
                                                }
                                                else
                                                {
                                                    $value = json_decode($extra_dic[$field['id']]['value'],True);
                                                }
                                            }
                                        ?>
                                        <div class="field_value" data-type="4" data-id="<?php echo $field['id'];?>" data-bank="<?php echo $field['property']['bank_account_type'];?>" data-required="<?php echo $field['required'];?>" >
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right"><?php echo $field['name'];?></label>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="col-xs-12 col-sm-12 "  style="margin-left:0px !important;padding-left:0px !important;" >
                                                    <div class="btn-toolbar" id="<?php echo 'btns' . $field['id'];?>">
                                                        <div class="col-xs-8 col-sm-8">
                                                        
                                                            <select class="chosen-select tag-input-style col-xs-6 field_value bank_select" id="<?php echo 'bank_select_' . $field['id'];?>" data-type="4" data-id="<?php echo $field['id'];?>" data-required="<?php echo $field['required'];?>" data-placeholder="请选择" <?php if($field['required'] == 1){echo 'required';}?> >
                                                                <!-- value 可能为空 -->
                                                                <?php if(array_key_exists('value', $field)) { ?>
                                                                    <option value='<?php echo json_encode($value);?>' >
                                                                        <?php echo $value['account'] . '-' . $value['bankname'] . '-' . $value['cardno'];?>
                                                                    </option>>
                                                                <?php } else { ?>
                                                                    <option value=''>
                                                                        请选择银行卡
                                                                    </option>>
                                                                <?php } ?>

                                                                <?php foreach($banks as $b) { ?>
                                                                    <option value='<?php echo json_encode($b); ?>'>
                                                                        <?php echo $b['account']  . '-' . $b['bankname'] . '-' . $b['cardno']; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" class="btn btn-success new_credit" data-id="<?php echo $field['id'];?>">
                                                                <i class="ace-icon fa fa-credit-card icon-only"></i>
                                                                添加银行卡
                                                            </a>
                                                        </div><!-- /.btn-group -->
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

