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

  <?php $this->includeTemplate(get_template_path('common/header')); ?>

  <div class="container container-100">
    <?php $this->includeTemplate(get_template_path('common/flash_message')); ?>

    <div class="row bg-grey">
      <div class="col-md-9">
        <?php $this->includeTemplate(get_template_path('common/nav_bar')); ?>

        <div id="content">
          <?php $this->includeTemplate(get_template_path('common/breadcrumbs')); ?>

          <?php echo $content_for_layout ?>
        </div>
      </div>

      <div class="col-md-3">
        <?php if (isset($content_for_sidebar)) { echo $content_for_sidebar; } ?>
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

  <?php $this->includeTemplate(get_template_path('common/footer')); ?>

  </body>
</html>