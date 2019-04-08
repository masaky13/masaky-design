<?php get_header(); ?>

<div class="content"><!-- content -->
    <?php if (have_posts()) : while (have_posts()) :
        the_post(); ?>
        <section class="topview c-cover"><!-- topview -->
            <div class="inner">
                <div class="title rellax" data-rellax-speed="-2">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </section><!-- /topview -->

        <main>
            <div class="inner">
                <?php get_breadcrumb(); //breadcrumb ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('st-post'); ?>>
                    <!--ループ開始 -->

                    <article>
                        <header class="container">
                            <div class="row">
                                <div class="thumb-post column column-40 link-style-boxshadow">
                                    <a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'large')[0]; ?>" target="_blank"><?php the_post_thumbnail(); ?></a>
                                </div>

                                <!-- post_info -->
                                <div class="post-info column column-60">
                                    <div class="container">
                                        <div class="row">
                                            <div class="column column-25">
                                                <p>Title</p>
                                            </div>
                                            <div class="column column-75">
                                                <p><?php the_title(); //Title ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column column-25">
                                                <p>Project</p>
                                            </div>
                                            <div class="column column-75 list-style-slash">
                                                <p><?php echo or_get_terms( 'project' ); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column column-25">
                                                <p class="post-date">Published</p>
                                            </div>
                                            <div class="column column-75">
                                                <p><time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( DATE_ISO8601 ) ); ?>"><?php the_time('Y.m'); ?></time></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column column-25">
                                                <p>Category</p>
                                            </div>
                                            <div class="column column-75">
                                                <?php echo or_get_category(); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column column-25">
                                                <p>Tools / Tags</p>
                                            </div>
                                            <div class="column column-75 list-style-slash">
                                                <p><?php echo or_get_terms( 'post_tag' ); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="column column-25">
                                                <p>Comment</p>
                                            </div>
                                            <div class="column column-75">
                                                <p><?php echo get_post_meta( get_the_ID(), 'summary', true ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- post_info -->
                            </div>
                        </header>

                        <div class="post-detail">
                            <p>Dtails</p>
                            <?php  the_content('', true); //Content ?>
                        </div>

                        <?php // get_template_part( 'sns' ); //ソーシャルボタン読み込み ?>
                    <?php endwhile; else: ?>
                        <p>記事がありません</p>
                    <?php endif; ?>
                    <!--ループ終了-->
                </article>

                <!--ページナビ-->
                <div class="container post-nav">
                    <div class="row">
                        <?php
                        $prev_post = get_previous_post();
                        if ( !empty( $prev_post ) ):
                            ?>
                            <div class="column previous-post icon-arrow-left">
                                <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo $prev_post->post_title; ?></a>
                            </div>
                            <?php
                        endif;
                        $next_post = get_next_post();
                        if ( !empty( $next_post ) ):
                            ?>
                            <div class="column next-post icon-arrow-right">
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo $next_post->post_title; ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--/post-->
        </div>
        <!--関連記事-->
        <section class="works" data-rellax-speed="-1"><!-- works -->
            <div class="container"><!-- container -->
                <h2>Other Works</h2>
            </div><!-- /#contentInner -->
            <?php get_template_part( 'tmp-relate' ); ?>
        </section><!-- /skills -->
    </main>
</div><!-- /content -->

<!--/#content -->
<?php get_footer(); ?>
