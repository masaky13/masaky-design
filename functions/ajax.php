<?php

add_action('wp_ajax_ajax_loadpost', 'ajax_loadpost');
add_action('wp_ajax_nopriv_ajax_loadpost', 'ajax_loadpost');
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
