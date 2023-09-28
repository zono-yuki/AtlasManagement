$(function () {
  $('.search_conditions').click(function () {
    //クリックしたら、性別、権限、選択科目が出てくる。
    $('.search_conditions_inner').slideToggle();
    //矢印の向きを変更
    $('.arrow').toggleClass("open", 300);
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    //矢印の向きを変更
    $('.arrow-subjects').toggleClass("open", 300);
  });
});
