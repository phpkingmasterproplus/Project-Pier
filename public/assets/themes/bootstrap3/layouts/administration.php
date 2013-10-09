<?php $owner_company_name = (owner_company()->getName()) ?>
<?php $site_name = config_option('site_name', $owner_company_name) ?>
<!DOCTYPE html>
<head>
  <title><?php echo get_page_title() ?> | <?php echo clean(owner_company()->getName()) ?></title>

  <?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>

  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'Shortcut Icon', array("type"=>"image/x-icon")) ?>

  <?php echo stylesheet_tag('style.css') ?>

  <?php add_javascript_to_page('pp.js') ?>
  <?php add_javascript_to_page('jquery.min.js') ?>
  <?php add_javascript_to_page('jquery-ui.min.js') ?>
  <?php add_javascript_to_page('jquery.cookie.js') ?>
  <?php add_javascript_to_page('jquery.colorbox-min.js') ?>
  <?php add_javascript_to_page('jquery.imgareaselect.dev.js') ?>
  <?php add_javascript_to_page('jquery.jeditable.mini.js') ?>
  <?php add_javascript_to_page('jquery-ui-timepicker-addon.js') ?>
  <?php echo render_page_head() ?>
</head>

<body>
  <?php include('inlinejs.php'); ?>
  <?php echo render_system_notices(logged_user()) ?>

  <?php $this->includeTemplate(get_template_path('common/header')); ?>

<div class="container container-100">
    <?php $this->includeTemplate(get_template_path('common/flash_message')); ?>

    <div class="row bg-grey">
      <div class="col-md-9">
        <?php $this->includeTemplate(get_template_path('common/nav_bar')); ?>

        <div id="content">
          <?php $this->includeTemplate(get_template_path('common/breadcrumbs')); ?>

          <div class="btn-toolbar">
            <?php include('pageoptions.php'); ?>
          </div>

          <?php echo $content_for_layout ?>
        </div>
      </div>

      <div class="col-md-3">
        <?php if (isset($content_for_sidebar)) { echo $content_for_sidebar; } ?>
      </div>
    </div>
  </div>

  <?php $this->includeTemplate(get_template_path('common/footer')); ?>
  </body>
</html>