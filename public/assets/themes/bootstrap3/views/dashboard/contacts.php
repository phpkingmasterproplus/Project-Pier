<?php
  // Set page title and set crumbs to index
  set_page_title(lang('contacts'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_CONTACTS);
  dashboard_crumbs(lang('contacts'));
?>

<div id="contactsList">
  <ul class="pagination contact-pagination">
    <?php if ($initial == "") { ?>
      <li class="disabled"><a href="#"><strong><?php echo lang('all'); ?></strong></a></li>
    <?php } else { ?>
      <li><a href="<?php echo get_url('dashboard', 'contacts'); ?>"><?php echo lang('all'); ?></a></li>
    <?php } // if ?>

    <?php if ($initial == "_") { ?>
      <li class="disabled"><a href="#"><strong>#</strong></a></li>
    <?php } elseif (in_array("_", $initials)) { ?>
      <li><a href="<?php echo get_url('dashboard', 'contacts', array('initial' => '_')); ?>">#</a></li>
    <?php } else { ?>
      <li class="disabled"><a href="#">#</a></li>
    <?php } // if ?>

    <?php foreach (range('A', 'Z') as $letter) { ?>
      <?php if ($initial == $letter) { ?>
        <li class="disabled"><a href="#"><strong><?php echo $letter; ?></strong></a></li>
      <?php } elseif (in_array($letter, $initials)) { ?>
        <li><a href="<?php echo get_url('dashboard', 'contacts', array('initial' => $letter)); ?>"><?php echo $letter; ?></a></li>
      <?php } else { ?>
        <li class="disabled"><a href="#"><?php echo $letter; ?></a></li>
      <?php } // if ?>
    <?php } // foreach ?>
  </ul>

<?php if (is_array($contacts)) { ?>
  <table class="table table-bordered table-condensed table-striped">
    <tr>
      <th><?php echo lang('avatar') ?></th>
      <th><?php echo lang('name'); ?></th>
      <th><?php echo lang('company'); ?></th>
      <th><?php echo lang('email address'); ?></th>
      <th><?php echo lang('office phone number'); ?></th>
      <th><?php echo lang('mobile phone number'); ?></th>
      <!-- toggle favorite is removed, search for $contact->isFavorite() -->
    </tr>
  <?php
  foreach ($contacts as $contact) {
    $company = $contact->getCompany();
  ?>
  <tr>
    <td><img src="<?php echo $contact->getAvatarUrl() ?>" width="24" height="24" /></td>
    <td><a href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a></td>
    <td><?php if ($contact->getCompany()) { ?> <a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName(); ?></a> <?php } ?> </td>
    <td><?php if (trim($contact->getEmail()) != '') { ?><a href="mailto:<?php echo $contact->getEmail()?>"><?php echo $contact->getEmail(); ?></a><?php } ?></td>
    <td><?php if (trim($contact->getOfficeNumber()) != '') { echo clean($contact->getOfficeNumber()); } ?></td>
    <td><?php if (trim($contact->getMobileNumber()) != '') { echo clean($contact->getMobileNumber()); } ?></td>
  </tr>
  <?php } // foreach ?>
  </table>
<?php } // if ?>

  <div id="bottom">
    <?php echo advanced_pagination($contacts_pagination, get_url('dashboard', 'contacts', (trim($initial) == '' ? array('page'=> '#PAGE#') : array('page' => '#PAGE#', 'initial' => $initial)))) ?>
  </div>
</div>