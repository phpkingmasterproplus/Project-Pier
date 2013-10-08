<?php
add_stylesheet_to_page('project/progressbar.css');
$open = 0;
$done = 0;
$total = 0;
$milestones = $project->getMilestones();
if (is_array($milestones)) {
  foreach($milestones as $milestone) {
    $task_lists = $milestone->getTaskLists();
    if (is_array($task_lists)) {
      foreach($task_lists as $task_list) {
        $open += count($task_list->getOpenTasks());
        $done += count($task_list->getCompletedTasks());
        $total += $task_list->countAllTasks();
      }
    }
  }
} // if
if ($total>0) {
  $percent = round($done * 100 / $total);
} else {
  $percent = 0;
} // if
$completed = $project->getCompletedOn();
?>
<?php if ($total>0) { ?>
<?php if (!empty($completed)) { ?>
  <!-- FIXME: hold  -->
  <div class="progressBarCompleted" style="width:100%"></div>
  <div class="progressBarText"><?php echo lang('completed') ?>: <?php echo format_date($completed) ?></div>
<?php } else if ($total > 0) { ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $percent ?>%;"
       aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100">
    <span class="sr-only"><?php echo $percent . '% ' . lang('completed'); ?></span>
  </div>
  <div class="progress-text">
    <?php echo $percent . '% ' . lang('completed') . ' (' . $done . ' of ' . $total . ')'; ?>
  </div>
</div>
<?php } else { ?>
  <!-- FIXME: hold  -->
  <div class="progressBarText"><?php echo lang('open tasks') . ': 0' ?></div>
<?php } // if ?>
<?php } // if ?>