<div class="column column-25 link-style-trmimage trmimage-cover">
	<a href="<?php the_permalink(); ?>" class="c-cover hover-zoom">
		<?php if ( has_post_thumbnail() ): // if it has thumbnail
			echo '<img data-src="'. wp_get_attachment_image_src( get_post_thumbnail_id(), true)[0] . '" class="lazyload" />';
		else: ?>
		<img data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/no-image.jpg" alt="no image" title="no image" class="lazyload" />
		<?php endif; ?>
	</a>
</div>
