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

add_action('init','remove_parent_theme_actions');
function remove_parent_theme_actions() {
    remove_action('wp_enqueue_scripts', 'st_enqueue_styles', 10);
    remove_action('wp_enqueue_scripts', 'st_enqueue_scripts', 10);
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

// カスタムメニュー
add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'ヘッダー用メニュー', 'default' ),
            'secondary-menu' => __( 'フッター用メニュー', 'default' ),
            'smartphone-menu' => __( 'スマートフォン用メニュー', 'default' )
        )
    );
}
