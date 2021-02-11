// CSRF token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// 顯示會員專區清單
function showMemberAreaList() {
    $('.member-area-list').slideToggle();
}
// 顯示搜尋區塊
function showSearchBox() {
    $('.search-box').toggleClass('show-flex');
}
// 會員登出
function userLogout() {
    $.ajax({
        url: '/user/logoutProcess', 
        method: 'POST', 
        dataType: 'JSON', 
        success: function(res) {
            alert(res.ret_val);
            location.reload();
        }
    });
}