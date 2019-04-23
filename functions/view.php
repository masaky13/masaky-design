<?php
$excludes = array( 1 ); // 未分類ID

if( !is_admin() ) {
    /* Javascript
    * ------------------------------ */
    add_action('wp_enqueue_scripts', 'add_script');
    function register_script(){
        $thema_pass = get_stylesheet_directory_uri();
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery-cdn', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), '1.11.3', false);
        wp_register_script( 'lazysizes', $thema_pass .'/js/lazysizes.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'lazysizes-unveilhooks', $thema_pass .'/js/ls.unveilhooks.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'slick', $thema_pass .'/js/slick.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'iscroll', $thema_pass .'/js/iscroll.js', array('jquery-cdn'), false, true );
        wp_register_script( 'drawer', $thema_pass .'/js/drawer.min.js', array('jquery-cdn'), false, true );
        wp_register_script( 'rellax', $thema_pass .'/js/rellax.min.js', array(), false, true );
        // wp_register_script( 'custom', $thema_pass .'/js/custom.js', array('jquery-cdn'), false, true );
        wp_enqueue_script( 'custom', $thema_pass.'/js/custom.js?'.filemtime( get_stylesheet_directory().'/js/custom.js'), array('jquery-cdn'));
    }
    function add_script() {
        register_script();
        wp_enqueue_script( 'jquery-cdn' );
        wp_enqueue_script( 'lazysizes' );
        wp_enqueue_script( 'lazysizes-unveilhooks' );
        wp_enqueue_script( 'slick' );
        wp_enqueue_script( 'rellax' );
        wp_enqueue_script( 'iscroll' );
        wp_enqueue_script( 'drawer' );
        wp_enqueue_script( 'custom' );
        // JSへ変数受け渡し
        $queried_object = get_queried_object();
        $term = '';
        $taxonomy = '';
        if( isset( $queried_object ) ) {
            $term = $queried_object->slug;
            $taxonomy = $queried_object->taxonomy;
        }
        $sitedata = array(
            'url' => home_url(),
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'term' => $term,
            'taxonomy' => $taxonomy
        );
        wp_localize_script( 'custom', 'sitedata', $sitedata );
    }
    // Javascript 遅延読み込み
    add_filter( 'clean_url', 'add_defer_to_enqueue_script', 11, 1 );
    function add_defer_to_enqueue_script( $url ) {
        if( FALSE === strpos( $url, '.js' ) ) return $url;
        if( strpos( $url, 'jquery.min.js' ) === true ) return $url;
        return "$url' defer charset='UTF-8";
    }
    /* Style
    * ------------------------------ */
    add_action('wp_enqueue_scripts', 'add_style');
    function add_style() {
        $thema_pass = get_stylesheet_directory_uri();
        wp_enqueue_style('normalize', $thema_pass. '/css/normalize.css', array(), false, 'all' );
        wp_enqueue_style('milligram', $thema_pass.'/css/milligram.min.css', array(), false, 'all');
        wp_enqueue_style('drawer', $thema_pass.'/css/drawer.min.css', array(), false, 'all');
        wp_enqueue_style('slick', $thema_pass.'/css/slick.css', array(), false, 'all');
        // wp_enqueue_style('ionicons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), false, 'all');
        // wp_enqueue_style('style', $thema_pass.'/style.css', array(), false, 'all');
        wp_enqueue_style('style', $thema_pass.'/style.css', array(), filemtime( get_stylesheet_directory().'/style.css' ), 'all');
        // echo '<link rel="shortcut icon" type="image/x-icon" href="'.$thema_pass.'/images/favicon.ico" />'; //ファビコン
        // echo '<link rel="apple-touch-icon" sizes="192x192" href="'.$thema_pass.'/images/touchicon.png" />'; //タッチアイコン
    }
}

function head_meta_index() {
    if( is_home() && !is_paged() ) {
        $content = 'index,follow';
    } elseif( is_search() or is_404() ) {
        $content = 'noindex,follow';
    } elseif( !is_category() && is_archive() ) {
        $content = 'noindex,follow';
    } elseif( is_paged() ) {
        $content = 'noindex,follow';
    }
    if( !empty( $content ) ) {
        $meta = '<meta name="robots" content="'. $content .'">';
    }
    return $meta;
}

// パンくず
function get_breadcrumb() {
    global $post;
    $itemtype = 'http://data-vocabulary.org/Breadcrumb';
    // ポストタイプを取得
    $post_type = get_post_type( $post );

    $bc  = '<ol class="breadcrumb clearfix">';
    $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.home_url().'" itemprop="url"><span itemprop="title">'.get_bloginfo('name').'</span></a></li>';

    if( is_home() ){
        // メインページ
        $bc .= '<li>最新記事一覧</li>';
    }elseif( is_search() ){
        // 検索結果ページ
        $bc .= '<li>「'.get_search_query().'」の検索結果</li>';
    }elseif( is_404() ){
        // 404ページ
        $bc .= '<li>ページが見つかりませんでした</li>';
    }elseif( is_date() ){
        // 日付別一覧ページ
        $bc .= '<li>';
        if( is_day() ){
            $bc .= get_query_var( 'year' ).'年 ';
            $bc .= get_query_var( 'monthnum' ).'月 ';
            $bc .= get_query_var( 'day' ).'日';
        }elseif( is_month() ){
            $bc .= get_query_var( 'year' ).'年 ';
            $bc .= get_query_var( 'monthnum' ).'月 ';
        }elseif( is_year() ){
            $bc .= get_query_var( 'year' ).'年 ';
        }
        $bc .= '</li>';
    }elseif( is_post_type_archive() ){
        // カスタムポストアーカイブ
        $bc .= '<li>'.post_type_archive_title('', false).'</li>';
    }elseif( is_category() ){
        // カテゴリーページ
        $cat = get_queried_object();
        if( $cat -> parent != 0 ){
            $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
            foreach( $ancs as $anc ){
                $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link($anc).'" itemprop="url"><span itemprop="title">'.get_cat_name($anc).'</span></a></li>';
            }
        }
        $bc .= '<li>'.$cat->cat_name.'</li>';
    }elseif( is_tag() ){
        // タグページ
        $bc .= '<li>'.single_tag_title("",false).'</li>';
    }elseif( is_author() ){
        // 著者ページ
        $bc .= '<li>'.get_the_author_meta('display_name').'</li>';
    }elseif( is_attachment() ){
        // 添付ファイルページ
        if( $post->post_parent != 0 ){
            $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_permalink( $post->post_parent ).'" itemprop="url"><span itemprop="title">'.get_the_title( $post->post_parent ).'</span></a></li>';
        }
        $bc .= '<li>'.$post->post_title.'</li>';
    }elseif( is_singular('post') ){
        // 記事ページ
        $cats = get_the_category( $post->ID );
        global $excludes;
        foreach( (array)$cats as $ct ) {
            if( !in_array( $ct->cat_ID, $excludes ) ) {
                $cat = $ct;
            }
        }
        if( $cat ) {
            if( $cat->parent != 0 ){
                $ancs = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
                foreach( $ancs as $anc ){
                    $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link( $anc ).'" itemprop="url"><span itemprop="title">'.get_cat_name($anc).'</span></a></li>';
                }
            }
            $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_category_link( $cat->cat_ID ).'" itemprop="url"><span itemprop="title">'.$cat->cat_name.'</span></a></li>';
        } else {
            $tags = get_the_tags();
            if( is_array($tags) ) {
                foreach( $tags as $tag ) {
                    $bc .= '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.get_category_link( $tag->term_id ).'" itemprop="url"><span itemprop="title">'.$tag->name.'</span></a></li>';
                }
            } else {
                $bc .= '';
            }
        }
    }elseif( is_singular('page') ){
        // 固定ページ
        if( $post->post_parent != 0 ){
            $ancs = array_reverse( $post->ancestors );
            foreach( $ancs as $anc ){
                $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_permalink( $anc ).'" itemprop="url"><span itemprop="title">'.get_the_title($anc).'</span></a> /';
            }
        }
        $bc .= '<li>'.$post->post_title.'</li>';
    }elseif( is_singular( $post_type ) ){
        // カスタムポスト記事ページ
        $obj = get_post_type_object($post_type);

        if( $obj->has_archive == true ){
            $bc .= '<li itemscope="itemscope" itemtype="'.$itemtype.'"><a href="'.get_post_type_archive_link($post_type).'" itemprop="url"><span itemprop="title">'.get_post_type_object( $post_type )->label.'</span></a></li>';
        }
        $bc .= '<li>'.$post->post_title.'</li>';
    }else{
        // その他のページ
        $bc .= '<li>'.$post->post_title.'</li>';
    }

    $bc .= '</ol>';

    echo $bc;
}

// 記事一覧　タイトル
function get_archve_title() {
    $title = '';
    if( is_category() ) {
        $title = single_cat_title();
    } elseif( is_tag() ) {
        $title = single_tag_title();
    } elseif( is_tax() ) {
        $title = single_term_title();
    } elseif( is_day() ) {
        $title = get_the_time( 'Y年m月d日' );
    } elseif( is_month() ) {
        $title = get_the_time( 'Y年m月' );
    } elseif( is_year() ) {
        $title = get_the_time( 'Y年' );
    } elseif( is_author() ) {
        $title = esc_html( get_queried_object()->display_name );
    } elseif( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
        $title = 'Archive';
    }
    return $title;
}

// 記事一覧　カテゴリメニュー
function term_child_directly( $taxonomy ) {
    global $excludes;
    $ht = '';
    $args = array(
        'orderby' => 'menu_order',
        'exclude' => $excludes,
        'hide_empty' => false,
        'parent' => 0,
        'taxonomy' => $taxonomy
    );
    $categories = get_categories( $args );
    foreach( $categories as $category ) {
        $ht .= '<div class="column">';
        $ht .= '<div><p class="link-style-border '. $category->slug .'"><a href="'. get_category_link( $category->term_id ) .'">'. $category->name .'</a></p>';
        $params = array( // 親カテゴリIDから子カテゴリーを取得
            'orderby' => 'menu_order',
            'parent' => $category->term_id,
            'hide_empty' => false,
        );
        $cat_childs = get_categories( $params );
        if( $cat_childs ) {
            $ht .= '<div class="category-child">';
            foreach( $cat_childs as $cat_child ) {
                $ht .= '<p class="link-style-border '. $category->slug .'-child ' . $cat_child->slug .'"><a href="'. get_category_link( $cat_child->term_id ) .'">'. $cat_child->name .'</a></p>';
            }
            $ht .= '</div>';
        }
        $ht .= '</div></div>';
    }
    return $ht;
}

// categoryの取得
function or_get_category( $getparent = true ) {
    global $excludes;
    $categories = get_the_category();
    if( !empty( $categories ) ) {
        foreach( $categories as $category ) {
            if( !in_array( $category->cat_ID, $excludes ) ) {
                if( $category->parent != 0 ) {
                    $parent = get_term( $category->parent );
                    if( $getparent === true ) {
                        $ht .= '<p class="post-category link-style-border '. $parent->slug .'"><a href="'. get_category_link( $category->parent ) .'">'.  $parent->name .'</a></p>';
                    }
                    $childclass = $parent->slug .'-child';
                }
                $ht .= '<p class="post-category link-style-border '. $childclass .'"><a href="'. get_category_link( $category->cat_ID ) .'">'. $category->cat_name . '</a></p>';
            }
        }
    }
    return $ht;
}

// tag・taxonomyの表示
function or_get_terms( $taxonomy ) {
    $terms = get_the_terms( $post->ID, $taxonomy );
    if( !empty( $terms ) ) {
        foreach( $terms as $term ) {
            $ht .= '<a href="'. get_category_link( $term->term_id ) .'" itemprop="url">'. $term->name .'</a>';
        }
    } else {
        return false;
    }
    return $ht;
}
