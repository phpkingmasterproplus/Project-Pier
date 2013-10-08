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