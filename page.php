<?php get_header(); ?>

<div class="content"><!-- content -->
    <article>
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
                <div class="container">
                    <?php the_content(); //本文 ?>
                </div>
            <?php endwhile; else: ?>
                <p>記事がありません</p>
            <?php endif; ?>
            <!--ループ終了 -->
        </main>
    </article>
</div><!-- /#content -->
<?php get_footer(); ?>
