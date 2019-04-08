<div class="column column-25">
    <?php
    $icatch = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
    if ( $icatch[2] > 1000 ) {
        $trmclass = ' trmimage-cover';
    }
    ?>
    <div class="post-image link-style-trmimage link-style-boxshadow<?php echo $trmclass; ?>">
        <a href="<?php the_permalink(); ?>" class="hover-zoom">
            <?php if ( has_post_thumbnail() ): // if it has thumbnail
                echo '<img data-src="'. $icatch[0] . '" class="lazyload" />';
            else: ?>
            <img data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/no-image.jpg" alt="no image" title="no image" class="lazyload" />
        <?php endif; ?>
    </a>
    <p class="post-date link-style-fill" itemprop="datePublished" datetime="<?php the_time('Y/m'); ?>"><?php the_time('Y/m'); ?></p>
</div>
<div class="post-info">
    <p class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
    <?php echo or_get_category( false ); ?>
</div>
</div>
