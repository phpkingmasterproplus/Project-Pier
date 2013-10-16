<?php
  trace(__FILE__,'start');
  set_page_title(lang('view task'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array(lang('view task'))
  ));

  $options = array();
  if($task->canEdit(logged_user())) {
    $options[] = '<a title="Edit" class="btn btn-default btn-sm" href="' . $task->getEditUrl() . '"><i class="icon icon-fixed-width icon-edit"></i></a>';
  }
  if($task->canDelete(logged_user())) {
    $options[] = '<a title="Delete" class="btn btn-default btn-sm" href="' . $task->getDeleteUrl() . '"><i class="icon icon-fixed-width icon-trash"></i></a>';
  }

  // unknown
  if (plugin_active('time')) {
    if(ProjectTime::canAdd(logged_user(), active_project())) {
      $options[] = '<a href="' . get_url('time', 'add', array( 'task' => $task->getId() ) ) . '">' . lang('add time') . '</a>';
    }
  }

  if($task->canChangeStatus(logged_user())) {
    if ($task->isOpen()) {
      $options[] = '<a title="Close" class="btn btn-default btn-sm" href="' . $task->getCompleteUrl() . '"><i class="icon icon-fixed-width icon-ok"></i></a>';
    } else {
      $options[] = '<a href="' . $task->getOpenUrl() . '">' . lang('open task') . '</a>';
    } // if
  } // if
?>

<div id="taskDetails" class="block">
  <h2>
    <small>#<?php echo $task->getId(); ?></small>
    <?php echo $task->getText(); ?>
  </h2>

  <h5>
    <?php if($task->getAssignedTo()) { ?>
      <i class="icon icon-user"></i> <?php echo clean($task->getAssignedTo()->getObjectName()); ?>
    <?php } // if ?>
    <?php if (!is_null($task->getStartDate())) { ?>
      &nbsp;<i class="icon icon-bullhorn"></i> <?php echo $task->getStartDate()->format('Y-m-d'); ?>
    <?php } // if ?>
    <?php if (!is_null($task->getDueDate())) { ?>
      &nbsp;<i class="icon icon-exclamation"></i><i class="icon icon-exclamation"></i> <?php echo $task->getDueDate()->format('Y-m-d'); ?>
    <?php } // if ?>
  </h5>

  <?php if (count($options)) { ?>
    <div class="btn-toolbar">
      <div class="btn-group">
        <?php echo implode('', $options) ?>
      </div>
    </div>
  <?php } // if ?>
</div>

<?php echo render_object_comments($task, $task->getViewUrl()) ?>