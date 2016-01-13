<script type="text/javascript" src="/static/ace/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/static/ace/css/jquery-ui.min.css" />
<link rel="stylesheet" href="/static/css/item_customization.css" />
<div class="page-content">
  <table id="field_list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th class="col-sm-1">序号</th>
        <th class="col-sm-2">标题</th>
        <th class="col-sm-1">类型</th>
        <th class="col-sm-1">生效</th>
        <th class="col-sm-2">更新时间</th>
        <th class="col-sm-1">
          <div class="dropdown">
            <button type="button" id="new-type-dropdown" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i id="add_field" class="ace-icon fa fa-plus-circle bigger-120"></i>添加
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="new-type-dropdown">
              <?php foreach ($declaration as $t => $d) { ?>
              <?php     if ($t > 100) { ?>
              <li><a href="<?php echo base_url('/company/item_customization/new?type=' . $t); ?>"><?php echo $d['type_name']; ?></li>
              <?php     } ?>
              <?php } ?>
            </ul>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($fields as $f) { ?>
      <?php $fd = $f['declaration']; ?>
      <tr data-id="<?php echo $f['id']; ?>" data-frozen="<?php echo $fd['frozen'] ? 'true' : 'false'; ?>">
        <td data-column="sequence"><?php echo $f['sequence']; ?></td>
        <td data-column="title"><?php echo $f['title']; ?></td>
        <td data-column="type_name"><?php echo $fd['type_name']; ?></td>
        <td data-column="toggle">
          <input class="toggle-enabled ace ace-switch" type="checkbox" <?php if ($f['enabled']) { echo 'checked '; } ?><?php if (!$fd['editable_enabled']) { echo 'disabled '; } ?>/>
          <span class="lbl"></span>
        </td>
        <td data-column="lastdt"><?php echo date('Y-m-d H:i:s', $f['lastdt']); ?></td>
        <td data-column="action">
          <a role="button" href="<?php echo base_url('/company/item_customization/edit/' . $f['id']); ?>" class="btn btn-xs btn-info edit_field">
            <i class="ace-icon fa fa-pencil bigger-120"></i>
          </a>
          <?php if ($f['type'] > 100) { ?>
          <button class="btn btn-xs btn-danger delete_field">
            <i class="ace-icon fa fa-trash-o bigger-120"></i>
          </button>
          <?php } ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script type="text/javascript" src="/static/js/item_customized_field_list.js"></script>
