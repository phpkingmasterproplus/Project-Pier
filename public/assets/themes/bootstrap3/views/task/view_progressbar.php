<?php
if (is_array($task_list->getOpenTasks())) {
  $openTasks = count($task_list->getOpenTasks());
} else {
  $openTasks = 0;
} // if

if (is_array($task_list->getOpenTasks())) {
  $completedTasks = count($task_list->getCompletedTasks());
} else {
  $completedTasks = 0;
} // if

$totalTasks = $task_list->countAllTasks();

if ($totalTasks>0) {
  $percentTasks = round($completedTasks / $totalTasks * 100);
} else {
  $percentTasks = 0;
} // if

$completed = $task_list->getCompletedOn();
?>

<?php if (!empty($completed)) { ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width:100%;"
       aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
    <span class="sr-only"><?php echo lang('completed'); ?></span>
  </div>
  <div class="progress-text">
    <?php echo lang('completed') ?>: <?php echo $completed->format('Y-m-d'); ?>
  </div>
</div>
<?php } else if ($totalTasks > 0) { ?>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo $percentTasks ?>%;"
       aria-valuenow="<?php echo $percentTasks ?>" aria-valuemin="0" aria-valuemax="100">
    <span class="sr-only"><?php echo $percentTasks . '% ' . lang('completed'); ?></span>
  </div>
  <div class="progress-text">
    <?php echo $percentTasks . '% ' . lang('completed') . ' (' . $completedTasks . ' of ' . $totalTasks . ')'; ?>
    <?php if (!is_null($task_list->getDueDate())) { ?>
      &nbsp;<i class="icon icon-exclamation"></i><i class="icon icon-exclamation"></i> <?php echo $task_list->getDueDate()->format('Y-m-d'); ?>
    <?php } // if ?>
  </div>
</div>
<?php } // if ?>