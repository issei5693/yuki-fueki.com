<?php
if (post_password_required()) { return; }
?>
<div class="commments">
<h3>Comment<span>(<?php echo get_comments_number().' 件のコメント'; ?>)</span></h3>
<?php if (have_comments()) :?>
  <ul class="comments-list">
  <?php
    $args = array(
    //'avatar_size'=>0, //アバターを表示しない（管理画面で設定）
      'style'=>'ul',
      'type'=>'comment',
      'callback'=>'mytheme_comments',
    );

    wp_list_comments($args);

    ?>
  </ul>
  <?php if (get_comment_pages_count() > 1) : ?>
  	<ul  class="prev-next tc">
  		<li  class=" prev tc-1"><?php previous_comments_link('&lt;&lt; 前のコメント'); ?></li>
  		<li  class="next tc-2"><?php next_comments_link('次のコメント &gt;&gt;'); ?></li>
  	</ul>
  <?php endif; ?>
<?php endif; ?>
<?php comment_form(); ?>
</div><!-- comments -->
