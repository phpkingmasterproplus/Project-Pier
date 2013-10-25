<?php
  $canEdit = $ticket->canEdit(logged_user());
  // Set page title and set crumbs to index
  $title = $canEdit ? 'edit ticket' : 'view ticket';
  set_page_title(lang($title));
  project_tabbed_navigation(PROJECT_TAB_TICKETS);

  if(ProjectTicket::canAdd(logged_user(), active_project())) {
    add_page_action(lang('delete ticket'), $ticket->getDeleteUrl());
  }

  $crumbs = array(array(lang('tickets'), get_url('tickets')));
  if ($ticket->isClosed()) {
    $crumbs[] = array(lang('closed tickets'), ProjectTickets::getIndexUrl(true));
  }
  $crumbs[] = array(lang($title));
  project_crumbs($crumbs);
?>
<?php if($ticket->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private ticket') ?>"><span><?php echo lang('private ticket') ?></span></div>
<?php } // if ?>

<h2>
  <small><?php echo lang('ticket #', $ticket->getId()); ?></small>
  <?php echo clean($ticket->getSummary()); ?>
</h2>

<h5>
  <i class="icon icon-bullhorn"></i>
  <?php if (is_null($ticket->getCreatedBy())) {
    echo $ticket->getCreatedByDisplayName();
  } else { ?>
  <a href="<?php echo $ticket->getCreatedBy()->getCardUrl(); ?>">
    <?php echo $ticket->getCreatedByDisplayName(); ?>
  </a>
  <?php } ?>

  <i class="icon icon-file-alt"></i>
  <?php echo $ticket->getCreatedOn()->format('Y-m-d'); ?>

  <i class="icon icon-file-text-alt"></i>
  <?php if (is_null($ticket->getUpdatedBy())) {
    echo $ticket->getUpdatedByDisplayName();
  } else { ?>
    <?php echo $ticket->getUpdatedOn()->format('Y-m-d'); ?>
  <?php } // if?>
</h5>

<form action="<?php echo $ticket->getEditUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>
  <table class="table table-bordered table-condensed table-striped">
    <tr>
      <th><?php echo label_tag(lang('assigned to'), 'ticketFormAssignedTo') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo assign_to_select_box("ticket[assigned_to]", active_project(), array_var($ticket_data, 'assigned_to'), array('id' => 'ticketFormAssignedTo', 'class' => 'form-control')) ?></td>
      <?php } else { ?>
      <td><?php if($ticket->getAssignedTo()) { echo clean($ticket->getAssignedTo()->getObjectName()); } ?></td>
      <?php } // if?>

      <th><?php echo label_tag(lang('priority'), 'ticketFormPriority') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo select_ticket_priority("ticket[priority]", array_var($ticket_data, 'priority'), array('id' => 'ticketFormPriority', 'class' => 'form-control')) ?></td>
      <?php } else { ?>
      <td><?php echo lang($ticket->getPriority()); ?></td>
      <?php } // if?>

      <td>
        <?php // echo lang($ticket->getStatus()); ?>
        <?php if ($ticket->canChangeStatus(logged_user())) {
          if ($ticket->isClosed()) {
            echo '<a href="' . $ticket->getOpenUrl() . '">' . lang('open ticket') . '</a>';
          } else {
            echo '<a href="' . $ticket->getCloseUrl() . '">' . lang('close ticket') . '</a>';
          }
        } // if ?>
      </td>
    </tr>

    <tr>
      <th><?php echo label_tag(lang('status'), 'ticketFormState') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo select_ticket_state("ticket[state]", array_var($ticket_data, 'state'), array('id' => 'ticketFormState', 'class' => 'form-control')); ?></td>
      <?php } else { ?>
      <td><?php echo lang($ticket->getState()); ?></td>
      <?php } // if?>

      <th><?php echo label_tag(lang('milestone'), 'ticketFormMilestone') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo select_milestone("ticket[milestone_id]", $ticket->getProject(), array_var($ticket_data, 'milestone_id'), array('id' => 'ticketFormMilestone', 'class' => 'form-control')) ?></td>
      <?php } else { ?>
      <td><?php if($ticket->getMilestoneId()) { echo lang($ticket->getMilestoneId()->getObjectName()); }?></td>
      <?php } // if?>

      <td><!-- placeholder --></td>
    </tr>

    <tr>
      <th><?php echo label_tag(lang('type'), 'ticketFormType') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo select_ticket_type("ticket[type]", array_var($ticket_data, 'type'), array('id' => 'ticketFormType', 'class' => 'form-control')) ?></td>
      <?php } else { ?>
      <td><?php echo lang($ticket->getType()); ?></td>
      <?php } // if?>

      <th><?php echo label_tag(lang('category'), 'ticketFormCategory') ?></th>
      <?php if ($canEdit) { ?>
      <td><?php echo select_ticket_category("ticket[category_id]", $ticket->getProject(), array_var($ticket_data, 'category_id'), array('id' => 'ticketFormCategory', 'class' => 'form-control')) ?></td>
      <?php } else { ?>
      <td><?php if($ticket->getCategory()) { echo clean($ticket->getCategory()->getName()); } ?></td>
      <?php } // if?>

      <td><!-- placeholder --></td>
    </tr>

    <tr>
      <th><?php echo lang('summary'); ?>:</th>
      <td colspan="4">
        <?php if ($canEdit) {
          echo text_field('ticket[summary]', array_var($ticket_data, 'summary'), array('id' => 'ticketFormSummary', 'class' => 'form-control'));
        } else {
          echo clean($ticket->getSummary());
        } // if ?>
      </td>
    </tr>

    <tr>
      <!-- FIXME: why is this not editable -->
      <th><?php echo lang('description') ?>:</th>
      <td colspan="4"><?php echo do_textile($ticket->getDescription()); ?></td>
    </tr>

    <tr>
      <td colspan="5">
      <?php if ($canEdit) { ?>
        <button class="btn btn-default" type="submit"><?php echo $ticket->isNew() ? lang('add ticket') : lang('save'); ?></button>
      <?php } // if ?>
      </td>
    </tr>
  </table>
</form>

<div>
  <?php echo render_object_files($ticket, $ticket->canEdit(logged_user())) ?>
</div>

<div id="messageComments"><?php echo render_object_comments($ticket, $ticket->getViewUrl()) ?></div>

<?php if(isset($changes) && is_array($changes) && count($changes)) { ?>
<div id="changelog" class="block">
  <h2><?php echo lang('history') ?></h2>
  <table class="table table-bordered table-condensed table-striped">
    <tr>
      <th><?php echo lang('field') ?></th>
      <th><?php echo lang('old value') ?></th>
      <th><?php echo lang('new value') ?></th>
      <th><?php echo lang('user') ?></th>
      <th><?php echo lang('change date') ?></th>
    </tr>
    <?php foreach($changes as $change) { ?>
    <tr>
      <td><?php echo lang($change->getType()) ?></td>

      <?php if ($change->dataNeedsTranslation()) { ?>
      <td class="oldValue" style="max-width:200px"><?php echo lang($change->getFromData()) ?></td>
      <td class="newValue" style="max-width:200px"><?php echo lang($change->getToData()) ?></td>
      <?php } else { ?>
      <td class="oldValue" style="max-width:200px"><?php echo $change->getFromData() ?></td>
      <td class="newValue" style="max-width:200px"><?php echo $change->getToData() ?></td>
      <?php } // if ?>

      <td><?php echo $change->getCreatedByDisplayName() ?></td>
      <td><?php echo $change->getCreatedOn()->format('Y-m-d') ?></td>
    </tr>
    <?php } // foreach ?>
  </table>
</div>
<?php } else { echo do_textile(lang('no changes in ticket')); } // if ?>
