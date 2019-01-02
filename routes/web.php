<?php

//Gọi trang đăng nhập
Route::get('admin','adminController@getLogin')->name('getloginPage');
Route::post('login','adminController@postLogin')->name('loginPage');
//goto Logout Page
Route::get('logout', 'adminController@getLogout')->name('logoutPage');

Route::group(['prefix'=>'/admin','middleware'=>'adminLogin'],function(){
    // Gọi trang  chủ admin: dashboard
    Route::get('/home','adminController@getDashboard')->name('adminHomePage');
    /** Begin: QL Nhân viên */
    Route::group(['prefix' => '/quan-ly-nhan-vien'], function () {
        //Gọi trang quản lý nhân  viên
        Route::get('/','adminController@getUserPage')->name('userPage');
        // Gọi trang thêm nhân viên, vì đã gọi bằng view nên không cần phương thức get nữa
        Route::post('/them-nhan-vien','adminController@postUserRegister')->name('registerUserPage');
        //Xóa 1 nhân viên
        Route::get('/xoa-nhan-vien{UserId}','adminController@deleteUserById')->name('deleteUserById');
        //Sửa thông tin nhân viên
        Route::get('/sua-nhan-vien{UserId}','adminController@getUserById')->name('getUserById');
        Route::post('/sua-nhan-vien{UserId}','adminController@postUserById')->name('editUserById');
    });

    /** Begin: QL Sản phẩm*/
    Route::group(['prefix' => '/quan-ly-san-pham'], function () {
        Route::get('/','adminController@getProductPage')->name('productPage');
        Route::post('/them-san-pham','adminController@postAddProduct')->name('addProductPage');
        Route::get('/xoa-san-pham{productId}','adminController@deleteProductById')->name('deleteProductById');
        //Sửa
        Route::get('/sua-san-pham{productId}','adminController@getProductById')->name('getProductById');
        Route::post('/sua-san-pham{productId}','adminController@postEditProductById')->name('editProductById');
        //Chọn loại danh mục con ajax
        Route::post('/danh-muc-con','adminController@getChildCatagoryAjax');
    });

    /** Begin: QL danh mục sản phẩm cha bảng:product_type*/
    Route::group(['prefix' => '/danh-muc-san-pham'], function () {
        Route::get('/','adminController@getProductTypePage')->name('productTypePage');
        Route::post('/them-danh-muc-moi','adminController@postAddProductType')->name('addProductTypePage');
        //Sửa
        Route::get('/sua-danh-muc{id}','adminController@getProductTypeById')->name('getProductTypeById');
        Route::post('/sua-danh-muc{id}','adminController@postEditProductTypeById')->name('editProductTypeById');
        //xóa
        Route::get('/xoa-sanh-muc{id}','adminController@deleteProductTypeById')->name('deleteProductTypeById');
    });

     /** Begin: QL danh mục sản phẩm con cấp 1 bảng:product_type_item*/
     Route::group(['prefix' => '/danh-muc-san-pham-con'], function () {
        Route::get('/','adminController@getProductTypeItemPage')->name('productTypeItemPage');
        //Thêm
        Route::post('/them-danh-muc-con','adminController@postAddProductTypeItem')->name('addProductTypeItemPage');
        //Sửa
        Route::get('/sua-danh-muc-con{id}','adminController@getProductTypeItemById')->name('getProductTypeItemById');
        Route::post('/sua-danh-muc-con{id}','adminController@postEditProductTypeItemById')->name('editProductTypeItemById');
        //xóa
        Route::get('/xoa-sanh-muc-con{id}','adminController@deleteProductTypeItemById')->name('deleteProductTypeItemById');
    });

    /** Begin: QL slider*/
    Route::group(['prefix' => '/main-slide'], function () {
        Route::get('/','adminController@getSlidePage')->name('slidePage');
        //Thêm
        Route::post('/them-slide','adminController@postAddSlide')->name('addSlidePage');
        //Sửa
        Route::get('/sua-slide{id}','adminController@getSlideById')->name('getSlideById');
        Route::post('/sua-slide{id}','adminController@postEditSlideById')->name('editSlideById');
        //xóa
        Route::get('/xoa-sanh-muc{id}','adminController@deleteSlideById')->name('deleteSlideById');
    });

    /** Begin: QL Tin tức*/
    Route::group(['prefix' => '/tin-tuc'], function () {
        Route::get('/','adminController@getNewsPage')->name('newsAdminPage');
        //Thêm
        Route::post('/them-tin-moi','adminController@postAddNews')->name('addNewsAdminPage');
        //Sửa
        Route::get('/sua-tin-tuc{id}','adminController@getNewsById')->name('getNewsById');
        Route::post('/sua-tin-tuc{id}','adminController@postEditNewsById')->name('editNewsById');
        //xóa
        Route::get('/xoa-tin-tuc{id}','adminController@deleteNewsById')->name('deleteNewsById');
    });

    /** Begin: QL Đơn hàng*/
    Route::group(['prefix' => '/don-hang'], function () {
        Route::get('/','adminController@getBillPage')->name('billPage');

        //xóa
        Route::get('/xoa-don-hang{id}','adminController@deleteBillById')->name('deleteBillById');
    });

});

/** Phần Client */
Route::group(['prefix' => '/'], function () {
    //Gọi trang chủ
    Route::get('trang-chu','clientController@getHomePage')->name('homePageClient');
    Route::get('getAllProductPag','clientController@getAllProductPaginate')->name('getAllProduct');
    Route::get('getsaleProductPag','clientController@getSaleProductPaginate')->name('getSaleProduct');

    //Gọi trang Danh mục sản phẩm cha ở menu
    Route::get('danh-muc-cha/{typeProductId}', 'clientController@getSubProductType')->name('subProductTypePage');
    //Gọi trang Danh mục sản phẩm cha ở menu con
    Route::get('danh-muc-con/{typeProductItemId}','clientController@getChildProductType')->name('childProductTypePage');
    //Gọi trang tìm kiếm sản phẩm
    Route::get('tim-san-pham', 'clientController@getSearchProduct')->name('searchProductPage');
    //Gọi trang chi tiết sản phẩm
    Route::get('chi-tiet-san-pham/{idProduct}', 'clientController@getDetailProduct')->name('detailProductPage');

    //Gọi trang Giỏ hàng , Cart
    Route::group(['prefix' => '/'], function () {
        //Tạo route Nhận về id từ các trang sản phẩm  khi click nút mua hàng
        Route::get('gio-hang/{idProduct}','clientController@getAddToCart')->name('addToCart');
        Route::post('gio-hang-ajax','clientController@getAddToCartAjax');

        //Xóa giỏ hàng
        Route::get('delete-cart/{id}','clientController@getDelItemCart')->name('delItemCart');
        Route::post('delete-cart-ajax','clientController@getDelItemCartAjax');

        //Update gio hang
        Route::post('update-cart-ajax','clientController@updateCartAjax');

        //Đặt hàng
        Route::get('dat-hang','clientController@getProductOrder')->name('orderPage');
        Route::post('dat-hang','clientController@postProductOrder')->name('orderPage');
        Route::get('dat-hang/{idProduct}','clientController@getProductOrderNow')->name('orderNowPage');
//        Route::post('payments/internal','clientController@postInternal')->name('posts.payment');
        Route::get('payments/get-internal','clientController@getInternal')->name('payments.internal');
    });

    //Gọi trang tin tức
    Route::group(['prefix' => '/tin-tuc'], function () {
        //goi
        Route::get('/','clientController@getNewsPage')->name('newsPage');
        Route::get('/{id}','clientController@getDetailNewsPage')->name('detailNewsPage');

    });

});








