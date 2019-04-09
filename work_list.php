<?php
/**
* トップの新着記事・記事ページの関連記事の記事表示
*/
?>
<?php
$postcount = 8; //表示したい記事数
if( is_single() ) {
    // 記事ページの場合
    $categories = get_the_category( $post->ID );
    $category_ids = array();
    foreach ( $categories as $category ) {
        array_push( $category_ids, $category->cat_ID );
    }
    $projects = get_the_terms( $post->ID, 'project');
    $args = array(
        'post__not_in' => array( $post->ID ),
        'posts_per_page' => $postcount,
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $category_ids,
                'operator' => 'AND'
            ),
            array(
                'taxonomy' => 'project',
                'field'    => 'id',
                'terms'    => array( $projects[0]->term_id ),
                'operator' => 'IN'
            )
        ),
        'orderby' => 'rand', //ランダム表示
    );
} else {
    // それ以外のページ
    $args = array( 'posts_per_page' => $postcount );
}
$the_query = new WP_Query( $args );
$count = 0;
$lfg_row = 0;
if ( $the_query->have_posts() ):
    while ( $the_query->have_posts() ) : $the_query->the_post();
    if( ( $count % 4 ) === 0 ) { ?>
        <div class="row">
            <?php
            $lfg_row = 1;
        }
        ++$count; ?>
        <div class="column column-25 link-style-trmimage trmimage-cover">
            <a href="<?php the_permalink(); ?>" class="c-cover hover-zoom">
                <?php if ( has_post_thumbnail() ): // if it has thumbnail ?>
                    <img data-src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), true)[0] ?>" class="lazyload" />
                <?php else: ?>
                    <img data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/no-image.jpg" alt="no image" title="no image" class="lazyload" />
                <?php endif; ?>
            </a>
        </div>
        <?php if( ( $count % 4 ) === 0 ) { ?>
        </div>
        <?php
        $lfg_row = 0;
    }
    endwhile;
else:
    ?>
    <p>関連記事はありませんでした</p>
    <?php
endif;
if( $lfg_row === 1 ) {
    echo '</div>';
}
wp_reset_postdata();
?>
