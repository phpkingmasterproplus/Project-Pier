<header>
  <span class="pull-left"><a href="<?php echo get_url('dashboard', 'index') ?>">Dashboard</a></span>
  <span class="pull-left"><a href="<?php echo get_url('dashboard', 'my_projects') ?>">Projects</a></span>
  <span class="pull-left"><a href="<?php echo get_url('dashboard', 'my_tasks') ?>">Tasks</a></span>
  <?php if(logged_user()->isAdministrator()) { ?>
  <span class="pull-left"><a href="<?php echo get_url('administration') ?>">Admin</a></span>
  <?php } ?>
  <span class="pull-left"><a href="#" title="Mannual"><i class="icon icon-question-sign"></i></a></span>

  <strong><?php echo clean(logged_user()->getDisplayName()) ?></strong>
  <!-- <small>(administrator)</small> -->
  <span class="badge">
    <a title="issues assigned to me" href="#">
      <i class="icon icon-bug"></i> N/A
    </a>
  </span>
  <span class="badge">
    <a title="tasks assigned to me" href="#">
      <i class="icon icon-tasks"></i> N/A
    </a>
  </span>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="<?php echo logged_user()->getAccountUrl() ?>" title="My Account"><i class="icon icon-user"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="<?php echo logged_user()->getRecentActivitiesFeedUrl() ?>" title="<?php echo lang('recent activities feed') ?>"><i class="icon icon-rss"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="<?php echo get_url('access', 'logout') ?>" class="js-confirm" title="<?php echo lang('confirm logout') ?>" style="margin-right:8px;"><i class="icon icon-signout"></i></a>
</header>