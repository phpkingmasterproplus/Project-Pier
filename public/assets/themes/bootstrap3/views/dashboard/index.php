<?php
  trace(__FILE__,':begin');
  // Set page title and set crumbs to index
  set_page_title(lang('dashboard'));
  dashboard_tabbed_navigation();
  dashboard_crumbs(lang('overview'));

  if (logged_user()->canManageProjects()) {
  //if (Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'));
    add_page_action(lang('copy project'), get_url('project', 'copy'));
  } // if

  $lc_in = lc(lang('in'));
?>

<?php if ((isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) || (isset($late_milestones) && is_array($late_milestones) && count($late_milestones))) { ?>
  <div class="alert alert-info">
  <?php if (isset($late_milestones) && is_array($late_milestones) && count($late_milestones)) { ?>
    <h4><?php echo lang('late milestones') ?></h4>
    <ul>
    <?php foreach ($late_milestones as $milestone) { ?>
      <li>
        <?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { echo clean($milestone->getAssignedTo()->getObjectName()); } ?>
        <a class="btn btn-primary btn-xs" href="<?php echo $milestone->getViewUrl() ?>">
          <?php echo clean($milestone->getName()) ?>
        </a>
        <?php echo $lc_in ?>
        <a class="btn btn-primary btn-xs" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>">
          <?php echo clean($milestone->getProject()->getName()) ?>
        </a>
        (<?php echo format_days('days late', $milestone->getLateInDays()) ?>)
      </li>
    <?php } // foreach ?>
    </ul>
  <?php } // if ?>

  <?php if (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) { ?>
    <h4><?php echo lang('today') ?></h4>
    <ul>
    <?php foreach ($today_milestones as $milestone) { ?>
      <li>
        <?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { echo clean($milestone->getAssignedTo()->getObjectName()); } ?>
        <a class="btn btn-primary btn-xs" href="<?php echo $milestone->getViewUrl() ?>">
          <?php echo clean($milestone->getName()) ?>
        </a>
        <?php echo $lc_in ?>
        <a class="btn btn-primary btn-xs" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>">
          <?php echo clean($milestone->getProject()->getName()) ?>
        </a>
        (<?php echo format_days('days late', $milestone->getLateInDays()) ?>)
      </li>
    <?php } // foreach ?>
    </ul>
  <?php } // if ?>
  </div>
<?php } // if ?>

<?php
  // PLUGIN HOOK
  plugin_manager()->do_action('dashboard_content', $this);
?>

<?php
if (config_option('per_project_activity_logs',0) == 1) {
  if (isset($projects_activity_log) && is_array($projects_activity_log) && count($projects_activity_log)) {
    foreach ($projects_activity_log as $activity_log) {
      if (isset($activity_log) && is_array($activity_log) && count($activity_log)) {
        $project = $activity_log[0]->getProject();
        echo render_project_application_logs($project,$activity_log);
      } //if
    } //foreach $project
  } else {
    echo lang('no recent activities');
  } // if
} else {
  if (isset($activity_log) && is_array($activity_log) && count($activity_log)) {
    echo render_application_logs($activity_log, array('show_project_column' => true));
  } else {
    echo lang('no recent activities');
  } // if
} //if
?>