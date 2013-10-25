<?php $page_actions = page_actions() ?>
<?php if (is_array($page_actions)) { ?>
  <div class="btn-group">
    <?php foreach ($page_actions as $page_action) { ?>
      <a class="btn btn-default btn-sm" href="<?php echo $page_action->getURL() ?>">
        <?php echo clean($page_action->getTitle()) ?>
      </a>
    <?php } // foreach ?>
  </div>
<?php } // if ?>

<?php if (is_array(view_options())) { // FIXME: unknown ?>
  <div class="btn-group">
    <?php foreach (view_options() as $view_option) { ?>
      <a class="btn btn-default btn-sm" href="<?php echo $view_option->getURL() ?>">
        <?php echo clean($view_option->getTitle()) ?>
        <!--
          <img src="<?php echo $view_option->getImageURL() ?>" alt="" />
          // FIXME: better use icon
        -->
      </a>
    <?php } // foreach ?>
  </div>
<?php } // if ?>