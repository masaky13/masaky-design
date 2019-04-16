<?php
// header内・不必要なリンクの削除
remove_action( 'wp_head', 'wp_generator' ); // Wordpress version
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); // post shortcode URL
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // 絵文字 CSS
remove_action( 'wp_print_styles', 'print_emoji_styles' ); // 絵文字 Jacascript
remove_action( 'wp_head', 'rsd_link' ); // Really Simple Discovery
remove_action( 'wp_head', 'wlwmanifest_link' ); // Windows Live Writer
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' ); // 前後の記事 link URL
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

if( !is_admin() ) {
    /* Javascript
    * ------------------------------ */
    add_action('wp_enqueue_scripts', 'add_script');
    function register_script(){
        $thema_pass = get_stylesheet_directory_uri();
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery-cdn', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), '1.11.3', false);
        wp_register_script( 'lazysizes', $thema_pass .'/js/lazysizes.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'lazysizes-unveilhooks', $thema_pass .'/js/ls.unveilhooks.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'slick', $thema_pass .'/js/slick.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'iscroll', $thema_pass .'/js/iscroll.js', array('jquery-cdn'), false, true );
        wp_register_script( 'drawer', $thema_pass .'/js/drawer.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'rellax', $thema_pass .'/js/rellax.min.js', array(), false, true );
        // wp_register_script( 'custom', $thema_pass .'/js/custom.js', array('jquery-cdn'), false, true );
        wp_enqueue_script( 'custom', $thema_pass.'/js/custom.js?'.filemtime( get_stylesheet_directory().'/js/custom.js'), array('jquery-cdn'));
    }
    function add_script() {
        register_script();
        wp_enqueue_script( 'jquery-cdn' );
        wp_enqueue_script( 'lazysizes' );
        wp_enqueue_script( 'lazysizes-unveilhooks' );
        wp_enqueue_script( 'slick' );
        wp_enqueue_script( 'rellax' );
        wp_enqueue_script( 'iscroll' );
        wp_enqueue_script( 'drawer' );
        wp_enqueue_script( 'custom' );
        // JSへ変数受け渡し
        $queried_object = get_queried_object();
        $term = '';
        $taxonomy = '';
        if( isset( $queried_object ) ) {
            $term = $queried_object->slug;
            $taxonomy = $queried_object->taxonomy;
        }
        $sitedata = array(
            'url' => home_url(),
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'term' => $term,
            'taxonomy' => $taxonomy
        );
        wp_localize_script( 'custom', 'sitedata', $sitedata );
    }
    // Javascript 遅延読み込み
    add_filter( 'clean_url', 'add_defer_to_enqueue_script', 11, 1 );
    function add_defer_to_enqueue_script( $url ) {
        if( FALSE === strpos( $url, '.js' ) ) return $url;
        if( strpos( $url, 'jquery.min.js' ) === true ) return $url;
        return "$url' defer charset='UTF-8";
    }
    /* Style
    * ------------------------------ */
    add_action('wp_enqueue_scripts', 'add_style');
    function add_style() {
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
    }
}

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

// カスタムメニュー
// add_action( 'init', 'my_custom_menus' );
// function my_custom_menus() {
//     register_nav_menus(
//         array(
//             'primary-menu' => __( 'ヘッダー用メニュー', 'default' ),
//             'secondary-menu' => __( 'フッター用メニュー', 'default' ),
//             'smartphone-menu' => __( 'スマートフォン用メニュー', 'default' )
//         )
//     );
// }
