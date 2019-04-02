<?php get_header(); ?>

<?php //get_template_part( 'tmp-firstposts' ); ?>
<div class="content clearfix"><!-- content -->
	<section class="firstview"><!-- Top first view -->
		<div class="firstview_con view_1 rellax" data-rellax-speed="-7">
			<div class="inner"><!-- content_inner -->
				<h2><a href="#home-about">MASAKY DESIGN</a></h2>
				<p>A free lancer of web design and deveropment</p>
			</div><!-- /#contentInner -->
		</div>
		<div class="firstview_con view_2 rellax" data-rellax-speed="-7">
			<div class="inner"><!-- content_inner -->
				<h2><a href="#home-about">MASAKY DESIGN</a></h2>
				<p>A free lancer of web design and deveropment</p>
			</div><!-- /#contentInner -->
		</div>
		<div class="firstview_con view_3 rellax" data-rellax-speed="-7">
			<div class="inner"><!-- content_inner -->
				<h2><a href="#home-about">MASAKY DESIGN</a></h2>
				<p>A free lancer of web design and deveropment</p>
			</div><!-- /#contentInner -->
		</div>
	</section><!-- /Top first view -->

	<section id="home-about" class="about"><!-- about -->
		<div class="container none-edge">
			<div class="row">
				<div class="column about-image">
					<img class="objectfit lazyload" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-about.jpg" alt="アバウト画像">
				</div>
				<div class="column">
					<div class="title">
						<h2>About</h2>
						<p>個人事業主様・フリーランサー様・企画等、のWeb制作やオリジナルホームページの制作を行っております。</p>
					</div>
				</div>
			</div>
		</div>
	</section><!-- /about -->

	<section class="service lazyload" data-bg="<?php echo get_stylesheet_directory_uri(); ?>/images/md-bg.png"><!-- service -->
		<div class="inner"><!-- content_inner -->
			<h2>Service</h2>
			<div class="container">
				<div class="row">
					<div class="column skills_item_1 rellax" data-rellax-speed="1">
						<h3>Web制作</h3>
						<ul>
							<li>個人事業主・フリーランス向け</li>
							<li>オンラインショップ・店舗サイト</li>
							<li>コーポレートサイト</li>
						</ul>
					</div>
					<div class="column skills_item_2 rellax" data-rellax-speed="2">
						<h3>デザイン制作</h3>
						<ul>
							<li>Webデザイン・ロゴデザイン</li>
							<li>ポスター・フライヤー</li>
							<li>パッケージデザイン</li>
						</ul>
					</div>
					<div class="column skills_item_3 rellax" data-rellax-speed="3">
						<h3>動画制作</h3>
						<ul>
							<li>プロモーションビデオ</li>
							<li>結婚式のプロフィール動画</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- <p class="notices"><a href="<?php home_url(); ?>/contact">詳細スキル・経歴はこちら</a></p> -->
		</div><!-- /#contentInner -->
	</section><!-- /service -->

	<section class="works" data-rellax-speed="-1"><!-- works -->
		<div class="container"><!-- container -->
			<h2>Works</h2>
		</div>
		<?php get_template_part( 'tmp-relate' ); //投稿一覧読み込み ?>
		<p class="link-style-more icon-arrow-right"><a href="<?php home_url(); ?>/works">See more</a></p>
	</section><!-- /skills -->

	<?php get_template_part( 'tmp-contact' ); //menu ?>
</!--></div><!-- /#content -->
<?php get_footer(); ?>
