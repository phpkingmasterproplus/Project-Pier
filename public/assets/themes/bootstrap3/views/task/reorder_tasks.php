<?php
  set_page_title(lang('reorder tasks'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array(lang('reorder tasks'))
  ));
?>

<div class="reorder-tasks">
  <h3>200-Now, 300-Next, 400-Todo, 500-Normal, 700-Later, 800-If Ever</h3>
  <form class="form-horizontal" action="<?php echo $task_list->getReorderTasksUrl($back_to_list) ?>" method="post">
    <div class="form-group">
      <label class="col-lg-1">
        <?php echo lang('priority') ?>
      </label>
      <label class="col-lg-11">
        <?php echo lang('task') ?>
      </label>
    </div>

    <?php foreach ($tasks as $task) { ?>
    <div class="form-group">
      <div class="col-lg-1">
        <?php echo text_field('task_' . $task->getId(), $task->getOrder(), array('class' => 'form-control input-sm')) ?>
      </div>
      <div class="col-lg-11">
        <?php echo clean($task->getText()) ?>
      </div>
    </div>
    <?php } // foreach ?>

    <div class="form-group">
      <div class="col-lg-12">
        <button class="btn btn-default" type="submit">Set Priorities</button>
      </div>
    </div>
    <input type="hidden" name="submitted" value="submitted" />
  </form>
</div>