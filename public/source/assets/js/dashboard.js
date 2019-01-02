$(function(){

    // dùng hàm setInterval
    var t = setInterval(function(){
        $('.thongbao').addClass('hide_box');
        clearInterval(t);
    },3000);

/** ========Begin: trạng thái active cho menu left =============*/
    var btnSidebar = document.querySelectorAll('.sidebar-sticky .nav-link');
     for(var i = 0; i < btnSidebar.length; i++){
        btnSidebar[i].addEventListener('click',function(){
            console.log(this);
             //B1: Xóa tất cả các nút được cố định active ở html mô phỏng trước rồi add class
             for(var i = 0; i < btnSidebar.length; i++){
                 btnSidebar[i].classList.remove('active');
             }
             this.classList.add('active');
         })

    }
/** ========Begin: trạng thái active cho menu left =============*/




})




