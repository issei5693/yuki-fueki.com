<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- <meta name="description" content="adopt Yoast SEO"> -->
	<?php if( is_archive() && !is_category() ){
		//ブログアーカイブページだけYoast SEOで出力されないのでアーカイブページの時のみ出力
		echo '<meta name="description" content="フリーカメラマン笛木雄樹のサイト「笛木写真館」の「仕事 | BLOG」です。インデックスページ以外にも掲載している日々の様々な写真を掲載していきます。">';
	} ?>
	<!-- <title>adopt Yoast SEO</title> -->
	<link href="<?php bloginfo ('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php bloginfo('template_url'); ?>/css/magnific-popup.css" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<?php wp_head();?>
</head>
<body>
<div id="wrapper">
	<!-- <video src="<?php bloginfo('template_url'); ?>/video/sozai007.mp4" class="bg_video" autoplay loop poster="<?php bloginfo('template_url'); ?>/video/alt_video.jpg"></video> -->
	<div class="perforation">
	<header class="header">
    <div class="site-width">
      <div class="tc">
        <div class="tc-1">
          <h1 class="logo">
            <a href="<?php echo bloginfo('url'); ?>">
              <img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="<?php echo h1_title(); ?>">
            </a>
          </h1>
        </div>
        <div class="tc-2">
          <nav>
            <div id="sp-menu-btn" class="sp-menu-btn"><img src="<?php bloginfo('template_url'); ?>/img/menu_icon.png"></div>
            <ul id="sp-menu" class="tc sp-menu pc-menu">
						<?php
							$site_url = get_bloginfo('url') . '/';
							$now_page_url = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
							?>
              <li><a href="<?php echo get_bloginfo('url'); ?>" class="<?php echo($site_url == $now_page_url?'active':''); ?>">TOP</a></li>
              <li><a href="<?php echo get_the_permalink(2); ?>" class="<?php echo( get_the_permalink(2) == $now_page_url?'active':'' ); ?>">PROFILE</a></li>
              <li><a href="<?php echo get_bloginfo('url') . '/blog/'; ?>" class="
								<?php
									if( is_category()||is_single()):
										echo 'active';
									else:
										echo( get_bloginfo('url') . '/blog/' == $now_page_url?'active':'');
									endif;
								?>">BLOG</a></li>
              <li><a href="<?php echo get_the_permalink(6); ?>" class="<?php echo( get_the_permalink(6) == $now_page_url?'active':'' ); ?>">CONTACT</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
