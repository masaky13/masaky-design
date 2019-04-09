<?php
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
