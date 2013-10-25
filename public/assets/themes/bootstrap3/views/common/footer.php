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