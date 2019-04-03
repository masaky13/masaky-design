<?php get_header(); ?>

<div id="content" class="clearfix">
<div id="content_inner" class="clearfix">
<main>
    <!-- ぱんくず -->
    <?php get_breadcrumb(); ?>
    <!--/ ぱんくず -->
    <div id="post-<?php the_ID(); ?>" <?php post_class('st-post'); ?>>
        <article>
            <!--ループ開始 -->
            <?php if (have_posts()) : while (have_posts()) :
                the_post(); ?>

                <?php //カテゴリ表示
                if ( isset($GLOBALS['stdata60']) && $GLOBALS['stdata60'] === 'yes' ) {

                } else {

                    $categories = get_the_category();
                    $separator = ' ';
                    $output = ''; ?>
                    <p class="st-catgroup">
                        <?php
                        if ( $categories ) {
                            foreach( $categories as $category ) {
                                $output .= '<a href="' . get_category_link( $category->term_id ) . '" title="'
                                . esc_attr( sprintf( "View all posts in %s", $category->name ) )
                                . '" rel="category tag"><span class="catname st-catid' . $category->cat_ID . '">' . $category->cat_name . '</span></a>' . $separator;
                            }
                            echo trim( $output, $separator );
                        } ?>
                    </p>
                    <?php
                } //カテゴリ表示ここまで
                ?>

                <h1 class="entry-title"><?php the_title(); //タイトル ?></h1>

                <div class="blogbox">
                    <p><span class="kdate">
                        <?php if ( get_the_date() != get_the_modified_date() ) : //更新がある場合 ?>
                            投稿日：<?php echo esc_html( get_the_date() ); ?>
                            更新日：<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( DATE_ISO8601 ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
                        <?php else: //更新がない場合 ?>
                            投稿日：<time class="updated" datetime="<?php echo esc_attr( get_the_date( DATE_ISO8601 ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                        <?php endif; ?>
                    </span></p>
                </div>

                <div class="mainbox">
                    <div class="entry-content">
                        <?php the_content(); //本文 ?>
                    </div>
                    <?php get_template_part( 'st-ad-on' ); //広告 ?>

                    <?php //ページ改
                    $defaults = array(
                        'before'           => '<p class="tuzukicenter"><span class="tuzuki">' . __( '', 'default' ),
                        'after'            => '</span></p>',
                        'link_before'      => '&gt;&ensp;',
                        'link_after'       => '&ensp;',
                        'next_or_number'   => 'next',
                        'separator'        => ' ',
                        'nextpagelink'     => __( '続きを読む', 'default' ),
                        'previouspagelink' => __( '前のページへ', 'default' ),
                        'pagelink'         => '%',
                        'echo'             => 1
                    );
                    wp_link_pages( $defaults );
                    ?>

                </div><!-- .mainboxここまで -->

                <?php get_template_part( 'sns' ); //ソーシャルボタン読み込み ?>

                <p class="tagst">
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>-<?php the_category( ', ' ) ?><br/>
                    <?php the_tags( '<i class="fa fa-tags"></i>-', ', ' ); ?>
                </p>

                <p>執筆者：<?php the_author_posts_link(); ?></p>


            <?php endwhile; else: ?>
                <p>記事がありません</p>
            <?php endif; ?>
            <!--ループ終了-->
        </article>

        <div class="st-aside">

            <?php if ( comments_open() || get_comments_number() ) {
                comments_template(); //コメント
            } ?>

            <!--関連記事-->
            <?php get_template_part( 'kanren' ); ?>

            <!--ページナビ-->
            <div class="p-navi clearfix">
                <dl>
                    <?php
                    $prev_post = get_previous_post();
                    if ( !empty( $prev_post ) ): ?>
                    <dt>PREV</dt>
                    <dd>
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo $prev_post->post_title; ?></a>
                    </dd>
                <?php endif; ?>
                <?php
                $next_post = get_next_post();
                if ( !empty( $next_post ) ): ?>
                <dt>NEXT</dt>
                <dd>
                    <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo $next_post->post_title; ?></a>
                </dd>
            <?php endif; ?>
        </dl>
    </div>
</div><!-- /st-aside -->
</div><!--/post-->
</main>
<?php get_sidebar(); ?>
</div><!-- /#contentInner -->
</div><!-- /#content -->
<?php get_footer(); ?>
