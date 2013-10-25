<?php
  set_page_title($task_list->isNew() ? lang('add task list') : lang('edit task list'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->isNew() ? lang('add task list') : lang('edit task list'))
  ));
?>

<?php
  // unknown
  // echo open_html_tag('a', array( 'href' => 'javascript:void(0)', 'onclick' => 'javascript:recoverFormInputs();')) . lang('recover last input') . close_html_tag('a');
?>

<?php if ($task_list->isNew()) { ?>
  <form class="form-horizontal" action="<?php echo get_url('task', 'add_list') ?>" method="post">
<?php } else { ?>
  <form class="form-horizontal"  action="<?php echo $task_list->getEditUrl() ?>" method="post">
<?php } // if ?>

  <?php tpl_display(get_template_path('form_errors')) ?>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('name'); ?>
      <span class="required">*</span>
    </label>
    <div class="col-lg-5">
      <?php echo text_field('task_list[name]', array_var($task_list_data, 'name'), array('class' => 'form-control', 'id' => 'taskListFormName')) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('start date'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo pick_date_widget('task_list_start_date', array_var($task_list_data, 'start_date')) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('due date'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo pick_date_widget('task_list_due_date', array_var($task_list_data, 'due_date')) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('priority'); ?>
    </label>
    <div class="col-lg-1">
      <?php echo input_field('task_list[priority]', array_var($task_list_data, 'priority'), array('class' => 'form-control', 'id' => 'taskListFormPriority')) ?>
    </div>
  </div>

  <?php if ( (config_option('enable_efqm')=='yes') && (logged_user()->getProjectPermission($task_list->getProject(), 'tasks-edit_score')) ) { ?>
    <div>
      <?php echo label_tag(lang('score'), 'taskListFormScore') ?>
      <?php echo input_field('task_list[score]', array_var($task_list_data, 'score'), array('class' => 'short', 'id' => 'taskListFormScore')) ?>
      <?php echo '<a href="' . get_url('task', 'edit_score') . '">' . lang('edit score') . '</a>' ?>
    </div>
  <?php } // if ?>

  <div class="form-group">
    <label class="col-lg-2 control-label" for="taskListFormDescription">
      <?php echo lang('description'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo textarea_field('task_list[description]', array_var($task_list_data, 'description'), array('class' => 'form-control', 'id' => 'taskListFormDescription')) ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-lg-2 control-label" for="taskListFormMilestone">
      <?php echo lang('milestone'); ?>
    </label>
    <div class="col-lg-5">
      <?php echo select_milestone('task_list[milestone_id]', active_project(), array_var($task_list_data, 'milestone_id'), array('id' => 'taskListFormMilestone', 'class' => 'form-control')) ?>
    </div>
  </div>

  <?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <div class="form-group">
    <label class="col-lg-2 control-label">
      <?php echo lang('private task list') ?>
      <i class="icon icon-question" title="<?php echo lang('private task list desc') ?>"></i>
    </label>
    <div class="col-lg-5">
      <?php echo yes_no_widget('task_list[is_private]', 'taskListFormIsPrivate', array_var($task_list_data, 'is_private'), lang('yes'), lang('no')) ?>
    </div>
  </div>
  <?php } // if ?>

  <?php if (plugin_active('tags')) { ?>
  <div class="form-group">
    <label class="col-lg-2 control-label" for="taskListFormTags">
      <?php echo lang('tags') ?>
    </label>
    <div class="col-lg-5">
      <?php echo project_object_tags_widget('task_list[tags]', active_project(), array_var($task_list_data, 'tags'), array('id' => 'taskListFormTags', 'class' => 'form-control')) ?>
    </div>
  </div>
  <?php } // if ?>

  <?php if ($task_list->isNew()) { ?>
  <div class="form-group">
    <label for="" class="col-lg-2 control-label">
      <?php echo lang('tasks') ?>
    </label>
    <div class="col-lg-10">
      <table class="table table-condensed table-bordered table-striped">
        <?php for ($i = 0; $i < 3; $i++) { ?>
        <tr>
          <td rowspan="3"><?php echo textarea_field("task_list[task$i][text]", array_var($task_list_data["task$i"], 'text'), array('class' => 'form-control', 'rows' => 5, "placeholder" => '#' . ($i + 1) . ' ' . lang('description'))) ?></td>
          <td><label class="control-label"><i class="icon icon-bullhorn"></label></i></td>
          <td><?php echo pick_date_widget("task_list_task{$i}_start_date", array_var($task_list_data["task$i"], 'start_date')) ?></td>
        </tr>
        <tr>
          <td><label class="control-label"><i class="icon icon-exclamation"></i><i class="icon icon-exclamation"></i></label></td>
          <td><?php echo pick_date_widget("task_list_task{$i}_due_date", array_var($task_list_data["task$i"], 'due_date')) ?></td>
        </tr>
        <tr>
          <td><label class="control-label"><i class="icon icon-user"></i></label></td>
          <td><?php echo assign_to_select_box("task_list[task$i][assigned_to]", active_project(), array_var($task_list_data["task$i"], 'assigned_to'), array('class' => 'form-control')) ?></td>
        </tr>
          <?php // echo label_tag(lang('send notification'), null, false) ?>
          <?php // echo checkbox_field("task_list[task$i][send_notification]", array_var($task_list_data["task$i"], 'send_notification'), array_var($task_list_data["task$i"], 'send_notification')) ?>
        <?php } // for ?>
      </table>
    </div>
  </div>
  <?php } // if ?>

  <div class="form-group">
    <label for="" class="col-lg-2"></label>
    <div class="col-lg-5">
      <button class="btn btn-primary" type="submit"><?php echo $task_list->isNew() ? lang('add task list') : lang('edit task list'); ?></button>
    </div>
  </div>

</form>