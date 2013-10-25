<div id="objectComments">
  <h2><?php echo lang('comments') ?></h2>

<?php $comments = $__comments_object->getComments() ?>

<?php if (is_array($comments) && count($comments)) { ?>
<ul>

<?php foreach ($comments as $comment) { ?>
  <li id="comment-<?php echo $comment->getId() ?>">
    <h5>
      <a href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#</a>
      <time><?php echo $comment->getUpdatedOn()->format('Y-m-d H:i'); ?></time>
      <?php $createdBy = $comment->getCreatedBy(); if ($createdBy instanceof User) { ?>
        by <a href="<?php echo $comment->getCreatedByCardUrl(); ?>"><?php echo clean($comment->getCreatedByDisplayName()); ?></a>
      <?php } // if ?>

      <?php if ($comment->isPrivate()) { ?>
        , <?php echo lang('private comment') ?>
      <?php } // if ?>

      <span class="pull-right">
        <?php if ($comment->canEdit(logged_user())) { ?>
          <a href="<?php echo $comment->getEditUrl(); ?>"><i class="icon icon-fixed-width icon-edit"></i></a>
        <?php } ?>
        <?php if ($comment->canDelete(logged_user())) { ?>
          <a href="<?php echo $comment->getDeleteUrl(); ?>" onclick="return confirm('<?php echo lang('confirm delete comment'); ?>')"><i class="icon icon-fixed-width icon-trash"></i></a>
        <?php } ?>
      </span>
    </h5>
    <section>
      <?php if (($createdBy instanceof User) && ($createdBy->getContact()->hasAvatar())) { ?>
        <div class="commentUserAvatar"><img src="<?php echo $createdBy->getContact()->getAvatarUrl() ?>" alt="<?php echo clean($createdBy->getContact()->getDisplayName()) ?>" /></div>
      <?php } // if ?>
      <?php echo plugin_manager()->apply_filters('comment_text', do_textile($comment->getText())) ?>

      <?php echo render_object_files($comment, $comment->canEdit(logged_user())); // unknown ?>
    </section>
  </li>
<?php } // foreach ?>
</ul>

<?php } else { echo do_textile(lang('no comments associated with object')); } // if ?>

<?php if ($__comments_object->canComment(logged_user())) {
  echo render_comment_form($__comments_object);
} ?>

</div>