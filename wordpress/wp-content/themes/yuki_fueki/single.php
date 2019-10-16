<?php get_header(); ?>
<main class="blog single">
    <div class="site-width">
      <h2 class="h_style">BLOG</h2>
      <div class="tc">
        <div class="tc-1">
          <article>
            <h3 class="h_style"><?php the_title(); ?></h3>
            <div class="status">
              <span class="date">日付:<?php the_time('Y/m/d'); ?></span>
              <span class="tag"><a href="<?php get_category_link( $cat ); ?>"><?php echo get_the_category()[0]->name;?></a></span>
            </div>
            <div class="blog-content">
                <a href="<?php if(has_post_thumbnail()){ echo $image_url; } ?>" class="nonmover thmbnail" title="<?php the_title(); ?>">
                  <?php
                  if(has_post_thumbnail()){
                    the_post_thumbnail();
                  } else {
                    echo '<img src="https://placehold.jp/600x400.png">';
                  } ?>
                </a>
              <?php while(have_posts()): the_post(); ?>
                <?php the_content(); ?>
              <?php endwhile; ?>
              <!-- <p class="text"></p> -->
            </div>
          </article>
          <aside>
            <ul class="prev-next tc">
              <li class="prev tc-1"><?php previous_post_link('%link','前の記事へ'); ?></li>
              <li class="next tc-2"><?php next_post_link('%link', '次の記事へ'); ?></li>
            </ul>
          </aside>
          <section>
            <?php comments_template(); ?>
          </section>
        </div>
        <div class="tc-2">
          <ul>
            <?php get_template_part( 'block-1' ); ?>
          </ul>
        </div>
      </div>
    </div>
  </main>

<?php get_footer(); ?>
