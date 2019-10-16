<?php
/*
Template Name: profile
Author: issei
*/
?>

<?php get_header(); ?>
<main class="profile">
	<div class="site-width">
		<h2 class="h_style">PROFILE</h2>
		<div class="tc">
			<div class="tc-1">
				<figure id="profile_image">
				<img src="<?php bloginfo('template_url'); ?>/img/profile.jpg">
				</figure>
			</div>
			<div class="tc-2">
				<section>
				<?php while(have_posts()): the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
				</section>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
