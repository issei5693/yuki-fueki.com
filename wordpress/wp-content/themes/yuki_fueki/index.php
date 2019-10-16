<?php get_header(); ?>
<main class="index">
	<div class="site-width">
		<h2 class="h_style">GARELLY</h2>
		<ul class="fl popup-gallery" id="item-list">
      <?php
      $args = array(
        'post_type' => 'top-item',
				'post_status' => 'publish',
				'posts_per_page' => 5, //表示件数,functionでajaxの読み込み数も設定してください。
				'meta_key' => 'display_order',
				'orderby' => array(
					'meta_value_num'=> 'ASC',
					'date'=> 'DESC',
				),
      );

      $the_query = new WP_Query( $args );
      if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <li>
          <?php
          //サムネイルのURLを取得
          $image_id = get_post_thumbnail_id();
          $image_url = wp_get_attachment_image_src($image_id, true)[0];
          ?>
          <a href="<?php if(has_post_thumbnail()){ echo $image_url; } ?>" class="nonmover" title="<?php the_title(); ?>">
            <?php if(has_post_thumbnail()){ the_post_thumbnail(); } ?>
          </a>
          <p style="display: none;">
              <?php echo get_the_content(); ?>
          </p>
        </li>
        <?php
        endwhile;
      endif;
      wp_reset_postdata();
      ?>
		</ul>
		<!-- <button class="more-btn">MORE</button> -->
	</div>
</main>
<?php get_footer(); ?>
