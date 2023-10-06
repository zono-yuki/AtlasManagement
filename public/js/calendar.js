
//予約削除ボタン モーダル表示
$(function () {

});

//編集モーダル/////////////////////////////////////////////////////////////////////////////
var modal = document.getElementById("myModal");
var close__modal = document.getElementById("closeModal");

$(".cancelModal").each(function () {//each(function ()つぶやきがある数、.cancelModalはあるのでそれぞれを使えるように呼び出している。

  $(this).on('click', function () {//ボタンを押した時モーダルが表示される
    var setting_reserve = $(this).attr('setting_reserve');
    $('#setting_reserve_id').val(setting_reserve);//idを受け取る、idをhiddenでcontllorerに渡す。

    var post = $(this).attr('post');
    $('#textarea_id').text(post);//投稿している内容を引っ張ってきて表示するtext

    modal.style.display = "block";//モーダルを表示する
    return false;
  });
})

//閉じるボタンを押すと戻る
close__modal.onclick = function() {
  modal.style.display = "none";
}
//ウィンドウを押すと戻る
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    return false;
  }
}
//////////////////////////////////////////////////////////////////////////////////////////
