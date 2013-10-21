<?php
  // ** not now
  // $task_list_options[] = '<a class="btn btn-default btn-sm" href="'. $task_list->getDownloadUrl() .'" title="Download"><i class="icon icon-download-alt"></i></a>';
  // $task_list_options[] = '<a class="btn btn-default btn-sm" href="'. $task_list->getDownloadUrl('pdf') .'">'. lang('pdf') . '</a>';

  // ** unknown
  // if ($task_list->getScore() > 0) {
  //   echo lang('score');
  //   echo $task_list->getScore();
  // } // if

  // ** unknown
  // if ($on_list_page) {
  //   echo lang('completed tasks');
  // } else {
  //   echo lang('recently completed tasks');
  // }
?>

<tr class="task-list-header">
  <td colspan="6">
    <h2 title="<?php if ($task_list->getDescription()) { echo $task_list->getDescription(); } ?>">
      <small>#<?php echo $task_list->getId() ?></small>
      <a href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getName()) ?></a>
      <small>
        <?php if ($cc = $task_list->countComments()) { ?>
          <a href="<?php echo $task_list->getViewUrl(); ?>#objectComments"><i class="icon icon-comments"></i><?php echo $cc; ?></a>
        <?php } // if ?>
        (<?php if ($task_list->isPrivate()) { echo "private"; } ?>)
        <?php if (plugin_active('tags')) { ?>
          &nbsp;&nbsp;&nbsp;&nbsp;<?php echo project_object_tags($task_list, $task_list->getProject()) ?>
        <?php } ?>
      </small>
    </h2>
  </td>
  <td>
    <?php if ($task_list->canEdit(logged_user())) { ?>
      <a href="<?php echo $task_list->getEditUrl(); ?>" title="Edit"><i class="icon icon-fixed-width icon-edit"></i></a>
    <?php } // if ?>
    <?php if ($task_list->canDelete(logged_user())) { ?>
      <a href="<?php echo $task_list->getDeleteUrl(); ?>" title="Delete"><i class="icon icon-fixed-width icon-trash"></i></a>
    <?php } // if ?>
    <?php if (ProjectTaskList::canAdd(logged_user(), active_project())) { ?>
      <a href="<?php echo $task_list->getCopyUrl(); ?>" title="Copy"><i class="icon icon-fixed-width icon-copy"></i></a>
      <a href="<?php echo $task_list->getMoveUrl(); ?>" title="Move"><i class="icon icon-fixed-width icon-cut"></i></a>
    <?php } // if ?>
  </td>
  <td>
    <?php if ($task_list->canAddTask(logged_user())) { ?>
      <a href="<?php echo $task_list->getAddTaskUrl(); ?>" title="Add Task"><i class="icon icon-fixed-width icon-file-alt"></i></a>
    <?php } // if ?>
    <?php if ($task_list->canReorderTasks(logged_user())) { ?>
      <a href="<?php echo $task_list->getReorderTasksUrl($on_list_page); ?>" title="Set Priorities"><i class="icon icon-fixed-width icon-sort-by-order-alt"></i></a>
    <?php } // if ?>
    <?php if (count($task_list_options)) { ?>
      <div class="btn-toolbar">
        <div class="btn-group">
          <?php echo implode('', $task_list_options) ?>
        </div>
      </div>
    <?php } // if ?>
  </td>
</tr>
<tr>
  <td colspan="8">
    <?php $this->includeTemplate(get_template_path('view_progressbar', 'task')); ?>
  </td>
</tr>
<tr>
  <th>#</th>
  <th>Priority</th>
  <th>Subject</th>
  <th>Assigned to</th>
  <th>Created</th>
  <th>Due/Completed</th>
  <th></th>
  <th></th>
</tr>
<?php if (is_array($task_list->getOpenTasks())) { ?>
  <?php foreach ($task_list->getOpenTasks() as $task) { ?>
  <tr>
    <td><?php echo $task->getId(); ?></td>
    <td><span class="task-priority-<?php echo floor($task->getOrder() / 100); ?>"></span></td>
    <td>
      <?php if ($task->canView(logged_user())) { ?>
      <a href="<?php echo $task->getViewUrl($on_list_page); ?>"><?php echo $task->getText(); ?></a>
      <?php } else { echo $task->getText(); }?>
      <?php if ($cc = $task->countComments()) { ?>
        <a title="Comments" href="<?php echo $task->getViewUrl(); ?>#objectComments">
          <i class="icon icon-fixed-width icon-comments"></i> <?php echo $cc; ?>
        </a>
      <?php } ?>
    </td>
    <td>
      <?php if ($task->getAssignedTo()) { ?>
      <a href="<?php echo $task->getAssignedTo()->getCardUrl(); ?>"><?php echo clean($task->getAssignedTo()->getDisplayName()); ?></a>
      <?php } // if ?>
    </td>
    <td><?php if (!is_null($task->getStartDate())) { echo $task->getStartDate()->format("Y-m-d"); } ?></td>
    <td><?php if (!is_null($task->getDueDate())) { echo $task->getDueDate()->format("Y-m-d"); } ?></td>
    <td>
      <?php if ($task->canEdit(logged_user())) { ?>
      <a title="Edit" href="<?php echo $task->getEditUrl(); ?>">
        <i class="icon icon-fixed-width icon-edit"></i>
      </a>
      <?php } // if ?>
      <?php if ($task->canDelete(logged_user())) { ?>
      <a title="Delete" href="<?php echo $task->getDeleteUrl(); ?>">
        <i class="icon icon-fixed-width icon-trash"></i>
      </a>
      <?php } // if ?>
    </td>
    <td>
      <?php if ($task->canChangeStatus(logged_user()) && $task->isOpen()) { ?>
      <a href="<?php echo $task->getCompleteUrl(); ?>">Close</a>
      <?php } // if ?>
    </td>
  </tr>
  <?php } // foreach ?>
<?php } // if ?>
<?php if (is_array($task_list->getCompletedTasks())) { ?>
  <?php $counter = 0; ?>
  <?php foreach ($task_list->getCompletedTasks() as $task) { ?>
  <?php $counter++; ?>
  <?php if ($on_list_page || ($counter <= 5)) { ?>
  <tr class="completed">
    <td><?php echo $task->getId(); ?></td>
    <td></td>
    <td>
      <?php if ($task->canView(logged_user())) { ?>
      <a href="<?php echo $task->getViewUrl($on_list_page); ?>"><?php echo $task->getText(); ?></a>
      <?php } else { echo $task->getText(); } // if ?>
    </td>
    <td>
      <?php if ($task->getCompletedBy()) { ?>
        <a href="<?php echo $task->getCompletedBy()->getCardUrl(); ?>"><?php echo clean($task->getCompletedBy()->getDisplayName()); ?></a>
      <? } // if ?>
    </td>
    <td><?php if (!is_null($task->getStartDate())) { echo $task->getStartDate()->format("Y-m-d"); } ?></td>
    <td><?php echo $task->getCompletedOn()->format("Y-m-d"); ?></td>
    <td>
      <?php if ($task->canEdit(logged_user())) { ?>
        <a title="<?php echo lang('edit'); ?>" href="<?php echo $task->getEditUrl(); ?>"><i class="icon icon-fixed-width icon-edit"></i></a>
      <?php } // if ?>
      <?php if ($task->canDelete(logged_user())) { ?>
        <a title="<?php echo lang('delete'); ?>" href="<?php echo $task->getDeleteUrl(); ?>"><i class="icon icon-fixed-width icon-trash"></i></a>
      <?php } // if ?>
      <?php if ($cc = $task->countComments()) { ?>
        <a href="<?php echo $task->getViewUrl()?>#objectComments"><i class="icon icon-fixed-width icon-comments"></i><?php echo $cc; ?></a>
      <?php } // if ?>
    </td>
    <td>
      <?php if ($task->canChangeStatus(logged_user())) { ?>
        <a href="<?php echo $task->getOpenUrl(); ?>">Re-Open</a>
      <?php } // if ?>
    </td>
  </tr>
  <?php } // if ?>
  <?php } // foreach ?>
  <?php if (!$on_list_page && $counter > 5) { ?>
  <tr class="completed">
    <td colspan="7"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('view all completed tasks', $counter) ?></a></td>
  </tr>
  <?php } // if ?>
<?php } // if ?>