<?php

// 記事一覧（リスト）　カテゴリ・タグ・エリアの表示
function display_posts_cat() {
	$ht = '<ul class="post-categories">';
	// 症状のカテゴリ取得
	$categories = get_the_category();
	if($categories) {
		global $excludes;
		foreach($categories as $cat) {
			if(!in_array($cat->cat_ID, $excludes)) {
				$ht .= '<li><a href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.'</a></li>';
			}
		}
	}
	// 科目の取得
	$taxonomy = 'post_tag';
	$tags = get_the_tags();
	if( $tags ) {
		foreach( $tags as $tag ) {
			//if(!in_array($tag->cat_ID, $excludes)) {
				$ht .= '<li><a href="'.get_category_link($tag->term_id).'">'.$tag->name.'</a></li>';
			//}
		}
	}
	// エリアの取得
	$taxonomy = 'locations';
	$categories_locations = get_the_terms( $post->ID, $taxonomy );
	if($categories_locations) {
		$term = get_categories_most_child( $categories_locations );
		$ancs = array_reverse(get_ancestors( $term->term_id, $taxonomy ));
		$count = count((int)$ancs);
		$num = 0;
		foreach( $ancs as $anc ) {
			$num++;
			if($count !== $num) {
				$ht .= '<li><a href="'.get_category_link($anc).'">'.get_cat_name($anc).'</a></li>';
			}
		}
		$ht .= '<li><a href="'.get_category_link($term).'">'.$term->name.'</a></li>';
	}
	$ht .= '</ul>';
	echo $ht;
}

function single_get_category() {

	$categories = get_the_category();
	if($categories) {
		$ht = '<ul>';
		global $excludes;
		foreach( $categories as $cat ) {
			if(!in_array($cat->cat_ID, $excludes)) {
				$ht .= '<li><a href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.'</a></li>';
			}
		}
		$ht .= '</ul>';
	}
	return $ht;
}

function single_get_tags() {
  $tags = get_the_tags();
  if( $tags ) {
	$ht = '<p id="single-tags-ttl">タグ：</p><ul id="single-tags">';
    foreach( $tags as $tag ) {
      $ht .= '<li><a href="'.get_category_link( $tag->term_id ).'" itemprop="url"><span itemprop="title">'.$tag->name.'</span></a></li>';
    }
    $ht .= '</ul>';
  }
  return $ht;
}

// カテゴリ・タクソノミーの一番最下層の子を取ってくる
// 引数：記事に紐付いている複数カテゴリ　戻り値：最下層の子オブジェクト
function get_categories_most_child( $args ) {
	if($args) {
		$count = count((int)$args); //タクソノミーの個数カウント
		$prcount_bf = 0;
		foreach($args as $post_term) {
			// タームの親数を取得
			$prcount = count(get_ancestors($post_term->term_id, $taxonomy));
			// タームの親数が大きいタームを$termkeyへ入れる
			if($prcount >= $prcount_bf) {
				$prcount_bf = $prcount;
				$term = $post_term;
			}
		}
	}
	return $term;
}

// カテゴリ一覧表示
function display_all_categories($taxname, $empt = true) { // カテゴリーの一覧を取得
	if($taxname == 'category') {
		global $excludes;
		$icon = '';
	} elseif($taxname == 'locations') {
		$excludes = '';
		$icon = '<i class="fa fa-map-marker" aria-hidden="true"></i>';
	} elseif($taxname == 'post_tag') {
		$excludes = '';
		$icon = '';
	} else {
		$excludes = '';
		$icon = '';
	}
	$ht = '<div class="'.$taxname.' clearfix">';
	$args = array(
        'orderby' => 'menu_order',
		'hide_empty' => $empt,
        'exclude' => $excludes,
		'parent' => 0,
		'taxonomy' => $taxname
	);
	$cat_all = get_categories($args); // 親カテゴリーのみ取得

	foreach($cat_all as $value) { // 親カテゴリーを1件ずつ表示
		if($taxname == 'locations') {
			$catkey = array(
				'tax_query' => array(
					array(
						'taxonomy' => $taxname,
						'field' => 'slug',
						'terms' => $value->slug
					)
				)
			);
		} elseif($taxname == 'post_tag') {
			$catkey = array(
				'tax_query' => array(
					array(
						'taxonomy' => $taxname,
						'field' => 'slug',
						'terms' => $value->slug
					)
				)
			);
		} else {
			$catkey = array( $taxname => $value->cat_ID );
		}
		$cat_exist_post = get_posts( $catkey );
		$ht .= '<div id="'.$value->slug.'">';
		if($cat_exist_post) {
			$ht .= '<h2 id="ttl-'.$value->slug.'"><a href="'.get_category_link($value->cat_ID).'">'.$icon.$value->name.'</a></h2>';
		} else {
			$ht .= '<h2 id="ttl-'.$value->slug.'"><span class="gray-out">'.$icon.$value->name.'</span></h2>';
		}
		wp_reset_postdata();
		$params = array( // 親カテゴリIDから子カテゴリーを取得
			'orderby' => 'menu_order',
			'hide_empty' => $empt,
			'parent' => $value->cat_ID,
			'taxonomy' => $taxname
		);
		$catcdn = get_categories($params);
		if($catcdn) { // 子カテゴリーの表示
			$ht .= '<ul>';
			foreach ( $catcdn as $catcd ) {
				if($taxname == 'locations') {
					$catkey = $catcd->slug;
				} elseif($taxname == 'post_tag') {
					$catkey = $catcd->cat_ID;
				} else {
					$catkey = $catcd->cat_ID;
				}
				$cat_exist_post = get_posts( array( $taxname => $catkey ) );
				if($cat_exist_post) {
					$ht .= '<li id="'.$catcd->slug.'"><a href="'.get_category_link($catcd->cat_ID).'">'.$catcd->name.'</a></li>';
				} elseif($taxname == 'locations') {
					$ht .= '<li id="'.$catcd->slug.'" class="gray-out">'.$catcd->name.'</li>';
				} else {
					$ht .= '<li id="'.$catcd->slug.'"><span class="gray-out">'.$catcd->name.'</span></li>';
				}
				wp_reset_postdata();
			}
			$ht .= '</ul>';
		}
		$ht .= '</div>';
	}
	$ht .= '</div>';
	echo $ht;
}

// フッターカテゴリ一覧表示
function display_footer_categories($taxname) { // カテゴリーの一覧を取得
	if($taxname == 'category') {
		global $excludes;
	} else {
		$excludes = '';
	}
	$args = array(
        'orderby' => 'menu_order',
		'order' => 'ASC',
		'hide_empty' => true,
        'exclude' => $excludes,
		'parent' => 0,
		'taxonomy' => $taxname
	);
	$cat_all = get_categories($args); // 親カテゴリーのみ取得

	foreach($cat_all as $value) { // 親カテゴリーを1件ずつ表示
	$ht .= '<div>';
		$ht .= '<h3><a href="'.get_category_link($value->cat_ID).'">'.$value->name.'</a></h3>';

		$params = array( // 親カテゴリIDから子カテゴリーを取得
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'hide_empty' => true,
			'parent' => $value->cat_ID,
			'taxonomy' => $taxname
		);
		$catcdn = get_categories($params);

		if($catcdn) { // 子カテゴリーの表示
			$ht .= '<ul>';
			foreach ( $catcdn as $catcd ) {
				$ht .= '<li><a href="'.get_category_link($catcd->cat_ID).'">'.$catcd->name.'</a></li>';
			}
			$ht .= '</ul>';
		}
		$ht .= '</div>';
	}
	echo $ht;
}

// エリア　記事一覧　上部　直下のエリアを表示
function term_child_directly( $term , $empt = true) {
	wp_reset_postdata();
	$ht = '<div class="locations-relare"><h1 class="heading-relate-locate">「'.$term->name.'」に属するエリア</h1>';
	$ht .= '<div class="locations-children"><ul>';

	$params = array( // 親カテゴリIDから子カテゴリーを取得
		'orderby' => 'menu_order',
		'hide_empty' => $empt,
		'parent' => $term->term_id,
		'taxonomy' => $term->taxonomy
	);
	$term_children = get_terms($params);
	if($term_children) {
		foreach($term_children as $term_child) {
			$catequery = get_posts( array( 'locations' => $term_child->slug ) );
			if($catequery) {
				$ht .= '<li><a href="'.get_category_link($term_child->term_id).'">'.$term_child->name.'</a></li>';
			} else {
				$ht .= '<li class="gray-out">'.$term_child->name.'</li>';
			}
			wp_reset_postdata();
		}
	} else {
		return null;
	}
	$ht .= '</ul><p class="locate-more-buttom">もっと見る<i class="fa fa-chevron-circle-down" aria-hidden="true"></i></p></div></div>';
	echo $ht;
}




// カテゴリをインポート用に書き出す関数
function categories_export($taxname,$empt = true) {
	if($taxname == 'category') {
		global $excludes;
	} else {
		$excludes = '';
	}
	$count = 0;
	$ht = '<h4>■'.$taxname.'</h4><div class="clearfix">';
	$args = array(
        'orderby' => 'menu_order',
		'hide_empty' => $empt,
        'exclude' => $excludes,
		'parent' => 0,
		'taxonomy' => $taxname
	);
	$cat_all = get_categories($args);
	foreach($cat_all as $value): // カテゴリー全部を取得し、1件ずつ表示
		$ht .= $value->name.'$'.$value->slug.'</br>';
		$params = array( // 親カテゴリIDから子カテゴリーを取得
			'orderby' => 'menu_order',
			'hide_empty' => $empt,
			'parent' => $value->cat_ID,
			'taxonomy' => $taxname
		);
		$catcdn = get_categories($params);
		if($catcdn) { // 子カテゴリーの表示
			foreach ( $catcdn as $catcd ) {
				$catpr = get_category($catcd);
				$ht .= $value->name.'$'.$value->slug.'->'.$catpr->name.'$'.$catpr->slug.'</br>';
				$params2 = array( // 親カテゴリIDから子カテゴリーを取得
					'orderby' => 'menu_order',
					'hide_empty' => $empt,
					'parent' => $catcd->cat_ID,
					'taxonomy' => $taxname
				);
				$catcdn2 = get_categories($params);
				if($catcdn2) {
					foreach ( $catcdn2 as $mago ) {
						$magoobg = get_category($mago);
						$ht .= $value->name.'$'.$value->slug.'->'.$catpr->name.'$'.$catpr->slug.'->'.$magoobg->name.'$'.$magoobg->slug.'</br>';
						$count++;
					}
				}
			}
		}
	endforeach;
	$ht .= '</div>';
	echo $ht;
	echo '<p>合計：'.$count.'</p>';
}

// カテゴリ一覧表示 refac
function display_all_categories_refac($taxname, $empt = false) { // カテゴリーの一覧を取得
	if($taxname == 'category') {
		global $excludes;
	} elseif($taxname == 'locations') {
		$excludes = '';
	} else {
		$excludes = '';
	}
	$ht = '<div class="export-tax clearfix">';
	$ht .= get_category_children_roop($taxname, $empt, 0, $excludes);
	$ht .= '</div>';
	echo $ht;
}

// カテゴリの最下層まで全カテゴリを取得する
function get_category_children_roop($taxname, $empt, $parent, $excludes, $currentpr = 0) {
	$args = array(
		'orderby' => 'menu_order',
		'hide_empty' => $empt,
		'exclude' => $excludes,
		'parent' => $parent,
		'taxonomy' => $taxname
	);
	$cats = get_categories($args); // 上層カテゴリ・親カテゴリの取得
	// 再帰した場合　ul
	if( $currentpr > 0 ) {
		$ht .= '<ul>';
	}
	if( $cats ) {
		foreach( $cats as $value ) {
			$cats_child = get_term_children( $value->cat_ID, $taxname );
			// 親の場合　div
			if( $currentpr == 0 ) {
				$ht .= '<div id="'.$value->slug.'">';
				$ht .= '<h2 id="ttl-'.$value->slug.'" class="catehir-'.$currentpr.'"><a href="'.get_category_link($value->cat_ID).'">'.$currentpr.$value->name.'</a></h2>';
			}
			// 子がある場合
			if( $cats_child ) {
				if( $currentpr > 0 ) {
					$ht .= '<li id="ttl-'.$value->slug.'" class="catehir-'.$currentpr.'"><p><a href="'.get_category_link($value->cat_ID).'">'.$currentpr.$value->name.'</a></p>';
				}
				$currentpr++;
				$ht .= get_category_children_roop($taxname, $empt, $value->cat_ID, $excludes, $currentpr);
				$ht .= '</li>';
				$currentpr = $currentpr - 1;
			} elseif(!$currentpr == 0) {
				$ht .= '<li id="ttl-'.$value->slug.'" class="catehir-'.$currentpr.'"><a href="'.get_category_link($value->cat_ID).'">'.$currentpr.$value->name.'</a></li>';
			} else {
				$ht .= '</div>';
			}
			if($currentpr == 0 && $cats_child) {
				$ht .= '</div>';
			}
		}
	}
	if( $currentpr > 0 ) {
		$ht .= '</ul>';
	}
	return $ht;
}

function super_breadcrumb() {
  global $post;
  $itemtype = 'http://data-vocabulary.org/Breadcrumb';
  // ポストタイプを取得
  $post_type = get_post_type( $post );

  $bc  = '<ol class="super_breadcrumb clearfix">';
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
    $bc .= '<li>'.$post->post_title.'</li>';
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



 ?>
