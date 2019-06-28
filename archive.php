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
        <?php echo works_introduce(); ?>
        <?php echo term_child_directly( 'category' ); ?>
        <article>
            <div class="post-list container">
                <?php if ( have_posts() ) :
                    $count = 0;
                    $flg = 0;
                    while ( have_posts() ) : the_post();
                        if( ( $count % 4 ) === 0 ) {
                            $flg = 1;
                            echo '<div class="row">';
                        }
                        ++$count;
                        get_template_part( 'post_list' );
                        if( ( $count % 4 ) === 0 ) {
                            $flg = 0;
                            echo '</div>';
                        } ?>
                    <?php endwhile; ?>
                    <?php if( $flg === 1 ) {
                        echo '</div>';
                    } ?>
                    <?php if( $wp_query->post_count !== (int) $wp_query->found_posts ) { ?>
                        <p id="post-list-more">More</p>
                    <?php } ?>
                    <p class="post-list-nav">
                        <span id="post-count"><?php echo $wp_query->post_count; ?></span> /
                        <span id="found-posts"><?php echo $wp_query->found_posts; ?></span>
                    </p>
                <?php else: ?>
                    <p>記事がありません</p>
                <?php endif; ?>
            </div>
        </article>
    </main>
    <?php get_template_part( 'tmp-contact' ); ?>
</div>
<?php get_footer(); ?>
