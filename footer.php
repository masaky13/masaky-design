<footer>
    <div class="inner">
        <?php //フッターメニュー
        $defaults = array(
            'theme_location'  => 'secondary-menu',
            'container'       => 'div',
            'container_class' => 'footermenubox clearfix ',
            'menu_class'      => 'footermenust',
            'depth'           => 1,
        );
        wp_nav_menu( $defaults );
        ?>
        <div class="footer-info">
            <!-- ロゴ又はブログ名 -->
            <p class="homename">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/masakydesign-logo-brack.svg" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="120" /></a>
            </p>
        </div>
        <small class="copy">Copyright&copy;<?php bloginfo( 'name' ); ?>,<?php echo date( 'Y' ); ?>All Rights Reserved.</small>
    </div>
</footer>
</div><!-- /#wrapperin -->
</div><!-- /#wrapper -->
<!-- ページトップへ戻る -->
<div id="page-top"><a href="#wrapper"></a></div>
<!-- ページトップへ戻る　終わり -->
<?php wp_footer(); ?>
</body></html>
