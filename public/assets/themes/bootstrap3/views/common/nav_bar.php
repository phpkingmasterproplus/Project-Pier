<nav class="navbar">
  <?php if (is_array(tabbed_navigation_items())) { ?>
  <ul class="nav navbar-nav">
  <?php foreach (tabbed_navigation_items() as $tabbed_navigation_item) { ?>
    <li id="tabbed_navigation_item_<?php echo $tabbed_navigation_item->getID() ?>" <?php if ($tabbed_navigation_item->getSelected()) { ?> class="active" <?php } ?>><a href="<?php echo $tabbed_navigation_item->getUrl() ?>"><?php echo clean($tabbed_navigation_item->getTitle()) ?></a></li>
  <?php } // foreach ?>
  </ul>
  <?php } // if ?>
</nav>