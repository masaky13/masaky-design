<?php get_header(); ?>

<div class="content"><!-- content -->
<article>
    <section class="topview c-cover"><!-- topview -->
        <div class="inner">
            <div class="title rellax" data-rellax-speed="-2">
                <h1>404ページ</h1>
            </div>
        </div>
    </section><!-- /topview -->

    <main>
        <div class="container">
            お探しのページは見つかりませんでした。
        </div>
    </main>
    <section class="works" data-rellax-speed="-1"><!-- works -->
        <div class="container"><!-- container -->
            <h2>Other Works</h2>
        </div><!-- /#contentInner -->
        <?php get_template_part( 'work_list' ); ?>
    </section><!-- /skills -->
</article>
</div><!-- /#content -->
<?php get_footer(); ?>
