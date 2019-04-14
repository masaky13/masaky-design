$(function($){
    // dorawer
    $(".drawer").drawer();

    var content_top = $("#header").height() + 10;
    $("#firstposts").css("top",content_top );
    $("#content").css("top",content_top );

    // slick slider top
    $('.firstview').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        fade: true,
        arrows: false,
        cssEase: 'linear'
    });

    // parlx
    var rellax = new Rellax(' .rellax ',{ center: true });

    // Page top
    $("#page-top").hide();

    // Work list Ajax
    var paged = 2;
    var get_post_count = parseInt($('#post-count').text()); // もっと読むボタンを押した時に取得する数
    var found_posts = parseInt($('#found-posts').text());
    // 記事のローディング
    $("#post-list-more").on("click", function() {
        var term = $('h1').text();
        var post_count = parseInt($('#post-count').text());
        thiselm = $(this);
        thiselm_html = thiselm.html();
        $(this).html('<i class="material-icons spinanime">sync</i>');
        $.ajax({
            type: 'POST',
            url: sitedata.url+'/wp-admin/admin-ajax.php',
            data: {
                'action': 'ajax_loadpost',
                'term': sitedata.term,
                'paged': paged
            },
            timeout: 10000,
            success: function(data) {
              post_count = post_count + get_post_count;
              paged++;
              data = data.slice(0, -1);
              if (post_count >= found_posts) {
                  thiselm.remove();
                  post_count = found_posts;
              }
              $('#post-count').text(post_count);
              thiselm.before(data);
              thiselm.html(thiselm_html);
            },
            error: function(xhr, textStatus, error) {
                error = 'サーバーの応答がありません。（処理エラー）';
                $("#post-list-more").html(error);
            }
        });
        return false;
    });
});

$(function(){
    // #で始まるアンカーをクリックした場合に処理
    $('a[href^=#]').click(function() {
        // スクロールの速度
        var speed = 400; // ミリ秒
        // アンカーの値取得
        var href= $(this).attr("href");
        // 移動先を取得
        var target = $(href == "#" || href == "" ? 'html' : href);
        // 移動先を数値で取得
        var position = target.offset().top;
        // スムーススクロール
        $('body,html').animate({scrollTop:position}, speed, 'swing');
        return false;
    });
});

var startPos = 0,winScrollTop = 0;
$(window).on('scroll',function(){
    winScrollTop = $(this).scrollTop();
    if (winScrollTop >= startPos) {
        $('#header').addClass('hide');
    } else {
        $('#header').removeClass('hide');
    }
    startPos = winScrollTop;
});

// $(window).scroll(function(){
//   var a = $("#page-top");
//   if($(this).scrollTop()>100){
//     $("#header").addClass('nav_fixed');
//     $("#header").css('position','fixed');
//   }else{
//     $("#header").removeClass('nav_fixed');
//     $("#header").css('position','absolute');
//   }
//   if($(this).scrollTop()>400){
//     a.fadeIn();
//   }else{
//     a.fadeOut();
//   }
//   $('.fade-in').each(function(){
//       var POS = $(this).offset().top;  //fade-inがついている要素の位置
//       var scroll = $(window).scrollTop();  //スクロール一
//       var windowHeight = $(window).height();  //ウィンドウの高さ
//
//       if (scroll > POS - windowHeight + windowHeight/5){
//           $(this).css("opacity","1" );
//       } else {
//           $(this).css("opacity","0" );
//       }
//   });
// });
// $(".sumple").on('click', function (event) {
//   event.preventDefault();
//
//   var error = '';
//   var $button = $(this);
//   var data = {};
//   data['action'] = 'ajax_posts_list';
//   data['slug'] = $(this).attr('class');
//   var export_area = $(".work_list");
//   export_area.css("height", export_area.height());
//   $(".work_list").html("読み込み中...");
//   $.ajax({
//     type: 'POST',
//     url: siteinfo.url+'/wp-admin/admin-ajax.php',
//     data: data,
//     timeout: 10000,
//     beforeSend: function (xhr, settings) {
//       // 繝懊ち繝ｳ繧堤┌蜉ｹ蛹悶＠縲∽ｺ碁㍾騾∽ｿ｡繧帝亟豁｢
//       $button.attr('disabled', true);
//     },
//     complete: function (xhr, textStatus) {
//       // 繝懊ち繝ｳ繧呈怏蜉ｹ蛹悶＠縲∝�騾∽ｿ｡繧定ｨｱ蜿ｯ
//       $button.attr('disabled', false);
//     },
//     success: function (data) {
//       export_area.css("height", "auto");
//       export_area.hide();
//       export_area.html(data);
//       export_area.fadeIn(1000);
//     },
//     // 騾壻ｿ｡螟ｱ謨玲凾縺ｮ蜃ｦ逅�
//     error: function (xhr, textStatus, error) {
//       error = 'サーバーの応答がありません。（処理エラー）';
//       $('.receive_area').html(error);
//     }
//   });
// });
