<?php
/*
Template Name: WORK
*/
get_header();
?>
<div class="content"><!-- content -->
	<?php if (have_posts()) : while (have_posts()) :
		the_post(); ?>
		<?php
			// 全投稿取得クエリ
			$paged = (int) get_query_var('paged');
			$args = array(
				'paged' => $paged,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'post'
			);
			$the_query = new WP_Query($args); ?>
	<section class="topview c-cover"><!-- topview -->
		<div class="inner">
			<div class="title rellax" data-rellax-speed="-2">
				<h1><?php the_title(); ?></h1>
				<span> (<?php echo $the_query->found_posts; ?>)</span>
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
				 if ( $the_query->have_posts() ) :
					 while ( $the_query->have_posts() ) : $the_query->the_post();
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
				 wp_reset_postdata();
				 if( $flg === 1 ) {
					 echo '</div>';
				 }
			 ?>
			 <p id="post-list-more"><a href="#">More</a><span id="post-count">
				 <?php echo $the_query->post_count; ?></span>/<span id="found-posts"><?php echo $the_query->found_posts; ?></span>
			 </p>
		 </div>
	 </article>
 </main><!-- /#contentInner -->
	<?php endwhile; else: ?>
		<p>記事がありません</p>
	<?php endif;
		wp_reset_postdata();
	 ?>
</div><!-- /#content -->
<?php get_footer(); ?>
