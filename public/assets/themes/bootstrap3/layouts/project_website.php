<?php $owner_company_name = clean(owner_company()->getName()) ?>
<?php $site_name = config_option('site_name', $owner_company_name) ?>
<!DOCTYPE html>
  <head>
  <?php if (active_project() instanceof Project) { ?>
    <title><?php echo get_page_title() ?> | <?php echo clean(active_project()->getName()) ?> | <?php echo clean(owner_company()->getName()) ?></title>
  <?php } else { ?>
    <title><?php echo get_page_title() ?> | <?php echo clean(owner_company()->getName()) ?></title>
  <?php } // if ?>


  <?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

  <?php echo stylesheet_tag('style.css') ?>
  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'Shortcut Icon', array("type"=>"image/x-icon")) ?>

  <?php add_javascript_to_page('pp.js') ?>
  <?php add_javascript_to_page('jquery.min.js') ?>
  <?php add_javascript_to_page('bootstrap.min.js') ?>
  <?php add_javascript_to_page('jquery-ui.min.js') ?>
  <?php add_javascript_to_page('jquery.cookie.js') ?>
  <?php add_javascript_to_page('jquery.colorbox-min.js') ?>
  <?php add_javascript_to_page('jquery.jeditable.mini.js') ?>
  <?php add_javascript_to_page('jquery.imgareaselect.dev.js') ?>
  <?php add_javascript_to_page('jquery-ui-timepicker-addon.js') ?>

  <?php echo render_page_head() ?>
  </head>
  <body>
  <?php include('inlinejs.php') ?>
  <?php // include dirname(__FILE__) . '/memo.php' ?>

  <?php trace(__FILE__,'body begin') ?>

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

            <?php if (use_permitted(logged_user(), active_project(), 'search')) { ?>
              <div class="btn-group col-md-3">
                <form action="<?php echo active_project()->getSearchUrl() ?>" method="get">
                  <input type="hidden" name="c" value="project" />
                  <input type="hidden" name="a" value="search" />
                  <input type="hidden" name="active_project" value="<?php echo active_project()->getId() ?>" />
                  <div class="input-group input-group-sm">
                  <?php
                    $search_field_default_value = lang('search') . '...';
                    $search_field_attrs = array(
                      'class' => 'form-control',
                      'onfocus' => 'if (value == \'' . $search_field_default_value . '\') value = \'\'',
                      'onblur' => 'if (value == \'\') value = \'' . $search_field_default_value . '\'');
                  ?>
                  <?php echo input_field('search_for', array_var($_GET, 'search_for', $search_field_default_value), $search_field_attrs) ?>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-default"><?php echo lang('search button caption') ?></button>
                    </span>
                  </div>
                </form>
              </div>
            <?php } ?>
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