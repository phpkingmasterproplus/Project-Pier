<?php if (isset($open_task_lists) && is_array($open_task_lists) && count($open_task_lists)) { ?>
  <div class="sidebarBlock">
    <h2><?php echo lang('open task lists') ?></h2>
    <ul>
    <?php foreach ($open_task_lists as $current_task_list) { ?>
      <li>
        <a href="<?php echo $current_task_list->getViewUrl() ?>">
          <?php echo clean($current_task_list->getName()) ?>
        </a>
        <?php if ($current_task_list->countAllTasks() > 0) { ?>
          (<?php echo $current_task_list->countOpenTasks() . ' of ' . $current_task_list->countAllTasks() . ' ' . lang('open'); ?>)
        <?php } // if ?>
      </li>
    <?php } // foreach ?>
    </ul>
  </div>
<?php } // if ?>

<?php if (isset($completed_task_lists) && is_array($completed_task_lists) && count($completed_task_lists)) { ?>
  <div class="sidebarBlock">
    <h2><?php echo lang('completed task lists') ?></h2>
    <ul>
    <?php foreach ($completed_task_lists as $current_task_list) { ?>
      <li>
        <a href="<?php echo $current_task_list->getViewUrl() ?>">
          <?php echo clean($current_task_list->getName()) ?>
        </a>
        (<?php echo $current_task_list->getCompletedOn()->format('Y-m-d') . trim($desc); ?>
          <?php if ($current_task_list->getCompletedBy()) { ?>
          , by <a href="<?php echo $current_task_list->getCompletedBy()->getCardUrl(); ?>"><?php echo clean($current_task_list->getCompletedBy()->getDisplayName()); ?></a>
          <?php } // if ?>)
      </li>
    <?php } // foreach ?>
    </ul>
  </div>
<?php } // if ?>