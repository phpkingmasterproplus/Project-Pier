<?php
  trace(__FILE__, 'start');
?>

<?php if (isset($application_logs_entries) &&
          is_array($application_logs_entries) &&
          count($application_logs_entries)) { ?>

<div class="application-events">
  <h3>Latest 20 events</h3>

  <table class="table table-bordered table-condensed table-striped">
  <tr>
    <th><?php echo lang('application log date column name') ?></th>
    <th><?php echo lang('application log by column name') ?></th>
    <th><?php echo lang('application log type column name') ?></th>
    <th><?php echo lang('application log details column name') ?></th>
    <?php if ($application_logs_show_project_column) { ?>
    <th><?php echo lang('application log project column name') ?></th>
    <?php } // if ?>
  </tr>

<?php
  $prev = new ApplicationLog();
  // FIXME: use frontend js table lib to handle pagination
  $latest_20_events = array_slice($application_logs_entries, 0, 20);
  foreach ($latest_20_events as $application_log_entry) {
    // skip log lines about the same object and same action
    // note: lines are ordered on creation date. any other order messes this up
    $cur = $application_log_entry;
    if ($cur->getTakenById() == $prev->getTakenById()) {
      if ($cur->getProjectId() == $prev->getProjectId()) {
        if ($cur->getRelObjectId() == $prev->getRelObjectId()) {
          if ($cur->getRelObjectManager() == $prev->getRelObjectManager()) {
            if ($cur->getAction() == $prev->getAction()) {
              continue;  // skip this log entry cause it is about the same object and same action
            }
          }
        }
      }
    }
    $prev = $cur;

    $objtype = strtolower($application_log_entry->getObjectTypeName());
    $objtype = strtr($objtype, ' ', '-');
?>
  <tr class="<?php echo $objtype ?>">
    <td class="logTakenOnBy"><?php echo render_action_taken_on_by($application_log_entry); ?></td>

  <?php if (config_option('logs_show_icons')) { ?>
    <td class="logTypeIcon">
      <i class="icon icon-" title="<?php echo $application_log_entry->getObjectTypeName() ?>"></i>
    </td>
  <?php } else { ?>
    <td class="logTypeIcon"><?php echo $application_log_entry->getObjectTypeName(); ?></td>
  <?php } // if ?>

  <?php if ($application_log_entry_url = $application_log_entry->getObjectUrl()) { ?>
    <td class="logDetails"><a href="<?php echo $application_log_entry_url ?>"><?php echo clean($application_log_entry->getText()) ?></a></td>
  <?php } else { ?>
    <td class="logDetails"><?php echo clean($application_log_entry->getText()) ?></td>
  <?php } // if ?>

  <?php if ($application_logs_show_project_column) { ?>
    <td class="logProject">
  <?php if (($application_log_entry_project = $application_log_entry->getProject()) instanceof Project) { ?>
      <a href="<?php echo $application_log_entry_project->getOverviewUrl() ?>"><?php echo clean($application_log_entry_project->getName()) ?></a>
  <?php } // if ?>
    </td>
  <?php } // if ?>
  </tr>
<?php } // foreach ?>
</table>
</div>
<?php } // if ?>