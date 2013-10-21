<?php
  set_page_title(lang('delete task list'));
  project_tabbed_navigation('tasks');
  project_crumbs(lang('delete task list'));
?>

<form class="form-horizontal" action="<?php echo $task_list->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>
  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
      <?php echo lang('about to delete') ?> <?php echo lc(lang('task list')) ?>
      <strong><?php echo clean($task_list->getName()) ?></strong>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
      <?php echo lang('confirm delete task list') ?>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
      <?php echo yes_no_widget('deleteTaskList[really]', 'deleteTaskListReallyDelete', false, lang('yes'), lang('no')) ?>
    </div>
  </div>

  <div class="form-group">
    <label for="" class="col-lg-2 control-label"><?php echo label_tag(lang('password')) ?></label>
    <div class="col-lg-3">
      <?php echo password_field('deleteTaskList[password]', null, array('id' => 'loginPassword', 'class' => 'form-control')) ?>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10 col-lg-offset-2">
      <button class="btn btn-danger" type="submit"><?php echo lang('delete task list'); ?></button>
      <a class="btn btn-link" href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
    </div>
  </div>
</form>