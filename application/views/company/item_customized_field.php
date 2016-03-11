<link rel="stylesheet" href="/static/ace/css/chosen.css" />
<link rel="stylesheet" href="/static/css/item_customization.css" />
<script type="text/javascript" src="/static/js/item_customized_field.js"></script>
<div class="page-content">
  <?php
  $fd = $field['declaration'];
  
  // 如果configuration中有title类型的字段则隐藏默认名称设置
  $title_overrided = FALSE;
  foreach ($fd['configuration'] as $fc) {
      if ($fc['type'] == 'title') {
          $title_overrided = TRUE;
          break;
      }
  }
  ?>
  <div class="container col-sm-12">
    <form class="form-horizontal" action="<?php echo base_url('/item_customization/save'); ?>" method="post">
      <input type="hidden" name="id" value="<?php if (empty($field['id'])) { echo 0; } else { echo $field['id']; } ?>" />
      <div class="space-12"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">类型</label>
        <div class="col-sm-10">
          <input type="hidden" name="type" value="<?php echo $field['type']; ?>" />
          <select class="form-control" disabled>
            <option value="<?php echo $field['type']; ?>" selected><?php echo $fd['type_name']; ?></option>
          </select>
        </div>
      </div>
      <?php if (!$title_overrided) { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">名称</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="title" name="title" value="<?php echo $field['title']; ?>" <?php if (!$fd['editable_title']) { echo 'disabled '; } ?>/>
        </div>
      </div>
      <?php } ?>
      <?php if ($fd['editable_placeholder']) { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">说明</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="description" value="<?php echo $field['description']; ?>" placeholder="内容将显示在输入框中作为提示，不超过40个字符" maxlength="40" />
        </div>
      </div>
      <?php } ?>
      <div class="space-12"></div>
      <?php foreach ($fd['configuration'] as $fc) { ?>
      <?php if ($fc['type'] == 'link') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">特殊配置</label>
        <div class="col-sm-10">
          <a role="button" class="btn btn-sm btn-primary" href="<?php echo base_url($fc['url']); ?>" target="_blank"><?php echo $fc['text']; ?></a>
        </div>
      </div>
      <?php } elseif ($fc['type'] == 'switch') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $fc['text']; ?></label>
        <div class="col-sm-10 form-group-control">
          <input type="checkbox" class="ace ace-switch" name="extra[<?php echo $fc['name']; ?>]" <?php if (!empty($field['extra'][$fc['name']])) { echo "checked "; } ?>/>
          <span class="lbl"></span>
        </div>
      </div>
      <?php } elseif ($fc['type'] == 'text') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $fc['text']; ?></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="extra[<?php echo $fc['name']; ?>]" value="<?php if (isset($field['extra'][$fc['name']])) { echo $field['extra'][$fc['name']]; } ?>" />
        </div>
      </div>
      <?php } elseif ($fc['type'] == 'title') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $fc['text']; ?></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="title" name="title" value="<?php echo $field['title']; ?>" />
        </div>
      </div>
      <?php } elseif ($fc['type'] == 'tags') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo $fc['text']; ?></label>
        <div class="col-sm-10">
          <div class="tags-editor">
            <div class="row">
              <div class="col-sm-4 pull-left">
                <input type="text" id="tag-input" class="form-control" />
              </div>
              <div class="pull-left">
                <input type="button" id="tag-add" class="btn btn-sm btn-primary" href="#" value="添加" />
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="row">
              <div class="chosen-container chosen-container-multi width-75 form-group-control tags-view" style="height: auto">
                <ul class="chosen-choices" style="min-height: 34px">
                  <?php if (isset($field['extra']['options'])) { ?>
                  <?php     foreach ($field['extra']['options'] as $index => $opt) { ?>
                  <li class="search-choice" data-index="<?php echo $index; ?>" data-id="<?php echo $opt['id']; ?>">
                    <input type="hidden" name="<?php echo 'extra[options][' . $index . '][id]'; ?>" value="<?php echo $opt['id']; ?>" />
                    <input type="hidden" name="<?php echo 'extra[options][' . $index . '][name]'; ?>" value="<?php echo $opt['name']; ?>" />
                    <span><?php echo $opt['name']; ?></span>
                    <a class="search-choice-close"></a>
                  </li>
                  <?php     } ?>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php } ?>
      <div class="space-12"></div>
      <?php if (count($fd['printable']) == 1 && $fd['printable'][0]['name'] == 'default') { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">打印配置</label>
        <div class="col-sm-10">
          <div class="row">
            <label class="col-sm-2 control-label">在Excel中显示</label>
            <div class="form-group-control">
              <input type="checkbox" class="ace ace-switch" name="printable[default][excel]" <?php if (!empty($field['printable']['default']['excel'])) { echo 'checked '; } ?> />
              <span class="lbl"></span>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 control-label">在PDF中显示</label>
            <div class="form-group-control">
              <input type="checkbox" class="ace ace-switch" name="printable[default][pdf]" <?php if (!empty($field['printable']['default']['pdf'])) { echo 'checked '; } ?> />
              <span class="lbl"></span>
            </div>
          </div>
        </div>
      </div>
      <?php } elseif (count($fd['printable']) > 1) { ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">打印配置</label>
        <div class="col-sm-10">
          <div class="table">
            <div class="row">
              <div class="col-sm-2"></div>
              <label class="col-sm-2 control-label">在Excel中显示</label>
              <label class="col-sm-2 control-label">在PDF中显示</label>
            </div>
            <?php     foreach ($fd['printable'] as $p) { ?>
            <div class="row">
              <div class="col-sm-2 align-right"><?php echo $p['text']; ?></div>
              <div class="col-sm-2 form-group-control align-right">
                <input type="checkbox" class="ace ace-switch" name="printable[<?php echo $p['name']; ?>][excel]" <?php if (!empty($field['printable'][$p['name']]['excel'])) { echo 'checked '; } ?>/>
                <span class="lbl"></span>
              </div>
              <div class="col-sm-2 form-group-control align-right">
                <input type="checkbox" class="ace ace-switch" name="printable[<?php echo $p['name']; ?>][pdf]" <?php if (!empty($field['printable'][$p['name']]['pdf'])) { echo 'checked '; } ?>/>
                <span class="lbl"></span>
              </div>
            </div>
            <?php     } ?>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if ($fd['editable_target'] || $fd['editable_required']) { ?>
      <div class="space-12"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">适用范围</label>
        <div class="col-sm-10">
          <div class="row">
            <?php if ($fd['editable_target']) { ?>
            <h4 class="col-sm-4 tree-header">显示</h4>
            <?php } ?>
            <?php if ($fd['editable_required']) { ?>
            <h4 class="col-sm-4 tree-header">必须录入</h4>
            <?php } ?>
          </div>
          <div class="row">
            <?php foreach ([ 'target', 'required', ] as $cf) { ?>
            <?php if ($fd['editable_' . $cf]) { ?>
            <div class="col-sm-4">
              <input type="hidden" name="<?php echo $cf; ?>" value="<?php echo json_encode($field[$cf]); ?>" />
              <ul id="<?php echo $cf . '-tree'; ?>" class="tree" role="tree" aria-expanded="true" aria-checked="false">
                <?php foreach ($sob_tree as $s) { ?>
                <li class="" role="treeitem" data-id="<?php echo -$s['id']; ?>" aria-level="0">
                  <div class="indicator"></div>
                  <div class="checkstate unchecked"></div>
                  <span><?php echo $s['name']; ?></span>
                  <?php if (!empty($s['categories'])) { ?>
                  <ul role="group">
                    <?php foreach ($s['categories'] as $c) { ?>
                    <li class="" role="treeitem" data-id="<?php echo $c['id']; ?>" aria-level="1">
                      <?php if (!empty($c['children'])) { ?>
                      <div class="indicator"></div>
                      <?php } else { ?>
                      <img src="https://api.cloudbaoxiao.com/online/static/<?php echo $c['avatar']; ?>.png" />
                      <?php } ?>
                      <div class="checkstate unchecked"></div>
                      <span><?php echo $c['name']; ?></span>
                      <?php if (!empty($c['children'])) { ?>
                      <ul role="group">
                        <?php foreach ($c['children'] as $cc) { ?>
                        <li role="treeitem" data-id="<?php echo $cc['id']; ?>" aria-level="2">
                          <img src="https://api.cloudbaoxiao.com/online/static/<?php echo $cc['avatar']; ?>.png" />
                          <div class="checkstate unchecked"></div>
                          <span><?php echo $cc['name']; ?></span>
                        </li>
                        <?php } ?>
                      </ul>
                      <?php } ?>
                    </li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li>
                <?php } ?>
              </ul>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
          <button class="btn btn-white btn-primary renew" data-renew="0">
            <i class="glyphicon glyphicon-floppy-disk"></i>
            保存
          </button>
          <a role="button" href="javascript:history.back(-1);"style="position:relative;left:80px;" class="btn btn-white cancel">
            <i class="glyphicon glyphicon-repeat"></i>
            取消
          </a>
        </div>
      </div>
    </form>
  </div>
  <div class="clearfix">
  </div>
</div>
<script type="text/javascript" src="/static/plugins/cloud-dialog/dialog.js"></script>
<link rel="stylesheet" href="/static/plugins/cloud-dialog/dialog.css">