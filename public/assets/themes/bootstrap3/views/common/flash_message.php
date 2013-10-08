<div class="flash-message">
  <?php if (!is_null(flash_get('success'))) { ?>
    <div id="success"><?php echo clean(flash_get('success')) ?></div>
  <?php } ?>
  <?php if (!is_null(flash_get('error'))) { ?>
    <div id="error"><?php echo clean(flash_get('error')) ?></div>
  <?php } ?>
</div>