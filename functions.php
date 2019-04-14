<?php
// PHP Files
require_once('functions/init.php');

/* JavaScript
* ---------------------------------------- */
if( !is_admin() ) {
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
        $sitedata = array(
            'url' => home_url(),
            'term' => $queried_object->slug,
            'taxonomy' => $queried_object->taxonomy
            // 'foundpost' => $wp_query->found_posts
        );
        wp_localize_script( 'custom-script', 'sitedata', $sitedata );
    }
    add_filter( 'clean_url', 'add_async_to_enqueue_script', 11, 1 );
    function add_async_to_enqueue_script( $url ) {
        if( FALSE === strpos( $url, '.js' ) ) return $url;
        if( strpos( $url, 'jquery.min.js' ) === true ) return $url;
        return "$url' defer charset='UTF-8";
    }
}

add_action('wp_enqueue_scripts', 'enqueue_sytle_script');
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

function ajax_loadpost() {
    $term = $_POST['term'];
    $paged = $_POST['paged'];
    if( !empty($term) ) {
        $args = array(
            'post_type' => 'post',
            'category_name' => $term,
            'paged' => $paged
        );
    } else {
        $args = array(
            'paged' => $paged,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post'
        );
    }

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
