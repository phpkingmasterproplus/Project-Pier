<?php
  trace(__FILE__,'begin');

  set_page_title(lang('my projects'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_MY_PROJECTS);
  dashboard_crumbs(lang('my projects'));

  if (logged_user()->canManageProjects()) {
    add_page_action(lang('add project'), get_url('project', 'add'));
    add_page_action(lang('copy project'), get_url('project', 'copy'));
  } // if

  add_page_action(lang('order by name'), get_url('dashboard', 'my_projects_by_name'));
  add_page_action(lang('order by priority'), get_url('dashboard', 'my_projects_by_priority'));
  add_page_action(lang('order by milestone'), get_url('dashboard', 'my_projects_by_milestone'));
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
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>

<?php foreach ($active_projects as $project) { ?>
<div class="project-card">
  <div><!-- FIXME: unknown -->
  <?php if ($show_icon) { ?>
    <?php if ($project->hasLogo()) { ?>
      <div class="projectLogo">
        <img src="<?php echo $project->getLogoUrl() ?>" alt="<?php echo $project->getName() ?>" />
      </div>
    <?php } // if ?>
  <?php } // if ?>
    <div style="clear:both"></div>
  </div>

  <?php
    $this->assign('project', $project);
  ?>
  <h2>
    <a href="<?php echo $project->getOverviewUrl() ?>">
      <?php echo clean($project->getName()) ?>
    </a>
    <?php if (is_array($project_companies = $project->getCompanies())) { ?>
      <?php
        $project_company_names = array();
        foreach ($project_companies as $project_company) {
          $project_company_names[] = '<a href="' . $project_company->getCardUrl() . '">' . clean($project_company->getName()) . '</a>';
        }
      ?>
      <small class="pull-right">
        <i class="icon icon-puzzle-piece" title="<?php echo lang('companies involved in project') ?>"></i>
        <?php echo implode(', ', $project_company_names) ?>

      <?php if(is_array($project_times = $project->getAllTimes())) {
        $project_time_total = 0;
        foreach($project_times as $project_time) {
          $project_time_total += $project_time->getHours();
        } // foreach
      ?>
        <em><?php echo lang('time spent on project') ?>:</em>
        <?php echo '<a href="' . $project->getTimeReportUrl() . '">' . $project_time_total . ' ' . lang('hour(s)') . '</a>' ?>
      <?php } // if ?>

      <?php if ($project->getCreatedBy() instanceof User) { ?>
          , <i class="icon icon-calendar" title="Started On"></i>
          <?php echo format_date($project->getCreatedOn()); ?>
          , <i class="icon icon-user" title="Started By"></i>
          <a href="<?php echo $project->getCreatedByCardUrl(); ?>"><?php echo clean($project->getCreatedByDisplayName()); ?></a>
      <?php } else { ?>
          <?php echo lang('n/a') ?>
      <?php } // if ?>
      </small>
    <?php } // if involvedCompanies ?>
  </h2>

  <?php if ($project->getShowDescriptionInOverview() && trim($project->getDescription())) { ?>
    <p><?php echo do_textile($project->getDescription()) ?></p>
  <?php } // if ?>

  <?php $this->includeTemplate(get_template_path('view_progressbar', 'project')); ?>
</div>
<?php } // foreach ?>
<?php } else { ?>
  <p><?php echo lang('no active projects in db') ?></p>
<?php } // if ?>

<?php trace(__FILE__,'end'); ?>