<?php
  set_page_title($task->isNew() ? lang('add task') : lang('edit task'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array($task->isNew() ? lang('add task') : lang('edit task'))
  ));
?>

<?php if ($task->isNew()) { ?>
  <form class="form-horizontal" action="<?php echo $task_list->getAddTaskUrl($back_to_list) ?>" method="post">
<?php } else { ?>
  <form class="form-horizontal" action="<?php echo $task->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <?php if (!$task->isNew()) { ?>
  <div class="form-group">
    <label for="" class="col-lg-2 control-label">
      <?php echo lang('task list'); ?>
      <span class="required">*</span>
    </label>
    <div class="col-lg-5">
      <?php echo select_task_list('task[task_list_id]', active_project(), array_var($task_data, 'task_list_id'), false, array('id' => 'addTaskTaskList', 'class' => 'form-control')) ?>
    </div>
  </div>
  <?php } // if ?>

  <div class="form-group">
    <label for="" class="col-lg-2 control-label">
      <?php echo lang('text') ?>
      <span class="required">*</span>
    </label>
    <div class="col-lg-5">
      <?php echo textarea_field("task[text]", array_var($task_data, 'text'), array('id' => 'addTaskText', 'class' => 'form-control')) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('start date'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo pick_date_widget('task_start_date', array_var($task_data, 'start_date', array('class' => 'form-control' ))) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('due date'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo pick_date_widget('task_due_date', array_var($task_data, 'due_date', array('class' => 'form-control' ))) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('assign to'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo assign_to_select_box("task[assigned_to]", active_project(), array_var($task_data, 'assigned_to'), array('class' => 'form-control' )) ?>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-5">
      <button class="btn btn-default" type="submit"><?php echo $task->isNew() ? lang('add task') : lang('edit task'); ?></button>
    </div>
  </div>

<?php
  // echo label_tag(lang('send notification'), 'sendNotification', false);
  // echo checkbox_field('task[send_notification]', array_var($task_data, 'send_notification'), array_var($task_data, 'send_notification'));
?>
</form>