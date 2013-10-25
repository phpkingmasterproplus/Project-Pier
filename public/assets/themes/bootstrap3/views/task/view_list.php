<?php

  set_page_title($task_list->getName());
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName())
  ));
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'));
  } // if
?>
<?php $this->assign('on_list_page', true); ?>

<div class="tasks">
  <table class="table-bordered table-condensed">
    <?php $this->includeTemplate(get_template_path('task_list', 'task')); ?>
  </table>
</div>

<?php echo render_object_comments($task_list, $task_list->getViewUrl()) ?>