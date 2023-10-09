
//予約削除ボタン モーダル表示
$(function () {

});

//編集モーダル/////////////////////////////////////////////////////////////////////////////
var modal = document.getElementById("myModal");
var close__modal = document.getElementById("closeModal");

$(".cancelModal").each(function () {

  $(this).on('click', function () {//ボタンを押した時モーダルが表示される
    var setting_reserve = $(this).attr('setting_reserve');
    $('#setting_reserve_id').text(setting_reserve);//表示する
    $('#settings_reserve_id').val(setting_reserve);//input hiddenに送る

    var setting_part = $(this).attr('setting_part');
    $('#setting_part_id').text(setting_part);//表示する
    $('#settings_part_id').val(setting_part);//input hiddenに送る

    var part = $(this).attr('part');
    $('#part').val(part);//input hiddenに送る contoroller用

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
