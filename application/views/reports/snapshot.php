<!-- convert list to map -->
<?php
    function fieldArrayToMap($arr)
    {
        if(!$arr) {
            $arr = array();
        }
        $map = array();
        foreach($arr as $item) {
            $map[$item['id']] = $item;
        }
        return $map;
    }

    $fieldMap = fieldArrayToMap($snapshot['config']);

    function getCategoryItemById($category_array, $id) {
        foreach($category_array as $item) {
            if($item['id'] == $id) {
                return $item;
            }
        }
        return array('category_name'=>'');
    }
?>
<style>
    .control-label {
        text-align: right;
    }
    .form-group {
        height: 40px;
    }
</style>

<div class="page-content" style="overflow: hidden;">
    <div class="page-content-area">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">名称</label>
            <div class="col-xs-9 col-sm-9">
                <input type="text" class="form-controller col-xs-12" id="title" disabled name="title" value="<?php echo $snapshot['title'];?>">
            </div>
        </div>
        <hr>
        <?php foreach($template['config'] as $fieldGroup) { ?>
        <?php $fields = $fieldGroup['children']; ?>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right"><span style="color: #478fca"><?php echo $fieldGroup['name'];?></span></label>
            </div>
            <?php foreach($fields as $fieldItem) { ?>
            <?php
               
                $fieldItemType = $fieldItem['type']; 
                $fieldItemId = $fieldItem['id'];

                $fieldItemObject =  array_key_exists($fieldItemId, $fieldMap);


                $fieldItemValue = '';
                if(!$fieldItemObject) {
                    $fieldItemValue = '';
                } else {
                    $fieldItemValue = $fieldMap[$fieldItemId]['value'];
                }
            ?>
            <?php
                if($fieldItemType == '4') {

                    $defaultItemObject = array(
                        'account'=>'',
                        'cardno'=>'',
                        'bankname'=>'',
                        'bankloc'=>'',
                        'subbranch'=>''
                    );

                    $fieldItemValue = json_decode($fieldItemValue, true);

                    if(!$fieldItemValue) {
                        $fieldItemValue = array();
                    }

                    $fieldItemValue = array_merge($defaultItemObject, $fieldItemValue);

            ?>
                <div class="field_value">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">
                            <?php 
                                    echo $fieldItem['name'];
                            ?>
                        </label>
                        <div class="col-xs-9 col-sm-9">
                            <input type="text" placeholder="银行户名" title="银行户名" class="form-controller col-xs-8" disabled value="<?php echo $fieldItemValue['account'] ;?>">
                        </div>
                    </div>
                </div>
                <div class="field_value">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"></label>
                        <div class="col-xs-9 col-sm-9">
                            <input type="text" placeholder="银行账号" title="银行账号" class="form-controller col-xs-8 " disabled value="<?php echo $fieldItemValue['cardno'] ;?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"></label>
                        <div class="col-xs-9 col-sm-9">
                            <input type="text" placeholder="开户行名" title="开户行名" class="form-controller col-xs-8 " disabled value="<?php echo $fieldItemValue['bankname'] ;?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"></label>
                        <div class="col-xs-9 col-sm-9">
                            <input type="text" placeholder="开户地" title="开户地" class="form-controller col-xs-8 " disabled value="<?php echo $fieldItemValue['bankloc'] ;?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right"></label>
                        <div class="col-xs-9 col-sm-9">
                            <input type="text" placeholder="支行" title="支行" class="form-controller col-xs-8 " disabled value="<?php echo $fieldItemValue['subbranch'] ;?>" />
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <?php
                    if($fieldItemType == '3' && $fieldItemValue) {
                        $fieldItemValue = strftime('%Y-%m-%d', $fieldItemValue);
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"><?php echo $fieldItem['name'];?></label>
                    <div class="col-xs-9 col-sm-9">
                        <input type="text" class="form-controller col-xs-8" disabled value="<?php echo $fieldItemValue ;?>">
                    </div>
                </div>
            <?php } ?>
            <?php } ?>
            <hr>
        <?php }  ?>
        
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">总额</label>
            <div class="col-xs-9 col-sm-9">
                ￥<?php echo $report['snapshot_amount'];?>.00
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">消费列表</label>
            <div class="col-xs-9 col-sm-9">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>消费时间</td>
                        <td>类目</td>
                        <td>金额</td>
                        <td>类型</td>
                        <td>商家</td>
                        <td>备注</td>
                        <td>附件</td>
                        <td>详情</td>
                    </tr>
                    <?php foreach($snapshot['items'] as $row) { ?>
                    <tr>
                        <td><?php echo strftime('%Y-%m-%d %H:%M', $row['dt']);?></td>
                        <td><?php echo getCategoryItemById($categories, $row['category'])['category_name'] ;?></td>
                        <td><?php echo $row['amount'];?></td>
                        <td><?php echo $template_types[$row['prove_ahead']];?></td>
                        <td><?php echo $row['merchants'];?></td>
                        <td><?php echo $row['note'];?></td>
                        <td>
                            <?php foreach($row['attachments'] as $file) { ?>
                            <a target="_blank" href="<?php echo $file['url'];?>"><img title="<?php echo $file['filename'];?>" src="/static/images/pdf.png" style="width:25px;height:25px" alt=""></a>
                            <?php } ?>
                        </td>
                        <td>
                            <a style="font-size: 18px; text-decoration: none" target="_blank" class="ui-icon ui-icon ace-icon fa fa-search-plus" href="/items/show/<?php echo $row['id'];?>">
                                                    </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>