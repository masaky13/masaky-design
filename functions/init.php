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

add_action('admin_print_scripts', 'admin_add_script');
add_action('admin_head' , 'add_css');
function admin_add_script() {
    $direc = get_bloginfo('template_directory');
    wp_enqueue_script('admin_print_styles', $direc . '/js/admin.js');
    wp_enqueue_script('thickbox');  //-- (1)
}
function add_css() {
    echo "\n" . '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('template_directory') . '/css/admin.css" />' . "\n";
    echo "\n" . '<link rel="stylesheet" id="thickbox-css"  href="' . get_bloginfo('url') . '/wp-includes/js/thickbox/thickbox.css" type="text/css" media="all" />'; // -- (2)
}

// アバウト　カスタムフィールド登録
add_action('admin_menu', 'add_profile_fields');
function add_profile_fields() {
    //add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
    add_meta_box( 'profile_setting', 'プロフィール', 'insert_profile_fields', 'page', 'normal');
    add_meta_box( 'profile_skills', 'Skills', 'insert_skills_fields', 'page', 'normal');
}

// カスタムフィールドの入力エリア
function insert_profile_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    echo '名前：<input type="text" name="profile_name" value="'. get_post_meta($post->ID, 'profile_name', true). '" size="100" /><br>';
    echo '概要：<textarea name="profile_summary" id="profile_summary" cols="100" rows="10">'. get_post_meta($post->ID, 'profile_summary', true) .'</textarea><br />';
    echo '趣味：<input type="text" name="profile_hobbies" value="'. implode( ',', get_post_meta($post->ID, 'profile_hobbies', true) ) .'" size="100" /><br>※カンマ区切りで入力<br>';

    wp_nonce_field( 'image-meta', 'my_meta_nonce' );
    $profile_image = get_post_meta( $post->ID, 'profile_image' );
    $profile_image[0] = (isset( $profile_image[0] ) ) ? $profile_image[0] : '';
    $view_image = ( $profile_image[0] !== '' ) ? '<img style="width:100%" src="' . $profile_image[0] . '" />' : '';
    $html = '<fieldset>'
    . '<label for="profile_image">Profile image</label>'
    . '<input id="profile_image" class="profile_image" type="text" size="50" name="profile_image" value="' . $profile_image[0] . '" />'
    . '<input class="upload_button" type="button" value="画像の選択" />'
    . '<div class="view">' . $view_image . '</div>'
    . '</fieldset>';
    echo $html;
    // if( get_post_meta($post->ID,'book_label',true) == "is-on" ) {
    // 	$book_label_check = "checked";
    // }
    // //チェックされていたらチェックボックスの$book_label_checkの場所にcheckedを挿入
    // echo 'ベストセラーラベル： <input type="checkbox" name="book_label" value="is-on" '.$book_label_check.' ><br>';
}

// カスタムフィールドの値を保存
add_action('save_post', 'save_profile_fields');
function save_profile_fields( $post_id ) {
    if( !empty( $_POST['profile_name'] ) ) {
        update_post_meta( $post_id, 'profile_name', $_POST['profile_name'] );
    } else {
        delete_post_meta( $post_id, 'profile_name' );
    }
    if( !empty( $_POST['profile_summary'] ) ) {
        update_post_meta( $post_id, 'profile_summary', $_POST['profile_summary'] );
    } else {
        delete_post_meta( $post_id, 'profile_summary' );
    }
    if( !empty( $_POST['profile_hobbies'] ) ) {
        update_post_meta( $post_id, 'profile_hobbies', explode( ',', $_POST['profile_hobbies'] ) );
    } else {
        delete_post_meta( $post_id, 'profile_hobbies' );
    }

    if( !empty( $_POST['profile_image'] ) ) {
        update_post_meta( $post_id, 'profile_image', $_POST['profile_image'] );
    } else {
        delete_post_meta( $post_id, 'profile_image' );
    }
    // Skill
    if( !empty( $_POST['skill_names'] ) || $_POST['skill_parcents'] || $_POST['skill_summaries'] ) {
        $names = $_POST['skill_names'];
        $parcents = $_POST['skill_parcents'];
        $summaries = $_POST['skill_summaries'];
        foreach( $names as $key => $value ) {
            if( empty( $value ) && empty( $parcents[$key] ) && empty( $summaries[$key] ) ) {
                unset( $names[$key] );
                unset( $parcents[$key] );
                unset( $summaries[$key] );
            }
        }
        $names = array_values( $names );
        $parcents = array_values( $parcents );
        $summaries = array_values( $summaries );
        update_post_meta( $post_id, 'skill_names', $names );
        update_post_meta( $post_id, 'skill_parcents', $parcents );
        update_post_meta( $post_id, 'skill_summaries', $summaries );
    } else {
        delete_post_meta( $post_id, 'skill_names' );
        delete_post_meta( $post_id, 'skill_parcents' );
        delete_post_meta( $post_id, 'skill_summaries' );
    }

    if( isset($_POST['my_meta_nonce_wpnonce']) && !wp_verify_nonce( $_POST['my_meta_nonce'], 'image-meta') ) {
        return $post_id;
    }
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    if (isset($_POST['post_type']) && 'imagemeta' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    } else {
        return $post_id;
    }

}


// カスタムフィールドの入力エリア
function insert_skills_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    $skill_names = get_post_meta( $post->ID, 'skill_names', true );
    $skill_parcents = get_post_meta( $post->ID, 'skill_parcents', true );
    $skill_summaries = get_post_meta( $post->ID, 'skill_summaries', true );
    echo '項目　％　備考<br>';
    if( empty( $skill_names ) ) $skill_names = array('');
    if( empty( $skill_parcents ) ) $skill_parcents = array('');
    if( empty( $skill_summaries ) ) $skill_summaries = array('');

    var_dump($skill_names);
    var_dump($skill_parcents);
    var_dump($skill_summaries);

    foreach( $skill_names as $index => $value ) {
        echo '<div class="skill_item">';
        echo '<input type="hidden" name="skill_index['. $index .']" value="'. $index .'" />';
        echo '項目：<input type="text" name="skill_names['. $index .']" value="'. $value .'" size="50" />';
        echo '数値：<input type="text" name="skill_parcents['. $index .']" value="'. $skill_parcents[$index] . '" size="10" /><br>';
        echo '概要：<textarea class="skill_summaries" name="skill_summaries['. $index .']" cols="100" rows="5">'. $skill_summaries[$index] .'</textarea>';
        echo '<input class="skill_delete_button" type="button" value="項目削除" /><br />';
        echo '</div>';
    }
    echo '<input class="clone_button" type="button" value="追加" />';
}
