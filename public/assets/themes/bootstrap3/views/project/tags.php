<?php
  set_page_title(lang('tags'));
  project_tabbed_navigation('tags');
  project_crumbs(lang('tags'));
?>

<?php if (isset($tag_names) && is_array($tag_names) && count($tag_names)) { ?>
  <ul class="nav nav-pills">
  <?php foreach ($tag_names as $tag_name) { ?>
    <li>
      <a href="<?php echo active_project()->getTagUrl($tag_name) ?>">
        <?php echo clean($tag_name) ?> (<?php echo active_project()->countObjectsByTag($tag_name); ?>)
      </a>
    </li>
  <?php } // foreach ?>
  </ul>
<?php } else { ?>
  <p><?php echo lang('no tags used on projects') ?></p>
<?php } // if ?>