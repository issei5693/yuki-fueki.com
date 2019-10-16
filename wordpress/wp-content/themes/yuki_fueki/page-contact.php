<?php
/*
Template Name: contact
Author: issei
*/
?>

<?php get_header(); ?>
<main class="contact">
	<div class="site-width">
	  <div class="contact-form">
		<h2>Contact</h2>
		<?php while(have_posts()): the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		<!-- <form method="" action="">
		  <table>
				<tr><td><input type="text" name="name" placeholder="お名前"></td></tr>
				<tr><td><input type="text" name="mail" placeholder="メールアドレス"></td></tr>
				<tr><td><input type="text" name="subject" placeholder="題名"></td></tr>
				<tr><td><textarea name="content" placeholder="本文を入力してください"></textarea></td></tr>
		  </table>
		  <button type="submit" class="submit-btn">送信</button>
		</form> -->
	  </div>
	</div>
  </main>

<?php get_footer(); ?>
