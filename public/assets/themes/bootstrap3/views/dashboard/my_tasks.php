<?php
  trace(__FILE__,'begin');
  // Set page title and set crumbs to index
  set_page_title(lang('my tasks'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_MY_TASKS);
  dashboard_crumbs(lang('my tasks'));

  add_page_action(lang('group by project'), get_url('dashboard', 'my_tasks'));
  add_page_action(lang('order by name'), get_url('dashboard', 'my_tasks_by_name'));
  add_page_action(lang('order by priority'), get_url('dashboard', 'my_tasks_by_priority'));
  add_page_action(lang('order by milestone'), get_url('dashboard', 'my_tasks_by_milestone'));
?>

<?php
  // If user have any assigned task or milestone this variable will be changed to TRUE
  // else it will remain false
  $has_assigned_tasks = false;
?>

<?php if (is_array(page_actions())) { ?>
<div class="btn-toolbar">
  <div class="btn-group">
    <?php foreach (page_actions() as $page_action) { ?>
      <a class="btn btn-default btn-sm" href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a>
    <?php } // foreach ?>
  </div>
</div>
<?php } ?>

<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) { ?>
<div id="my-tasks">
<?php foreach ($active_projects as $active_project) { ?>
<?php
  $assigned_milestones = $active_project->getUsersMilestones(logged_user());
  $assigned_tasks = $active_project->getUsersTasks(logged_user());
?>
<?php if ((is_array($assigned_milestones) && count($assigned_milestones)) || (is_array($assigned_tasks) && count($assigned_tasks))) { ?>
<?php $has_assigned_tasks = true ?>
  <div class="block">
    <h2>
      <a href="<?php echo $active_project->getOverviewUrl() ?>">
        <?php echo clean($active_project->getName()) ?>
      </a>&nbsp;&nbsp;

      <?php if (is_array($assigned_milestones) && count($assigned_milestones)) { ?>
      <small>
        <a href="<?php echo $active_project->getMilestonesUrl() ?>">
          <i class="icon icon-rocket"></i> <?php echo lang('milestones') ?>
        </a>
      </small>
      <?php } // if ?>

      <?php if (is_array($assigned_tasks) && count($assigned_tasks)) { ?>
      <small>
        <a href="<?php echo $active_project->getTasksUrl() ?>">
          <i class="icon icon-tasks"></i> task lists
        </a>
      </small>
      <?php } // if ?>
    </h2>

    <?php if (is_array($assigned_milestones) && count($assigned_milestones)) { ?>
          <table class="table table-condensed table-bordered table-stripped">
    <?php foreach ($assigned_milestones as $assigned_milestone) { ?>
            <tr>
              <td class="milestoneText">
    <?php $assigned_to = $assigned_milestone->getAssignedTo() ?>
    <?php if ($assigned_to instanceof Company) { ?>
                <span class="assignedTo"><?php echo clean($assigned_to->getName()) ?> | </span>
    <?php } elseif ($assigned_to instanceof User) { ?>
                <span class="assignedTo"><?php echo clean($assigned_to->getDisplayName()) ?> | </span>
    <?php } else { ?>
                <span class="assignedTo"><?php echo lang('anyone') ?> | </span>
    <?php } // if ?>
                <a href="<?php echo $assigned_milestone->getViewUrl() ?>"><?php echo clean($assigned_milestone->getName()) ?></a> -
    <?php if ($assigned_milestone->isUpcoming()) { ?>
                <span><?php echo format_days('days left', $assigned_milestone->getLeftInDays()) ?></span>
    <?php } elseif ($assigned_milestone->isLate()) { ?>
                <span class="error"><?php echo format_days('days late', $assigned_milestone->getLateInDays()) ?></span>
    <?php } elseif ($assigned_milestone->isToday()) { ?>
                <span><?php echo lang('today') ?></span>
    <?php } // if ?>
              <td class="milestoneCheckbox"><?php echo checkbox_link($assigned_milestone->getCompleteUrl(), false) ?></td>
              </td>
            </tr>
    <?php } // foreach?>
          </table>
    <?php } // if ?>

    <?php if (is_array($assigned_tasks) && count($assigned_tasks)) { ?>
      <table class="table table-condensed table-bordered table-striped">
        <tr>
          <th>id</th>
          <th>subject</th>
          <th>assigned to</th>
          <th>due date</th>
          <th></th>
        </tr>
      <?php foreach ($assigned_tasks as $assigned_task) { ?>
        <tr>
          <td><?php echo $assigned_task->getId(); ?></td>
          <td>
            <?php if ($assigned_task->canView(logged_user())) { ?>
              <a href="<?php echo $assigned_task->getViewUrl() ?>"><?php echo $assigned_task->getText(); ?></a>
            <?php } else { echo $assigned_task->getText(); } // if ?>
          </td>
          <td>
            <?php
              $assigned_to = $assigned_task->getAssignedTo();
              if ($assigned_to instanceof Company) {
                echo clean($assigned_to->getName());
              } elseif ($assigned_to instanceof User) {
                echo clean($assigned_to->getDisplayName());
              } else {
                echo lang('anyone');
              }
            ?>
          </td>
          <td>
            <?php
              $taskDueDate = $assigned_task->getDueDate();
              if (!is_null($taskDueDate)) {
                echo $taskDueDate->format("Y-m-d");
              }
            ?>
          </td>
          <td>
            <?php if ($assigned_task->getTaskList() instanceof ProjectTaskList) { ?>
              <?php if ($assigned_task->canEdit(logged_user())) { ?>
                <a href="<?php echo $assigned_task->getEditUrl() ?>" title="<?php echo lang('edit task') ?>">
                  <i class="icon icon-fixed-width icon-edit"></i>
                </a>
              <?php } // if ?>
              <?php if ($assigned_task->canDelete(logged_user())) { ?>
                <a href="<?php echo $assigned_task->getDeleteUrl() ?>" title="<?php echo lang('delete task') ?>" onclick="return confirm('<?php echo lang('confirm delete task') ?>')">
                  <i class="icon icon-fixed-width icon-trash"></i>
                </a>
              <?php } // if ?>
              <?php if ($assigned_task->canChangeStatus(logged_user()) && $assigned_task->isOpen()) { ?>
                <a href="<?php echo $assigned_task->getCompleteUrl() ?>" title="<?php echo lang('mark task as completed') ?>">
                  <i class="icon icon-fixed-width icon-ok"></i>
                </a>
              <?php } // if ?>
              &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $assigned_task->getTaskList()->getViewUrl() ?>" title="Task List: <?php echo clean($assigned_task->getTaskList()->getName()) ?>">
                <i class="icon icon-fixed-width icon-tasks"></i>
              </a>
            <?php } // if ?>
          </td>
        </tr>
      <?php } // foreach ?>
      </table>
    <?php } // if ?>

  </div>
<?php } // if ?>

<?php } // foreach ?>
</div>
<?php } else { ?>
<p><?php echo lang('no active projects in db') ?></p>
<?php } // if  ?>

<?php if (!$has_assigned_tasks) { ?>
<p><?php echo lang('no my tasks') ?></p>
<?php } // if ?>

<?php trace(__FILE__,'end'); ?>