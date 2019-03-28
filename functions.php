<?php
// PHP Files
require_once('functions/cus_functions.php');
require_once('functions/init.php');

add_action('init', 'register_blog_cat_custom_post');
function register_blog_cat_custom_post() {
    register_taxonomy(
        'project',
        'post',
        array(
            'hierarchical' => false,
            'label' => 'project',
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'singular_label' => 'project'
        )
    );
}

function remove_parent_theme_actions() {
  remove_action('wp_enqueue_scripts', 'st_enqueue_styles', 10);
  remove_action('wp_enqueue_scripts', 'st_enqueue_scripts', 10);
}
add_action('init','remove_parent_theme_actions');


// if( !is_admin() ){
//   add_action('wp_enqueue_scripts', 'bzb_add_style', 9);
//   function bzb_register_style(){
//
//     wp_register_style( 'base-css', get_template_directory_uri().'/base.css' );
//     wp_register_style( 'main-css', get_stylesheet_directory_uri().'/style.css',array('base-css') );
//   }
//   function bzb_add_style(){
//     bzb_register_style();
//     wp_enqueue_style('base-css');
//     wp_enqueue_style('main-css');
//   }
// }

/* JavaScript
* ---------------------------------------- */

if(!is_admin()) {
  add_action('wp_enqueue_scripts', 'bzb_add_script');
  function bzb_register_script(){
    $thema_pass = get_stylesheet_directory_uri();
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery-cdn', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), '1.11.3', false);
    wp_register_script( 'lazysizes', $thema_pass .'/js/lazysizes.min.js', array('jquery-cdn'), false, true );
    wp_register_script( 'lazysizes-unveilhooks', $thema_pass .'/js/ls.unveilhooks.min.js', array('jquery-cdn'), false, true );
    wp_register_script( 'slick-script', $thema_pass .'/js/slick.min.js', array('jquery-cdn'), false, true );
    wp_register_script( 'iscroll-script', $thema_pass .'/js/iscroll.js', array('jquery-cdn'), false, true );
    wp_register_script( 'drawer-script', $thema_pass .'/js/drawer.min.js', array('jquery-cdn'), false, true );
    wp_register_script( 'rellax-script', $thema_pass .'/js/rellax.min.js', array(), false, true );
    wp_register_script( 'ionicons-script', 'https://unpkg.com/ionicons@4.5.5/dist/ionicons.js', array(), false, true );
    // wp_register_script( 'custom-script', $thema_pass .'/js/custom.js', array('jquery-cdn'), false, true );
    wp_enqueue_script( 'custom-script', $thema_pass.'/js/custom.js?'.filemtime( get_stylesheet_directory().'/js/custom.js'), array('jquery-cdn'));

  }
  function bzb_add_script() {
    bzb_register_script();
    wp_enqueue_script( 'jquery-cdn' );
    wp_enqueue_script( 'lazysizes' );
    wp_enqueue_script( 'lazysizes-unveilhooks' );
    wp_enqueue_script( 'slick-script' );
    wp_enqueue_script( 'rellax-script' );
    wp_enqueue_script( 'iscroll-script' );
    wp_enqueue_script( 'drawer-script' );
    wp_enqueue_script( 'custom-script' );
    // JSへ変数受け渡し
    $queried_object = get_queried_object();
    $bkedata = array(
      'url' => home_url(),
      'term' => $queried_object->slug,
      'taxonomy' => $queried_object->taxonomy
      // 'foundpost' => $wp_query->found_posts
    );
    wp_localize_script( 'custom-script', 'siteinfo', $bkedata );
  }
}

if(!(is_admin() )) {
  function add_async_to_enqueue_script( $url ) {
      if( FALSE === strpos( $url, '.js' ) ) return $url;
      if( strpos( $url, 'jquery.min.js' ) === true ) return $url;
      return "$url' defer charset='UTF-8";
  }
  add_filter( 'clean_url', 'add_async_to_enqueue_script', 11, 1 );
}

// Links
function enqueue_sytle_script() {
  // CSS
  $thema_pass = get_stylesheet_directory_uri();
  wp_enqueue_style('normalize', $thema_pass. '/css/normalize.css', array(), false, 'all' );
  wp_enqueue_style('milligram', $thema_pass.'/css/milligram.min.css', array(), false, 'all');
  wp_enqueue_style('drawer', $thema_pass.'/css/drawer.min.css', array(), false, 'all');
  wp_enqueue_style('slick', $thema_pass.'/css/slick.css', array(), false, 'all');
  // wp_enqueue_style('ionicons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), false, 'all');
  // wp_enqueue_style('style', $thema_pass.'/style.css', array(), false, 'all');
  wp_enqueue_style('style', $thema_pass.'/style.css', array(), filemtime( get_stylesheet_directory().'/style.css' ), 'all');

  // echo '<link rel="shortcut icon" type="image/x-icon" href="'.$thema_pass.'/images/favicon.ico" />'; //ファビコン
  // echo '<link rel="apple-touch-icon" sizes="192x192" href="'.$thema_pass.'/images/touchicon.png" />'; //タッチアイコン
  // JS
}
add_action('wp_enqueue_scripts', 'enqueue_sytle_script');

// 抜粋文字
function st_custom_excerpt_length($length) {
  $excerptcount = 100;
  return $excerptcount;
}

//スマートフォンを判別
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

// メディア画像サイズ　一覧表示用
//add_image_size( 'archive-post-thumbnail', 180, 120 , true );


if( !defined( 'ABSPATH' ) ) {
  exit;
}


function bk_ajax_loadpost(){
    global $wpdb;
    $now_post_num = $_POST['now_post_num'];
    $get_post_num = $_POST['get_post_num'];
    $term = $_POST['term'];
    // 取得したい数より1記事多い記事数取得
    $next_get_post_num = $get_post_num + 1;
    if( $term !== 'WORKS' ) {

      $sql = "SELECT ID, post_title FROM {$wpdb->posts}
      INNER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id
      INNER JOIN {$wpdb->term_taxonomy} ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_id
      INNER JOIN {$wpdb->terms} ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
      WHERE name LIKE '{$term}' AND post_status LIKE 'publish' ORDER BY post_date DESC
      LIMIT %d, %d";
    }

    // タクソノミーで絞るSQL
    // $sql_select = "SELECT ID, post_title FROM {$wpdb->posts} INNER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id INNER JOIN {$wpdb->term_taxonomy} ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_id WHERE taxonomy LIKE 'locations' AND (post_status LIKE 'draft' OR post_status LIKE 'publish' OR post_status LIKE 'private') ORDER BY ID ASC";
    $pre = $wpdb->prepare( $sql, $now_post_num, $next_get_post_num ); // 追記
    $results = $wpdb->get_results($pre);

    $error = 0;
    if ( count( $results ) <= $get_post_num ) {
        $error = 1;
    }

    $ht = '';
    $count = 0;
    $countpost = 0;
    $flg = 0;
    foreach( $results as $result ) {
        ++$countpost;
        if( ( $count % 4 ) === 0 ) {
          echo '<div class="row">';
          $flg = 1;
        }
        ++$count;
        get_template_part( 'post_list' ); //投稿一覧読み込み
        if( ( $count % 4 ) === 0 ) {
          echo '</div>';
          $flg = 0;
        }
        if( $countpost == $get_post_num ) break;
    }
    if( $flg === 1 ) {
      echo '</div>';
    }
    $data = array(
        'error' => $error,
        'html' => $ht,
        'conting' => $term
    );
    $data = json_encode($data);

    // echo $data;
}
function ajax_loadpost() {
  $term = $_POST['term'];
  $paged = $_POST['paged'];
  $queried_object = get_queried_object();
  echo 'aaa'.$queried_object->slug;
  $args = array(
      'post_type' => 'post',
      'category_name' => $term,
      'paged' => $paged
   );

  $the_query = new WP_Query($args);
  if ( $the_query->have_posts() ) :
      while ( $the_query->have_posts() ) : $the_query->the_post();
          ++$countpost;
          if( ( $count % 4 ) === 0 ) {
            echo '<div class="row">';
            $flg = 1;
          }
          ++$count;
          get_template_part( 'post_list' ); //投稿一覧読み込み
          if( ( $count % 4 ) === 0 ) {
            echo '</div>';
            $flg = 0;
          }
          if( $countpost == $get_post_num ) break;
      endwhile;
  else :
      echo '<p>記事がありません</p>';
  endif;
  if( $flg === 1 ) {
    echo '</div>';
  }
}
add_action('wp_ajax_ajax_loadpost', 'ajax_loadpost');
add_action('wp_ajax_nopriv_ajax_loadpost', 'ajax_loadpost');


// 繧ｫ繝�ざ繝ｪ繝ｼ縺斐→縺ｫ險倅ｺ九ｒajax縺ｧ荳隕ｧ縺ｫ蜃ｺ縺�
function ajax_posts_list(){
  $slug = $_POST['slug'];
  $args = array(
    'tag' => $slug
  );
  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
  <dl class="clearfix">
    <dt>
      <a href="<?php the_permalink(); ?>">
        <?php if ( has_post_thumbnail() ): // if it has thumbnail
          the_post_thumbnail('thumbnail');
        else: ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" />
        <?php endif; ?>
      </a>
    </dt>
    <dd>
      <p class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
      <p class="post_date" itemprop="datePublished" datetime="<?php the_time('Y/m/d'); ?>"><?php the_time("'y.m"); ?></p>
      <div class="post_info"><!-- post_list post_info -->
      </div><!-- post_list post_info -->
        <?php //post_get_categories(); ?>
    </dd>
</dl>
<?php
  endwhile;
  else :
    echo 'nothing';
  endif;
  wp_reset_query();
  die();
}
add_action('wp_ajax_ajax_posts_list', 'ajax_posts_list');
add_action('wp_ajax_nopriv_ajax_posts_list', 'ajax_posts_list');

// wp_nav_menu()のクラス変更
add_filter( 'nav_menu_css_class', 'nav_menu_add_class', 10, 2 );
function nav_menu_add_class( $classes, $item ) {
    $classes = array();
    $classes[] = 'column';
    if( $item->current == true ) {
        $classes[] = 'current';
    }
    return $classes;
}

$excludes = array( 1 ); // 未分類ID

function get_breadcrumb() {
  global $post;
  $itemtype = 'http://data-vocabulary.org/Breadcrumb';
  // ポストタイプを取得
  $post_type = get_post_type( $post );

  $bc  = '<ol class="breadcrumb clearfix">';
  $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.home_url().'" itemprop="url"><span itemprop="title">'.get_bloginfo('name').'</span></a></li>';

  if( is_home() ){
    // メインページ
    $bc .= '<li>最新記事一覧</li>';
  }elseif( is_search() ){
    // 検索結果ページ
    $bc .= '<li>「'.get_search_query().'」の検索結果</li>';
  }elseif( is_404() ){
    // 404ページ
    $bc .= '<li>ページが見つかりませんでした</li>';
  }elseif( is_date() ){
    // 日付別一覧ページ
    $bc .= '<li>';
    if( is_day() ){
      $bc .= get_query_var( 'year' ).'年 ';
      $bc .= get_query_var( 'monthnum' ).'月 ';
      $bc .= get_query_var( 'day' ).'日';
    }elseif( is_month() ){
      $bc .= get_query_var( 'year' ).'年 ';
      $bc .= get_query_var( 'monthnum' ).'月 ';
    }elseif( is_year() ){
      $bc .= get_query_var( 'year' ).'年 ';
    }
    $bc .= '</li>';
  }elseif( is_post_type_archive() ){
    // カスタムポストアーカイブ
    $bc .= '<li>'.post_type_archive_title('', false).'</li>';
  }elseif( is_category() ){
    // カテゴリーページ
    $cat = get_queried_object();
    if( $cat -> parent != 0 ){
      $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
      foreach( $ancs as $anc ){
        $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link($anc).'" itemprop="url"><span itemprop="title">'.get_cat_name($anc).'</span></a></li>';
      }
    }
    $bc .= '<li>'.$cat->cat_name.'</li>';
  }elseif( is_tag() ){
    // タグページ
    $bc .= '<li>'.single_tag_title("",false).'</li>';
  }elseif( is_author() ){
    // 著者ページ
    $bc .= '<li>'.get_the_author_meta('display_name').'</li>';
  }elseif( is_attachment() ){
    // 添付ファイルページ
    if( $post->post_parent != 0 ){
      $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_permalink( $post->post_parent ).'" itemprop="url"><span itemprop="title">'.get_the_title( $post->post_parent ).'</span></a></li>';
    }
    $bc .= '<li>'.$post->post_title.'</li>';
  }elseif( is_singular('post') ){
    // 記事ページ
    $cats = get_the_category( $post->ID );
    global $excludes;
    foreach( (array)$cats as $ct ) {
      if( !in_array( $ct->cat_ID, $excludes ) ) {
        $cat = $ct;
      }
    }
    if( $cat ) {
      if( $cat->parent != 0 ){
        $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
        foreach( $ancs as $anc ){
          $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link( $anc ).'" itemprop="url"><span itemprop="title">'.get_cat_name($anc).'</span></a></li>';
        }
      }
      $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link( $cat->cat_ID ).'" itemprop="url"><span itemprop="title">'.$cat->cat_name.'</span></a></li>';
    } else {
        $tags = get_the_tags();
        if( is_array($tags) ) {
          foreach( $tags as $tag ) {
            $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link( $tag->term_id ).'" itemprop="url"><span itemprop="title">'.$tag->name.'</span></a></li>';
          }
        } else {
          $bc .= '';
        }
    }
  }elseif( is_singular('page') ){
    // 固定ページ
    if( $post->post_parent != 0 ){
      $ancs = array_reverse( $post->ancestors );
      foreach( $ancs as $anc ){
        $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_permalink( $anc ).'" itemprop="url"><span itemprop="title">'.get_the_title($anc).'</span></a> /';
      }
    }
    $bc .= '<li>'.$post->post_title.'</li>';
  }elseif( is_singular( $post_type ) ){
    // カスタムポスト記事ページ
    $obj = get_post_type_object($post_type);

    if( $obj->has_archive == true ){
    $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_post_type_archive_link($post_type).'" itemprop="url"><span itemprop="title">'.get_post_type_object( $post_type )->label.'</span></a></li>';
    }
    $bc .= '<li>'.$post->post_title.'</li>';
  }else{
    // その他のページ
    $bc .= '<li>'.$post->post_title.'</li>';
  }

  $bc .= '</ol>';

  echo $bc;
}

// Archive Title
function get_archve_title() {
  $title = '';
  if( is_category() ) {
    $title = single_cat_title();
  } elseif( is_tag() ) {
    $title = single_tag_title();
  } elseif( is_tax() ) {
    $title = single_term_title();
  } elseif( is_day() ) {
    $title = get_the_time( 'Y年m月d日' );
  } elseif( is_month() ) {
    $title = get_the_time( 'Y年m月' );
  } elseif( is_year() ) {
    $title = get_the_time( 'Y年' );
  } elseif( is_author() ) {
    $title = esc_html( get_queried_object()->display_name );
  } elseif( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
    $title = 'Archive';
  }
  return $title;
}


function or_get_category( $getparent = true ) {
    global $excludes;
    $categories = get_the_category();
    if( !empty( $categories ) ) {
        foreach( $categories as $category ) {
            if( !in_array( $category->cat_ID, $excludes ) ) {
                if( $category->parent != 0 ) {
                    $parent = get_term( $category->parent );
                    if( $getparent === true ) {
                      $ht .= '<p class="post-category link-style-border '. $parent->slug .'"><a href="'. get_category_link( $category->parent ) .'">'.  $parent->name .'</a></p>';
                    }
                    $childclass = $parent->slug .'-child';
                }
                $ht .= '<p class="post-category link-style-border '. $childclass .'"><a href="'. get_category_link( $category->cat_ID ) .'">'. $category->cat_name . '</a></p>';
            }
        }
    }
    return $ht;
}
function or_get_terms( $taxonomy ) {
    $terms = get_the_terms( $post->ID, $taxonomy );
    if( !empty( $terms ) ) {
        foreach( $terms as $term ) {
            $ht .= '<a href="'. get_category_link( $term->term_id ) .'" itemprop="url">'. $term->name .'</a>';
        }
    } else {
        return false;
    }
    return $ht;
}

// categoryの取得
function term_child_directly( $taxonomy ) {
    global $excludes;
    $ht = '';
    $args = array(
        'orderby' => 'menu_order',
        'exclude' => $excludes,
        'hide_empty' => false,
        'parent' => 0,
        'taxonomy' => $taxonomy
    );
    $categories = get_categories( $args );
    foreach( $categories as $category ) {
        $ht .= '<div class="column">';
        $ht .= '<div><p class="link-style-border '. $category->slug .'"><a href="'. get_category_link( $category->term_id ) .'">'. $category->name .'</a></p>';
        $params = array( // 親カテゴリIDから子カテゴリーを取得
            'orderby' => 'menu_order',
            'parent' => $category->term_id,
            'hide_empty' => false,
        );
        $cat_childs = get_categories( $params );
        if( $cat_childs ) {
            $ht .= '<div class="category-child">';
            foreach( $cat_childs as $cat_child ) {
                $ht .= '<p class="link-style-border '. $category->slug .'-child ' . $cat_child->slug .'"><a href="'. get_category_link( $cat_child->term_id ) .'">'. $cat_child->name .'</a></p>';
            }
            $ht .= '</div>';
        }
        $ht .= '</div></div>';
    }
    return $ht;
}

// 記事一覧 カテゴリーの子カテゴリ表示
function term_child_directly_1( $term , $empt = true) {
    //term_child_directly( $queried_object );
  wp_reset_postdata();
  $ht = '<div class="locations-relare"><h1 class="heading-relate-locate">「'.$term->name.'」に属するエリア</h1>';
  $ht .= '<div class="locations-children"><ul>';

  $params = array( // 親カテゴリIDから子カテゴリーを取得
    'orderby' => 'menu_order',
    'hide_empty' => $empt,
    'parent' => $term->term_id,
    'taxonomy' => $term->taxonomy
  );
  $term_children = get_terms($params);
  if($term_children) {
    foreach($term_children as $term_child) {
      $catequery = get_posts( array( 'locations' => $term_child->slug ) );
      if($catequery) {
        $ht .= '<li class="ttl-childcategory"><a href="'.get_category_link($term_child->term_id).'">'.$term_child->name.'</a></li>';
      } else {
        $ht .= '<li class="gray-out ttl-childcategory">'.$term_child->name.'</li>';
      }
      wp_reset_postdata();
    }
  } else {
    return null;
  }
  $ht .= '</ul><p class="locate-more-buttom">もっと見る<i class="fa fa-chevron-circle-down" aria-hidden="true"></i></p></div></div>';
  echo $ht;
}
