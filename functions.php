<?php
// PHP Files
require_once('functions/init.php');

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
