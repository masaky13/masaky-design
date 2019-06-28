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
add_theme_support('post-thumbnails');

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
function admin_add_script() {
    $direc = get_bloginfo( 'template_directory' );
    wp_enqueue_script( 'admin_script', $direc .'/js/admin.js' );
    wp_enqueue_script( 'thickbox' );
}
add_action('admin_head' , 'admin_add_style');
function admin_add_style() {
    $direc = get_bloginfo('template_directory');
    wp_enqueue_style( 'admin-style', $direc .'/css/admin-style.css', array(), false, 'all' );
}

// 記事　カスタムフィールド登録
add_action('admin_menu', 'add_post_fields');
function add_post_fields() {
    //add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
    add_meta_box( 'post_summary', 'Summary', 'insert_summary_fields', 'post', 'normal');
}
// カスタムフィールドの入力エリア
function insert_summary_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    echo '概要：<input type="text" name="post_summary" value="'. get_post_meta( $post->ID, 'summary', true ). '" size="100" /><br>';
}
add_action('save_post', 'save_post_fields');
function save_post_fields( $post_id ) {
    if( !empty( $_POST['post_summary'] ) ) {
        update_post_meta( $post_id, 'summary', $_POST['post_summary'] );
    } else {
        delete_post_meta( $post_id, 'summary' );
    }
}

// 固定ページ　カスタムフィールド登録
add_action('admin_menu', 'add_profile_fields');
function add_profile_fields() {
    //add_meta_box(表示される入力ボックスのHTMLのID, ラベル, 表示する内容を作成する関数名, 投稿タイプ, 表示方法)
    add_meta_box( 'profile_setting', 'Profile', 'insert_profile_fields', 'page', 'normal');
    add_meta_box( 'profile_skills', 'Skills', 'insert_skills_fields', 'page', 'normal');
    add_meta_box( 'works_fee', 'Fee plan', 'insert_fee_fields', 'page', 'normal');
}

// カスタムフィールドの入力エリア
function insert_profile_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    $hobbies = '';
    if( !empty( get_post_meta( $post->ID, 'profile_hobbies', true ) ) ) {
        $hobbies = implode( ',', get_post_meta( $post->ID, 'profile_hobbies', true ) );
    }
    echo '名前：<input type="text" name="profile_name" value="'. get_post_meta( $post->ID, 'profile_name', true ). '" size="100" /><br>';
    echo '概要：<textarea name="profile_summary" id="profile_summary" cols="100" rows="10">'. get_post_meta( $post->ID, 'profile_summary', true ) .'</textarea><br />';
    echo '趣味：<input type="text" name="profile_hobbies" value="'. $hobbies .'" size="100" /><br>※カンマ区切りで入力<br>';

    wp_nonce_field( 'image-meta', 'my_meta_nonce' );
    $profile_image = get_post_meta( $post->ID, 'profile_image' );
    $profile_image[0] = ( isset( $profile_image[0] ) ) ? $profile_image[0] : '';
    $view_image = ( $profile_image[0] !== '' ) ? '<img style="width:100%" src="' . $profile_image[0] . '" />' : '';
    $html = '<fieldset>'
    . '<label for="profile_image">Profile image</label>'
    . '<input id="profile_image" class="profile_image" type="text" size="50" name="profile_image" value="' . $profile_image[0] . '" />'
    . '<input class="upload_button" type="button" value="画像の選択" />'
    . '<div class="view">' . $view_image . '</div>'
    . '</fieldset>';
    echo $html;
}

// カスタムフィールドの入力エリア
function insert_skills_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    $skill_names = get_post_meta( $post->ID, 'skill_names', true );
    $skill_parcents = get_post_meta( $post->ID, 'skill_parcents', true );
    $skill_summaries = get_post_meta( $post->ID, 'skill_summaries', true );
    $skill_careers = get_post_meta( $post->ID, 'skill_careers', true );
    if( empty( $skill_names ) ) $skill_names = array('');
    if( empty( $skill_parcents ) ) $skill_parcents = array('');
    if( empty( $skill_summaries ) ) $skill_summaries = array('');
    if( empty( $skill_careers ) ) $skill_careers = array('');

    foreach( $skill_names as $index => $value ) {
        echo '<div class="custom-area-item">';
        echo '<input class="index" type="hidden" name="skill_index['. $index .']" value="'. $index .'" />';
        echo '<div class="row">';
        echo '<span class="title"><label for="skill_name">項目</label></span><input type="text" id="skill_name" name="skill_names['. $index .']" value="'. $value .'" size="100" />';
        echo '</div>';
        echo '<div class="row">';
        echo '<span class="title"><label for="skill_parcent">パーセント</label></span><input type="text" id="skill_parcent" name="skill_parcents['. $index .']" value="'. $skill_parcents[$index] . '" size="1" maxlength="3" />';
        echo '<span class="title"><label for="skill_career">年数</label></span><input type="text" id="skill_career" name="skill_careers['. $index .']" value="'. $skill_careers[$index] . '" size="1" maxlength="3" />';
        echo '</div>';
        echo '<div class="row">';
        echo '<span class="title"><label for="skill_summary">概要</label></span><textarea id="skill_summary" class="skill_summaries" name="skill_summaries['. $index .']" cols="100" rows="5">'. $skill_summaries[$index] .'</textarea>';
        echo '</div>';
        echo '<input class="delete_button" type="button" value="削除" />';
        echo '</div>';
        echo '';
    }
    echo '<input class="clone_button" type="button" value="追加" />';
}

// カスタムフィールドの入力エリア
function insert_fee_fields() {
    global $post;
    //下記に管理画面に表示される入力エリア
    $names = get_post_meta( $post->ID, 'fee_names', true );
    $prices = get_post_meta( $post->ID, 'fee_prices', true );
    $options = get_post_meta( $post->ID, 'fee_options', true );
    if( empty( $names ) ) $names = array('');
    if( empty( $prices ) ) $prices = array('');
    if( empty( $options ) ) $options = array( array( 'nami' => '', 'tax' => '', 'req' => '' ) );

    foreach( $names as $index => $value ) {
        echo '<div class="custom-area-item fee_item">';
        echo '<input class="index" type="hidden" name="fee_index['. $index .']" value="'. $index .'" />';
        echo '<div class="row">';
        echo '<span class="title"><label for="fee_name">項目</label></span><input type="text" id="fee_name" name="fee_names['. $index .']" value="'. $value .'" size="100" />';
        echo '</div>';
        echo '<div class="row">';
        echo '<span class="title"><label for="fee_price">値段</label></span><input type="text" id="fee_price" name="fee_prices['. $index .']"  value="'. $prices[$index] . '" size="6" />';
        $check = '';
        if( $options[$index]['tax'] == 'is-on' ) {
            $check = 'checked';
        }
        echo '<input type="hidden" name="fee_options['. $index .'][tax]" value="is-off" />';
        echo '<span class="title"><label for="fee_option_tax">消費税を追加</label></span><input id="fee_option_tax" class="tax" type="checkbox" name="fee_options['. $index .'][tax]" value="is-on" '. $check .' >';
        echo '</div>';
        echo '<div class="row">';
        $check = '';
        if( $options[$index]['nami'] == 'is-on' ) {
            $check = 'checked';
        }
        echo '<input type="hidden" name="fee_options['. $index .'][nami]" value="is-off" />';
        echo '<span class="title"><label for="fee_option_nami">～を追加</label></span><input type="checkbox" id="fee_option_nami" name="fee_options['. $index .'][nami]" value="is-on" '. $check .' >';
        $check = '';
        if( $options[$index]['req'] == 'is-on' ) {
            $check = 'checked';
        }
        echo '<input type="hidden" name="fee_options['. $index .'][req]" value="is-off" />';
        echo '<span class="title"><label for="fee_option_req">要問合せ</label></span><input id="fee_option_req" type="checkbox" name="fee_options['. $index .'][req]" value="is-on" '. $check .' >';
        echo '</div>';
        echo '<input class="delete_button" type="button" value="削除" /><br>';
        echo '</div>';
    }
    echo '<input class="clone_button" type="button" value="追加" />';
}

// カスタムフィールドの値を保存
add_action('save_post', 'save_profile_fields');
function save_profile_fields( $post_id ) {
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    if( isset( $_POST['my_meta_nonce_wpnonce'] ) && !wp_verify_nonce( $_POST['my_meta_nonce'], 'image-meta' ) ) {
        return $post_id;
    }
    if (!current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

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
    if( !empty( $_POST['skill_names'] ) || !empty( $_POST['skill_parcents'] ) || !empty( $_POST['skill_summaries'] ) || !empty( $_POST['skill_careers'] ) ) {
        $names = $_POST['skill_names'];
        $parcents = $_POST['skill_parcents'];
        $summaries = $_POST['skill_summaries'];
        $careers = $_POST['skill_careers'];
        foreach( $names as $key => $value ) {
            if( empty( $value ) && empty( $parcents[$key] ) && empty( $summaries[$key] ) && empty( $careers[$key] ) ) {
                unset( $names[$key] );
                unset( $parcents[$key] );
                unset( $summaries[$key] );
                unset( $careers[$key] );
            }
        }
        $names = array_values( $names );
        $parcents = array_values( $parcents );
        $summaries = array_values( $summaries );
        $careers = array_values( $careers );
        update_post_meta( $post_id, 'skill_names', $names );
        update_post_meta( $post_id, 'skill_parcents', $parcents );
        update_post_meta( $post_id, 'skill_summaries', $summaries );
        update_post_meta( $post_id, 'skill_careers', $careers );
    } else {
        delete_post_meta( $post_id, 'skill_names' );
        delete_post_meta( $post_id, 'skill_parcents' );
        delete_post_meta( $post_id, 'skill_summaries' );
        delete_post_meta( $post_id, 'skill_careers' );
    }

    // Fee
    if( !empty( $_POST['fee_names'] ) || !empty( $_POST['fee_prices'] ) || !empty( $POST['fee_options'] ) ) {
        $names = $_POST['fee_names'];
        $prices = $_POST['fee_prices'];
        $options = $_POST['fee_options'];
        foreach( $names as $key => $value ) {
            // 数値かどうか確認
            if( !empty( $prices[$key] ) ) {
                if( preg_match( '/[^0-9]/', $prices[$key] ) ) {
                    // 文字列が入っている場合、文字列を削除する
                    $prices[$key] = preg_replace( '/[^0-9]/' ,'' , $prices[$key] );
                }
                // 3桁カンマを追加
                $prices[$key] = number_format( $prices[$key] );
            }
            if( empty( $value ) && empty( $prices[$key] ) && $options[$key]['nami'] === 'is-off' && $options[$key]['tax'] === 'is-off' ) {
                unset( $names[$key] );
                unset( $prices[$key] );
                unset( $options[$key] );
            }
        }
        $names = array_values( $names );
        $prices = array_values( $prices );
        $options = array_values( $options );
        update_post_meta( $post_id, 'fee_names', $names );
        update_post_meta( $post_id, 'fee_prices', $prices );
        update_post_meta( $post_id, 'fee_options', $options );
    } else {
        delete_post_meta( $post_id, 'fee_names' );
        delete_post_meta( $post_id, 'fee_prices' );
        delete_post_meta( $post_id, 'fee_options' );
    }
}
