<?php get_header(); ?>
<main class="blog">
  <div class="site-width">
    <h2 class="h_style">BLOG</h2>
    <div class="tc">
      <div class="tc-1">
        <?php
        $args = array(
          'post_type' => 'post',
          'paged'=>get_query_var('paged'),
          //'posts_per_page' => 5
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <section>
            <h3 class="h_style"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="status">
              <span class="date">日付:<?php the_time('Y/m/d'); ?></span>
              <span class="tag"><a href="<?php echo get_category_link( get_the_category()[0]->term_id ); ?>"><?php echo get_the_category()[0]->name;?></a></span>
            </div>
            <div class="fl">
              <div class="fl-1">
                <a href="<?php the_permalink(); ?>">
                  <?php
                  if(has_post_thumbnail()){
                    the_post_thumbnail();
                  } else {
                    echo '<img src="https://placehold.jp/150x150.png">';
                  } ?>
                </a>
              </div>
              <div class="fl-2">
                <p class="text"><?php the_excerpt(); ?></p>
                <p class="more-link"><a href="<?php the_permalink(); ?>">続きを読む</a></p>
              </div>
            </div>
          </section>
          <?php
          endwhile;
        endif;
        wp_reset_postdata();

        ?>

        <?php pagination(3); ?>

      </div>
      <div class="tc-2">
        <?php get_template_part( 'block-1' ); ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
