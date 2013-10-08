<?php $owner_company_name = clean(owner_company()->getName()); ?>
<?php $site_name = config_option('site_name', $owner_company_name); ?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo get_page_title(); ?> | <?php echo $site_name; ?></title>

  <?php echo meta_tag('content-type', 'text/html; charset=utf-8', true); ?>
  <?php echo meta_tag('viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0', true); ?>
  <?php echo render_page_meta(); ?>

  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'shortcut icon', array("type"=>"image/x-icon")); ?>
  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'icon', array("type"=>"image/x-icon")); ?>
  <?php echo link_tag(logged_user()->getRecentActivitiesFeedUrl(), 'rel', 'alternate', array("type"=>"application/rss+xml", "title"=>lang('recent activities feed'))); ?>
  <?php echo render_page_links(); ?>

  <?php echo stylesheet_tag('style.css'); ?>
  <?php echo render_page_inline_css(); ?>

  <?php echo javascript_tag('jquery.min.js'); ?>
  <?php echo javascript_tag('bootstrap.min.js'); ?>
  <?php include('inlinejs.php'); ?>
  <?php echo render_page_javascript(); ?>
  <?php echo render_page_inline_js(); ?>
</head>
<body id="body">
  <?php echo render_system_notices(logged_user()); ?>

  <header>
    <span class="pull-left"><a href="<?php echo get_url('dashboard', 'index') ?>">Dashboard</a></span>
    <?php if(logged_user()->isAdministrator()) { ?>
    <span class="pull-left"><a href="<?php echo get_url('administration') ?>">Admin</a></span>
    <?php } ?>
    <span class="pull-left"><a href="#">Help</a></span>

    <strong><?php echo clean(logged_user()->getDisplayName()) ?></strong>
    <!-- <small>(administrator)</small> -->
    <span class="badge">
      <a title="Open and assigned to me" href="#">
        <i class="icon icon-bug"></i> N/A
      </a>
    </span>
    <span class="badge">
      <a title="Open and reported by me" href="#">
        <i class="icon icon-bullhorn"></i> N/A
      </a>
    </span>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo logged_user()->getAccountUrl() ?>" title="My Account"><i class="icon icon-user"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo get_url('access', 'logout') ?>" class="js-confirm" title="<?php echo lang('confirm logout') ?>" style="margin-right:8px;"><i class="icon icon-signout"></i></a>
  </header>

  <div class="container container-100">
    <div class="flash-message">
      <?php if (!is_null(flash_get('success'))) { ?>
        <div id="success"><?php echo clean(flash_get('success')) ?></div>
      <?php } ?>
      <?php if (!is_null(flash_get('error'))) { ?>
        <div id="error"><?php echo clean(flash_get('error')) ?></div>
      <?php } ?>
    </div>

    <div class="row bg-grey">
      <div class="col-md-9">
        <nav class="navbar">
          <?php if (is_array(tabbed_navigation_items())) { ?>
          <ul class="nav navbar-nav">
          <?php foreach (tabbed_navigation_items() as $tabbed_navigation_item) { ?>
            <li id="tabbed_navigation_item_<?php echo $tabbed_navigation_item->getID() ?>" <?php if ($tabbed_navigation_item->getSelected()) { ?> class="active" <?php } ?>><a href="<?php echo $tabbed_navigation_item->getUrl() ?>"><?php echo clean($tabbed_navigation_item->getTitle()) ?></a></li>
          <?php } // foreach ?>
          </ul>
          <?php } // if ?>
        </nav>

        <div id="content">
          <div class="breadcrumbs">
          <?php if (is_array(bread_crumbs())) { ?>
            <ul>
            <?php foreach (bread_crumbs() as $bread_crumb) { ?>
            <?php if ($bread_crumb->getUrl()) { ?>
              <li><a href="<?php echo $bread_crumb->getUrl() ?>"><?php echo clean($bread_crumb->getTitle()) ?></a> &raquo;</li>
            <?php } else {?>
              <li><a href="#"><span><?php echo clean($bread_crumb->getTitle()) ?></span></a></li>
            <?php } // if {?>
            <?php } // foreach ?>
            </ul>
          <?php } // if ?>
          </div>

          <?php echo $content_for_layout ?>
        </div>
      </div>

      <div class="col-md-3">
        <?php if (isset($content_for_sidebar)) { ?>
        <?php echo $content_for_sidebar ?>
        <?php } // if ?>
      </div>
    </div>

    <div class="fixme hide">
      <div id="pageHeader" class="row">
        <span id="pageTitle"><?php echo get_page_title() ?> - dashboard</span>
        <?php if (is_array(page_actions())) { ?>
        <div id="actionwrap" class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="icon-chevron-down"></i>
          </a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <?php foreach (page_actions() as $page_action) { ?>
              <li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?> - dashboard</a></li>
              <?php } // foreach ?>
          </ul>
        </div>
        <?php } else { // if ?>
        <?php } // if ?>
      </div>
    </div>
  </div>

  <footer class="container">
    <p>
    <?php if (is_valid_url($owner_company_homepage = owner_company()->getHomepage())) { ?>
      <?php echo lang('footer copy with homepage', date('Y'), $owner_company_homepage, clean(owner_company()->getName())) ?>
    <?php } else { ?>
      <?php echo lang('footer copy without homepage', date('Y'), clean(owner_company()->getName())) ?>
    <?php } // if ?>
    </p>
    <p>
      <?php echo product_signature() ?><span id="request_duration">
      <?php printf(' in %.3f seconds', (microtime(true) - $GLOBALS['request_start_time']) ); ?></span>
    </p>
  </footer>

  </body>
</html>