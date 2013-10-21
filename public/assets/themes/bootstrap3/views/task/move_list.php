<?php
  set_page_title(lang('move task list'));
  dashboard_tabbed_navigation('tasks');
  project_crumbs(lang('move task list'));
?>

<form class="form-horizontal" action="<?php echo $task_list->getMoveUrl(); ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
      <?php echo lang('about to move') ?> <?php echo lc(lang('task list')) ?>
      <strong><?php echo clean($task_list->getName()) ?></strong>
    </div>
  </div>

  <div class="form-group">
    <label for="moveTaskListFormTargetProjectId" class="col-lg-3 control-label">
      <?php echo lang('task list target project'); ?>
      <span class="required">*</span>
    </label>
    <div class="col-lg-3">
      <?php echo select_project('move_data[target_project_id]', '', array_var($move_data, 'target_project_id'), array('id' => 'moveTaskListFormTargetProjectId', 'class' => 'form-control')) ?>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
      <button class="btn btn-danger" type="submit"><?php echo lang('move task list'); ?></button>
      <a class="btn btn-link" href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
    </div>
  </div>
</form>
