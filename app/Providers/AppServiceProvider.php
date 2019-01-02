<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Cart;
use Session;
use App\product;
use App\product_type;
use App\product_type_item;
use App\slide;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(250); //cấu hình giá trị chuổi khi chạy bằng migrate



        // Danh mục sản phẩm cha
        view()->composer(['client.header','admin.product'], function ($toView) {
            $subCategory = product_type::all();
            $toView->with('subCategory', $subCategory);
        });
        // Danh mục sản phẩm con
        view()->composer(['client.header','admin.product'], function ($toView) {
            $itemCategory = product_type_item::all();
            $toView->with('itemCategory', $itemCategory);
        });

        // Đẩy dữ liệu Cart ra trang chứa giỏ hàng: cart.blade và order.blade
        view()->composer(['client.cart','client.order'], function ($cartToView) {
            // kiểm tra xem biến session cart này có không
            // session cart này được tạo ở controler: getAddToCart
            if (Session('cart')) {
                $oldCart = Session::get('cart');
                // gọi đến model Cart gửi đi biến $oldCart
                $cart = new Cart($oldCart);  //dd($cart);
                // Đẩy data ra view
                $cartToView->with([ 'cart'=>Session::get('cart'),
                                'product_cart'=>$cart->items,
                                'totalPrice'=>$cart->totalPrice,
                                'totalQty'=>$cart->totalQty ]);
            }
        });

        // Đâye slide ra view client.slide
        view()->composer(['client.slide'], function ($toView) {
            $dataSlide = slide::all();
            $toView->with('dataSlide', $dataSlide);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
