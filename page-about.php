<?php get_header();
/*
Template Name: ABOUT
*/
?>
<div class="content about"><!-- content -->
    <article>
        <!--ループ開始 -->
        <?php if (have_posts()) : while (have_posts()) :
            the_post(); ?>

            <section class="topview c-cover"><!-- topview -->
                <div class="inner">
                    <div class="title rellax" data-rellax-speed="-2">
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>
            </section><!-- /topview -->

            <?php echo view_profile(); ?>
            <section class="skills"><!-- skills -->
                <div class="container">
                    <h2>Skills</h2>
                    <div class="row skill">
                        <div class="column column-20">
                            <p>HTML 5 / CSS 3</p>
                        </div>
                        <div class="column column-80">
                            <div class="row">
                                <div class="column column-100 skill-percent">
                                    <p>100%</p>
                                </div>
                            </div>
                            <div class="skill-description">
                                <p>経験年数 約6年</p>
                                <p>マークアップやSEO、AMP等幅広く対応可能。</p>
                            </div>
                        </div>
                    </div>
                    <div class="row skill">
                        <div class="column column-20">
                            <p>Javascript</p>
                        </div>
                        <div class="column column-80">
                            <div class="row">
                                <div class="column column-80 skill-percent">
                                    <p>80%</p>
                                </div>
                            </div>
                            <div class="skill-description">
                                <p>経験年数約5年</p>
                                <p>スクラッチでの構築、Ajaxの使用経験あり、今後はnode.js関連のプロジェクトに興味があります。</p>
                            </div>
                        </div>
                    </div>
                    <div class="row skill">
                        <div class="column column-20">
                            <p>Wordpress（PHP・MySQL）</p>
                        </div>
                        <div class="column column-80">
                            <div class="row">
                                <div class="column column-90 skill-percent">
                                    <p>90%</p>
                                </div>
                            </div>
                            <div class="skill-description">
                                <p>経験年数5年</p>
                                <p>テーマの制作やDBの管理、記事データの一括置換、APIのデータ連携、多数機能改修など経験あり。</p>
                            </div>
                        </div>
                    </div>
                    <div class="row skill">
                        <div class="column column-20">
                            <p>Design</p>
                        </div>
                        <div class="column column-80">
                            <div class="row">
                                <div class="column column-80 skill-percent">
                                    <p>80%</p>
                                </div>
                            </div>
                            <div class="skill-description">
                                <p>経験年数6年</p>
                                <p>フライヤーやポスター、名詞デザイン、パッケージデザイン、Webデザイン、ロゴデザイン、LPの制作。</p>
                            </div>
                        </div>
                    </div>
                    <div class="row skill">
                        <div class="column column-20">
                            <p>PHP・Java</p>
                        </div>
                        <div class="column column-80">
                            <div class="row">
                                <div class="column column-40 skill-percent">
                                    <p>40%</p>
                                </div>
                            </div>
                            <div class="skill-description">
                                <p>経験年数1年</p>
                                <p>研修・業務経験のみ。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- history -->
            <section class="career c-cover">
                <div class="container">
                    <h2>History</h2>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2014. 3</p>
                        </div>
                        <div class="column column-80">
                            <p>船橋情報ビジネス専門学校　Webクリエイター科　卒業</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2014. 4</p>
                        </div>
                        <div class="column column-80">
                            <p>システムエンジニア</p>
                            <ul>
                                <li>Webアプリケーションのプロジェクトの参画</li>
                                <li>派遣システムのテスター</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2015. 4</p>
                        </div>
                        <div class="column column-80">
                            <p>落語のイベント企画・運営・制作　マネジャー</p>

                            <p>Webサイト制作</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2015.12</p>
                        </div>
                        <div class="column column-80">
                            <p>オーストラリア　シドニー　短期留学</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2016. 4</p>
                        </div>
                        <div class="column column-80">
                            <p>インターネットサービス会社の制作</p>
                            <ul>
                                <li>キュレーションサイトのWebデザイン・制作</li>
                                <li>ECサイトの構築・デザイン・制作</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2017. 2</p>
                        </div>
                        <div class="column column-80">
                            <p>フリーランス（個人事業主）</p>
                            <ul>
                                <li>医療系コラムサイト制作プロジェクトに参画</li>
                                <li>Webサイト制作</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20 date">
                            <p>2018. 2</p>
                        </div>
                        <div class="column column-80">
                            <p>個人事業主として活動</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="company">
                <div class="container">
                    <h2>MASAKY DESIGN</h2>
                    <div class="row">
                        <div class="column column-20">
                            <p>Freelancer</p>
                        </div>
                        <div class="column column-80">
                            <p>武内 雅喜 / Masaki Takeuchi ・Web coder ・Desiner ・Frontend engineer</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20">
                            <p>Tel</p>
                        </div>
                        <div class="column column-80">
                            <p>080-8446-5404</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20">
                            <p>E-mail</p>
                        </div>
                        <div class="column column-80">
                            <p>masaki.takeuchi@msk-dg.jp</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20">
                            <p>Web</p>
                        </div>
                        <div class="column column-80">
                            <p><a href="<?php home_url(); ?>">https://masaky-design.jp</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column column-20">
                            <p>Based</p>
                        </div>
                        <div class="column column-80">
                            <p>Tokyo</p>
                        </div>
                    </div>
                </div>
            </section>            <?php get_template_part( 'tmp-contact' ); //menu ?>

            <div class="entry-content">
                <?php the_content(); //本文 ?>
            </div>
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
        <?php endwhile; else: ?>
            <p>記事がありません</p>
        <?php endif; ?>
        <!--ループ終了 -->
    </article>
    <?php //get_sidebar(); ?>
</div><!-- /#content -->
<?php get_footer(); ?>
