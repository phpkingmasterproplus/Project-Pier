<!-- unknown
<a href="javascript:void(0)" onclick="javascript:recoverFormInputs();">
  <?php echo lang('recover last input'); ?>
</a>
-->

<form class="form" action="<?php echo Comment::getAddUrl($comment_form_object) ?>" method="post" enctype="multipart/form-data">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <!-- comments closed, but admin is still able to comment -->
  <?php if ($comment_form_object->columnExists('comments_enabled') && !$comment_form_object->getCommentsEnabled() && logged_user()->isAdministrator()) { ?>
    <div class="alert alert-danger"><?php echo lang('admin notice comments disabled') ?></div>
  <?php } // if ?>

  <div class="form-group">
    <textarea class="form-control" id="addCommentText" name="comment[text]"
              rows="3" placeholder="write your comments here"></textarea>
  </div>

  <!-- private comments is invisible to clients -->
  <?php if (logged_user()->isMemberOfOwnerCompany() && !$comment_form_object->getIsPrivate()) { ?>
    <div class="form-group">
      <label><?php echo lang('private comment') ?>:</label>
      <?php echo yes_no_widget('comment[is_private]', 'addCommentIsPrivate', $comment_form_object->getIsPrivate(), lang('yes'), lang('no')) ?>
      &nbsp;&nbsp;&nbsp;&nbsp;<abbr title="<?php echo lang('private comment desc') ?>"><i class="icon icon-question"></i></abbr>
    </div>
  <?php } // if ?>

  <?php
    $this->assign('project', active_project());
    $this->assign('object', $comment_form_object);
    $this->assign('post_data_name', 'comment');
    $this->assign('post_data', $comment_form_comment);
    // $this->includeTemplate(get_template_path('select_receivers', 'notifier'));
  ?>

  <?php if ($comment_form_comment->canAttachFile(logged_user(), active_project())) { ?>
    <?php echo render_attach_files() ?>
  <?php } // if ?>

  <div class="form-group">
    <button class="btn btn-default btn-sm" type="submit">Comment</button>
  </div>
</form>
