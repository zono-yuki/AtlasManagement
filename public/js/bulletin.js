
$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });


//いいねボタンの実装

  //いいねしていない場合
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  //いいねしていた場合
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });



// 投稿の編集モーダルを表示する処理 & 渡された変数をモーダルに表示する処理
  $('.edit-modal-open').on('click',function(){

    $('.js-modal').fadeIn();//編集モーダルを表示させる。

    //属性と値(タイトル)を変数に入れる処理
    var post_title = $(this).attr('post_title');

    //属性と値(投稿内容)を変数に入れる処理
    var post_body = $(this).attr('post_body');

    //属性と値(投稿id)を変数に入れる処理
    var post_id = $(this).attr('post_id');


    //モーダルのタイトル部分に既存のタイトルを入れる処理
    $('.modal-inner-title input').val(post_title);

    //モーダルの投稿部分に既存のタイトルを入れる処理
    $('.modal-inner-body textarea').text(post_body);

    //投稿idをhiddenのvalueに入れる処理
    $('.edit-modal-hidden').val(post_id);

    return false;

  });


  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();//モーダルを閉じる
    return false;
  });

  //カテゴリー検索(メインカテゴリを押すと、矢印が反転して、サブカテゴリーが表示される。)
  $('.main_conditions').click(function () {
    //クリックしたら、性別、権限、選択科目が出てくる。
    $('.main_conditions_inner').slideToggle();
    //矢印の向きを変更
    $('.arrow').toggleClass("open", 300);
  });

  //------------------------ここから【new】サブカテゴリー、アコーディオンメニュー作成中
  const accordions = document.getElementsByClassName("accordion");//まず、accordionから複数の要素を取り出してaccordionsに収める。

  for (let i = 0; i < accordions.length; i++) {//取り出したaccordionの数だけイベントリスナーを付与していく。
    accordions[i].addEventListener("click", function () {//accordion[0]〜それぞれをクリックした時
      this.classList.toggle("active");//それぞれのリストにactiveクラスをつける。
      const panel = this.nextElementSibling;// panelをaccordionの妹クラスと設定する。
      if (panel.style.maxHeight) {//もしmax-heightが指定していたらmax-heightをnullにする。
        panel.style.maxHeight = null;
      } else {//そうでなければ、max-heightを指定する。scrollHeightは隠れている部分も含めた高さのこと。
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
  });
  }



});
