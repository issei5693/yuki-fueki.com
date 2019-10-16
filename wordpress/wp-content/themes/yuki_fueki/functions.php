<?php
//////////////////////////////////////
//h1タイトルの出力
//////////////////////////////////////
function h1_title(){
  if( is_home() || is_front_page() ):
    $h1_title = 'フリーカメラマン笛木雄樹のサイト「笛木写真館」です。これまでの仕事の一部を公開しています。';
  elseif( is_page(2) ):
    $h1_title = 'フリーカメラマン笛木雄樹のPROFILEページです。';
  elseif( is_page(6) ):
    $h1_title = 'フリーカメラマン笛木雄樹のCONTACTEページです。';
  elseif( is_archive() && !is_category() ):
      $h1_title = 'フリーカメラマン笛木雄樹のBLOGの最新の記事一覧です ';
  elseif( is_category() ):
    $cat_name = get_the_category()[0]->name;
    $h1_title = 'フリーカメラマン笛木雄樹の' . $cat_name . 'に関する記事の一覧';
  elseif( is_single() ):
    $cat_name = get_the_category()[0]->name;
    $post_name = get_the_title();
    $h1_title = 'フリーカメラマン笛木雄樹のBLOG | ' . $cat_name . ' | ' . $post_name . 'です。';
  else:
    $h1_title = 'フリーカメラマン笛木雄樹のサイト「笛木写真館」です。これまでの仕事の一部を公開しています。';
  endif;

  return $h1_title;
}


//////////////////////////////////////
//インデックスのページクエリを変更
//Yoast SEOでindex.phpでprev_nextが出力されてしまうことに対しての対策
//参考：http://sole-color-blog.com/blog/php/222/
//////////////////////////////////////
//このfunctionでクエリをDBに投げる前にクエリの内容を書き換えてもいいけど、WPの表示件数設定で1ページの表示件数を100件とかにしたほうがいいかも
/*
function change_posts_per_page($query) {
    if ( is_admin() || ! $query->is_main_query() ) {
				return;
		}

    if ( $query->is_home() ) {
		 //アーカイブページの時に表示件数を全件にセット
			$query->set( 'posts_per_page', '-1' );
    }

}

add_action( 'pre_get_posts', 'change_posts_per_page' );
*/

//---------------------------------------------------------------------------
//ヘッダーの整理
//---------------------------------------------------------------------------
//絵文字用のコードを無効化
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles');
// WordPressバージョン情報の削除
remove_action('wp_head', 'wp_generator');
// ショートリンクURLの削除
remove_action('wp_head', 'wp_shortlink_wp_head');
// wlwmanifestの削除
remove_action('wp_head', 'wlwmanifest_link');
// application/rsd+xmlの削除
remove_action('wp_head', 'rsd_link');
// RSSフィードのURLの削除
remove_action('wp_head', 'feed_links_extra', 3);

//---------------------------------------------------------------------------
//	管理画面の投稿一覧ページの編集
//---------------------------------------------------------------------------
//投稿一覧にカラムを追加、順番を指定
function add_posts_columns($columns) {
  $columns = array(
  		'cb' => '<input type="checkbox" />',
  		'title' => 'タイトル',
      'date' => '日時',
      'display_order' => '表示順番',
  		'thumbnail' => '画像',
  	);
	return $columns;
}
add_filter( 'manage_edit-top-item_columns', 'add_posts_columns' );

//投稿一覧のテーブルに各投稿ごとに反映させていく（add_posts_columns_listはいらない？コメントアウトしても機能してる・・・・）
function add_posts_columns_list($column_name, $post_id) {		/* ←関数・変数は自由に */
	if ( 'thumbnail' == $column_name ) {
		$thumb = get_the_post_thumbnail($post_id, array(100,100), 'thumbnail');
		echo ( $thumb ) ? $thumb : '?';		/* ←アイキャッチの画像を取得して表示 */
	} elseif ( 'display_order' == $column_name ) {
		echo get_post_meta($post_id, 'display_order', true);		/* ←カスタムフィールドの値を取得して表示 */
	}
}
add_action( 'manage_top-item_posts_custom_column', 'add_posts_columns_list', 10, 2 );		/* ←◯◯◯はカスタム投稿のスラッグ */

//ソート機能をオンにする項目を指定
function add_sort_posts_columns($columns) {
  $columns['display_order'] = 'display_order';
	return $columns;
}
add_filter( 'manage_edit-top-item_sortable_columns', 'add_sort_posts_columns' );

//ソート機能をオンにする・ソートの詳細を設定
function column_orderby_custom( $vars ) {
    if ( isset( $vars['orderby'] ) && 'display_order' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'display_order',
            'orderby' => array(
    					'meta_value_num'=> 'ASC',
    					'date'=> 'DESC',
    				)
        ));
    }
    return $vars;
}
add_filter( 'request', 'column_orderby_custom' );

//---------------------------------------------------------------------------
//	独自カスタムフィールド
//---------------------------------------------------------------------------
//ACFからコピペしてきてください。

//---------------------------------------------------------------------------
//	ページページネーション生成
//---------------------------------------------------------------------------
function pagination( $display_nav_num ) {
    //ページナビの出力は必ず奇数に統一
    if( $display_nav_num % 2 == 0 ){
      $display_nav_num++;
    }

    //現在のページ値
    global $paged;
    $now_page = (empty($paged))? 1 : $paged;

    //クエリの最大ページ数
    global $wp_query;
    $max_page =  (empty($wp_query->max_num_pages))? 1 : $wp_query->max_num_pages;

    //最大ページ数１でない場合はページネーションを表示する
    if( 1 != $max_page ){
      //開始タグ出力
		  echo '<div class="pagenation"><ul>';

      //Prev：現在のページ値が１より大きい場合は/page/を一つ下の数字に戻す「prev」表示(page2以降の時)
      if( $now_page > 1 ) { echo '<li class="prev"><span><a href="' . get_pagenum_link($now_page - 1) . '">Prev</a></span></li>'; }

      //希望表示件数文ページネーション番号を出力
      $balance_num = floor( $display_nav_num / 2 );
      $nav_start_position = $now_page - $balance_num;
      $nav_end_position = $now_page + $balance_num;
      if( $nav_start_position < 1 ){
        $nav_start_position = 1;
        $nav_end_position = ( $display_nav_num <= $max_page )? $display_nav_num : $max_page;
      } else if( $nav_end_position > $max_page ){
        $nav_start_position = ( $max_page - $display_nav_num > 0 )? $max_page - $display_nav_num : 1;
        $nav_end_position = $max_page;
      }

      for( $i = $nav_start_position; $i <= $nav_end_position; $i++ ){
        echo ($now_page == $i)? '<li class=active><span>'.$i.'</span></li>':'<li><span><a href="' . get_pagenum_link($i) . '">' . $i . '</a></span></li>';
     	}

      //Next：総ページ数より現在のページ値が小さい場合は表示
		  if ($now_page < $max_page) echo '<li class="next"><span><a href="' . get_pagenum_link($now_page + 1) . '">Next</a></span></li>';

      //閉タグ出力
      echo '</ul></div>';

      //デバッグ用
      /*
      $p = '<p>%s</p>';
      echo '<div style="border:solid 1px #444;"><p>function.phpデバッグ中</p>';
      echo '<p>$display_nav_numは' . $display_nav_num . '</p>';
      echo '<p>$now_pageは' . $now_page . '</p>';
      echo '<p>$max_pageは' . $max_page . '</p>';
      echo '<p>$nav_start_positionは' . $nav_start_position . '</p>';
      echo '<p>$nav_end_positionは' . $nav_end_position . '</p>';

      echo '</div>'
      */;
    } //ページネーションの出力
}


//---------------------------------------------------------------------------
//	コメントのコールバック関数
//---------------------------------------------------------------------------
function mytheme_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ( 'div' == $args['style'] ) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  }
  ?>
  <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
  <?php if ( 'div' != $args['style'] ) : ?>
  <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>
    <div class="comment-author vcard">
      <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
      <?php printf( __( '<cite class="fn">ID:%s</cite> <!-- <span class="says">のコメント</span> -->' ), get_comment_author_link() ); ?>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br />
    <?php endif; ?>
    <?php comment_text(); ?>
    <div class="comment-meta commentmetadata">
      <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" class="comment_link_style">
        <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
      </a>
      <?php edit_comment_link( __( '(Edit)' ), '  ', '' );
      ?>
    </div>
    <div class="reply">
    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
  <?php if ( 'div' != $args['style'] ) : ?>
  </div>
  <?php endif;
}

//---------------------------------------------------------------------------
//	本文抜粋の文言をフィルターフックで調整
//---------------------------------------------------------------------------
function my_excerpt_length($length) {
	return 160;
}
add_filter('excerpt_length', 'my_excerpt_length');

function my_excerpt_more($more) {
	    return '…';
	}
add_filter('excerpt_more', 'my_excerpt_more');

//---------------------------------------------------------------------------
//	投稿のアーカイブページをインデックス以外で利用できるように設定
//---------------------------------------------------------------------------
add_filter('register_post_type_args', function($args, $post_type) {
    if ('post' == $post_type) {
        global $wp_rewrite;
        $archive_slug = 'blog';
        $args['label'] = 'ブログ';
        $args['has_archive'] = $archive_slug;
        $archive_slug = $wp_rewrite->root.$archive_slug;
        $feeds = '(' . trim( implode('|', $wp_rewrite->feeds) ) . ')';
        add_rewrite_rule("{$archive_slug}/?$", "index.php?post_type={$post_type}", 'top');
        add_rewrite_rule("{$archive_slug}/feed/{$feeds}/?$", "index.php?post_type={$post_type}".'&feed=$matches[1]', 'top');
        add_rewrite_rule("{$archive_slug}/{$feeds}/?$", "index.php?post_type={$post_type}".'&feed=$matches[1]', 'top');
        add_rewrite_rule("{$archive_slug}/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$", "index.php?post_type={$post_type}".'&paged=$matches[1]', 'top');
    }
    return $args;
}, 10, 2);

//---------------------------------------------------------------------------
//	ajax
//---------------------------------------------------------------------------
add_action( "wp_ajax_more_images" , "more_images" );
add_action( "wp_ajax_nopriv_more_images" , "more_images" );

function more_images(){
	$args = array(
    'offset' => 5,
    'post_type' => 'top-item',
    'post_status' => 'publish',
    //'posts_per_page' => -1 //全件表示、指定しない場合はWP側で設定した数が適用される。全権表示するとoffsetが無視される。
    //なので、WP側で1ページの表示件数を100とかにする（インデックスで2ページ目ができてしまうことの防止にもなる。）。
    //'posts_per_page' => -1,
    'meta_key' => 'display_order',
    'orderby' => array(
      'meta_value_num'=> 'ASC',
      'date'=> 'DESC',
    ),
  );
	$the_query = new WP_Query( $args );
	$count = 0;
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id, true)[0];
		$json_array[$count] = array(
			"itemNum" => $count + 1,
			"itemSource" => "
			<li class='loadItem nonmover'>
				<a href='". $image_url ."'>
					<img src='". $image_url ."' alt='". get_the_title() ."'>
				</a>
				<p style='display: none;''>". get_the_content() ."</p>
			</li>"
		);
		$count++;
		endwhile;
	endif;
	wp_reset_postdata();
	// 連想配列($array)をJSONに変換(エンコード)する
	echo $json = json_encode( $json_array ) ;
  die();
}

add_action('wp_enqueue_scripts', 'enqueue_more_images_script');
function enqueue_more_images_script(){
	wp_enqueue_script('moreClickJson', get_bloginfo('template_url').'/js/moreClickJson.js', array('jquery'), '0.1', 'true');
	wp_localize_script('moreClickJson', 'MOREIMGS', array('endpoint' => admin_url('admin-ajax.php')));
}

//---------------------------------------------------------------------------
//	サムネイル使用宣言
//---------------------------------------------------------------------------
add_theme_support( 'post-thumbnails' );

//---------------------------------------------------------------------------
//	get_the_post_thumbnail 使用時に「srcset」が挿入されるのを防ぐ
//---------------------------------------------------------------------------
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

//---------------------------------------------------------------------------
//	カスタムポスト生成
//---------------------------------------------------------------------------
add_action( 'init', 'create_post_type' );
function create_post_type() {

	//トップアイテムのカスタムポストを生成
	register_post_type( 'top-item', //カスタム投稿タイプ名を指定
		array(
			'labels' => array(
				'name' => __( 'トップアイテム' ),
				'singular_name' => __( 'トップアイテムの設定' )
			),
			'public' => true,
			'has_archive' => false, /* アーカイブページを持つ */
			'menu_position' =>4, //管理画面のメニュー順位
			'supports' => array(
        //本文編集はいらないので「editor」はなし、抜粋もいらないので「excerpt 」もなし、
				'title' ,
				'editor',
				//'author',
				'thumbnail',
				'custom-fields',
				//'comments'
			),
      'exclude_from_search' => false, // 検索外に設定
      'publicly_queryable' => false, // フロント側での表示を禁止→リンクはなぜか残ってしまうのでnofollow,sitemapで取り除くこと。
		)
	);

//トップアイテムのカスタムタクソノミを生成
	register_taxonomy(
		'photo', // タクソノミーの名前
		array('top-item'), // 使用するカスタム投稿タイプ名（複数指定は配列で指定）
		array(
			'hierarchical' => true, // trueだと親子関係が使用可能。falseで使用不可
			'update_count_callback' => '_update_post_term_count',
			'label' => '写真',
			'singular_label' => '写真',
			'public' => true,
			'show_ui' => true
		)
	);

 }//function create_post_type()の終了

 /***
  * カスタムフィールドの設定
  */
 if(function_exists("register_field_group"))
 {
   register_field_group(array (
     'id' => 'acf_%e3%83%88%e3%83%83%e3%83%97%e3%82%a2%e3%82%a4%e3%83%86%e3%83%a0',
     'title' => 'トップアイテム',
     'fields' => array (
       array (
         'key' => 'field_591134c36d5e7',
         'label' => '表示順',
         'name' => 'display_order',
         'type' => 'number',
         'instructions' => '表示される順番を指定してください。数が少ないほうが左上に表示されます。
   重複があった場合は日付が新しいほうが左上に表示されます。',
         'required' => 1,
         'default_value' => '',
         'placeholder' => '',
         'prepend' => '',
         'append' => '',
         'min' => '',
         'max' => '',
         'step' => '',
       ),
     ),
     'location' => array (
       array (
         array (
           'param' => 'post_type',
           'operator' => '==',
           'value' => 'top-item',
           'order_no' => 0,
           'group_no' => 0,
         ),
       ),
     ),
     'options' => array (
       'position' => 'normal',
       'layout' => 'no_box',
       'hide_on_screen' => array (
       ),
     ),
     'menu_order' => 0,
   ));
 }
 

?>
