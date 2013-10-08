<?php
  add_stylesheet_to_page('project/task_list.css');
  $task_list_options = array();
  if ($task_list->canEdit(logged_user())) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getEditUrl() . '" title="Edit"><i class="icon icon-edit"></i></a>';
  } // if
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getCopyUrl() . '" title="Copy"><i class="icon icon-copy"></i></a>';
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getMoveUrl() . '" title="Move"><i class="icon icon-move"></i></a>';
  } // if
  if ($task_list->canDelete(logged_user())) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getDeleteUrl() . '" title="Delete"><i class="icon icon-trash"></i></a>';
  } // if
  if ($task_list->canAddTask(logged_user())) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getAddTaskUrl() . '" title="Add Task"><i class="icon icon-file-alt"></i></a>';
  } // if
  if ($task_list->canReorderTasks(logged_user())) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="' . $task_list->getReorderTasksUrl($on_list_page) . '">' . lang('reorder tasks') . '</a>';
  } // if
  if ($cc = $task_list->countComments()) {
    $task_list_options[] = '<a class="btn btn-default btn-sm" href="'. $task_list->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a>';
  }
  $task_list_options[] = '<a class="btn btn-default btn-sm" href="'. $task_list->getDownloadUrl() .'" title="Download"><i class="icon icon-download-alt"></i></a>';
  $task_list_options[] = '<a class="btn btn-default btn-sm" href="'. $task_list->getDownloadUrl('pdf') .'">'. lang('pdf') . '</a>';
?>

<div class="taskList">
<div id="taskList<?php echo $task_list->getId() ?>">
  <h2>
    <small>
      #<?php echo $task_list->getId() ?>
    </small>
    <a href="<?php echo $task_list->getViewUrl() ?>">
      <?php echo clean($task_list->getName()) ?>
    </a>
  </h2>

  <h4><?php if ($task_list->getDescription()) { echo $task_list->getDescription(); } ?></h4>

  <h5>
    <?php if ($task_list->isPrivate()) { echo "private"; } ?>
    <?php if (!is_null($task_list->getDueDate())) { ?>
      &nbsp;<i class="icon icon-exclamation"></i><i class="icon icon-exclamation"></i> <?php echo $task_list->getDueDate()->format('Y-m-d'); ?>
    <?php } // if ?>

    <!-- unknown -->
    <?php if ($task_list->getScore()>0) { ?>
      <div class="score"><span><?php echo lang('score') ?>:</span> <?php echo $task_list->getScore() ?></div>
    <?php } // if ?>

    <?php if (plugin_active('tags')) { ?>
      &nbsp;<i class="icon icon-tags"></i> <?php echo project_object_tags($task_list, $task_list->getProject()) ?>
    <?php } ?>
  </h5>

  <?php $this->includeTemplate(get_template_path('view_progressbar', 'task')); ?>

  <?php if (count($task_list_options)) { ?>
    <div class="btn-toolbar">
      <div class="btn-group">
        <?php echo implode('', $task_list_options) ?>
      </div>
    </div>
  <?php } // if ?>

  <?php if (is_array($task_list->getOpenTasks())) { ?>
    <div class="openTasks">
      <table class="table table-bordered table-condensed table-striped">
        <tr>
          <th>id</th>
          <th>subject</th>
          <th>assigned to</th>
          <th>created</th>
          <th>due date</th>
          <th></th>
        </tr>
        <?php foreach ($task_list->getOpenTasks() as $task) { ?>
        <tr>
          <td><?php echo $task->getId(); ?></td>
          <td>
            <?php if ($task->canView(logged_user())) { ?>
            <a href="<?php echo $task->getViewUrl($on_list_page); ?>"><?php echo $task->getText(); ?></a>
            <?php } else { echo $task->getText(); }?>
          </td>
          <td><?php if ($task->getAssignedTo()) { echo clean($task->getAssignedTo()->getObjectName()); } ?></td>
          <td><?php if (!is_null($task->getStartDate())) { echo $task->getStartDate()->format("Y-m-d"); } ?></td>
          <td><?php if (!is_null($task->getDueDate())) { echo $task->getDueDate()->format("Y-m-d"); } ?></td>
          <td>
            <?php if ($task->canEdit(logged_user())) { ?>
            <a href="<?php echo $task->getEditUrl(); ?>">
              <i class="icon icon-fixed-width icon-edit"></i>
            </a>
            <?php } // if ?>
            <?php if ($task->canDelete(logged_user())) { ?>
            <a href="<?php echo $task->getDeleteUrl(); ?>">
              <i class="icon icon-fixed-width icon-trash"></i>
            </a>
            <?php } // if ?>
            <?php if ($task->canChangeStatus(logged_user()) && $task->isOpen()) { ?>
            <a href="<?php echo $task->getCompleteUrl(); ?>">
              <i class="icon icon-fixed-width icon-ok"></i>
            </a>
            <!-- FIXME: how to re-open task? -->
            <?php } // if ?>
            <?php if ($cc = $task->countComments()) { ?>
              <a href="<?php echo $task->getViewUrl(); ?>#objectComments">
                <i class="icon icon-fixed-width icon-comments"></i> <?php echo $cc; ?>
              </a>
            <?php } ?>
          </td>
        </tr>
        <?php } // foreach ?>
      </table>
    </div>
  <?php } // if ?>

  <div>

<?php if (is_array($task_list->getCompletedTasks())) { ?>
  <div class="completedTasks expand-container-completed">
<?php   if ($on_list_page) { ?>
<?php     echo lang('completed tasks') ?>:
<?php   } else { ?>
<?php     echo lang('recently completed tasks') ?>:
<?php   } // if ?>
    <table class="blank expand-block-completed">
<?php $counter = 0; ?>
<?php foreach ($task_list->getCompletedTasks() as $task) { ?>
<?php $counter++; ?>
<?php if ($on_list_page || ($counter <= 5)) { ?>
      <tr>
        <td class="taskText"><?php echo (do_textile('[' .$task->getId() . '] ' . $task->getText())) ?>
<?php
  $task_options = array();
  if ($task->getCompletedBy()) {
    $task_options[] = '<span class="taskCompletedOnBy">' . lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUrl(), clean($task->getCompletedBy()->getDisplayName())) . '</span>';
  } else {
    $task_options[] = '<span class="taskCompletedOnBy">' . lang('completed on', format_date($task->getCompletedOn())) . '</span>';
  } //if
  if ($task->canEdit(logged_user())) {
    $task_options[] = '<a href="' . $task->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($task->canDelete(logged_user())) {
    $task_options[] = '<a href="' . $task->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($task->canView(logged_user())) {
    $task_options[] = '<a href="' . $task->getViewUrl($on_list_page) . '">' . lang('view') . '</a>';
  } // if
  if ($cc = $task->countComments()) {
    $task_options[] = '<a href="' . $task->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a>';
  }
  if ($task->canChangeStatus(logged_user())) {
      $task_options[] = '<a href="' . $task->getOpenUrl() . '">' . lang('mark task as open') . '</a>';
  } else {
      $task_options[] = '<span>' . lang('completed task') . '</span>';
  } // if
?>
<?php if (count($task_list_options)) { ?>
  <div class="options"><?php echo implode(' | ', $task_options) ?></div>
<?php } // if ?>
        </td>
      </tr>
<?php } // if ?>
<?php } // foreach ?>
<?php if (!$on_list_page && $counter > 5) { ?>
      <tr>
        <td colspan="2"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('view all completed tasks', $counter) ?></a></td>
      </tr>
<?php } // if ?>
    </table>
  </div>
<?php } // if (is_array($task_list->getCompletedTasks())) ?>
</div><?php // div class="taskListExpanded" ?>
</div>
</div>