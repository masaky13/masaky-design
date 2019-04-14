<?php get_header(); ?>

<div class="content"><!-- content -->
    <section class="topview c-cover"><!-- topview -->
        <div class="inner">
            <div class="title rellax" data-rellax-speed="-2">
                <h1><?php echo get_archve_title(); ?></h1>
                <span> (<?php echo $wp_query->found_posts; ?>)</span>
            </div>
        </div>
    </section><!-- /topview -->
    <main>
        <div class="archive-menu container">
            <h3>Category</h3>
            <div class="row">
                <?php echo term_child_directly( 'category' ); ?>
            </div>
        </div>
        <article>
            <!--ループ開始-->
            <div class="post-list container">
                <?php
                $count = 0;
                $flg = 0;
                if ( have_posts() ) : while ( have_posts() ) : the_post();
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
            endwhile;
        else:
            ?>
            <p>記事がありません</p>
        <?php endif;
        if( $flg === 1 ) {
            echo '</div>';
        }
        ?>
        <p id="post-list-more">More</p>
        <p class="post-list-nav">
            <span id="post-count"><?php echo $wp_query->post_count; ?></span> /
            <span id="found-posts"><?php echo $wp_query->found_posts; ?></span>
        </p>
    </div>
    <?php // get_template_part( 'tmp-pagenavi' ); //ページナビ読み込み ?>
</article>
</main><!-- /#contentInner -->
</div><!-- /#content -->
<?php get_footer(); ?>
