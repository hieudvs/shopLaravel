@extends('layouts.masterClient')
@section('style')
    <style> nav.menu{display:none;} </style>
@endsection
@section('content')
 <!-- Begin: page title -->
<div class="container d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2 mt-2">
    <h1 class="h7 text-uppercase font-weight-bold text-primary"> Chi tiết sản phẩm </h1>
</div> <!-- End: page title  -->

<div id="detail-product">
    <div class="container bg-white rounded" style="min-height:600px;">
        <div class="row">
            <main class="mt-3 w-100">
                @if (!empty($producDetail))


                <div class="left-column col-md-5 col-lg-5 w-35">
                    <img data-image="black" src="http://owen.com.vn/image.php?width=420&height=560px&image=http://owen.com.vn/images/product/AH3932E5_AR6279D_386K_100P_RL.JPG" alt="" style="z-index : -1;">
                    <img data-image="blue" src="http://owen.com.vn/image.php?width=420&height=560px&image=http://owen.com.vn/images/product/AGVCT1LN_AR6292D_386K_100poly_RL.JPG" alt="" style="z-index : -1;">
                    <img data-image="red" class="active" src="{{asset("uploads/products/$producDetail->images")}}" alt="" style="z-index : -1;">
                </div>
                <div class="right-column col-md-7 col-lg-7 w-65">
                    <div class="product-description">
                        <span>OWEN SHOP</span>
                        <h1>{{$producDetail->name}}</h1>
                        <p >{!! $producDetail->description !!}</p>
                    </div>
                    <div class="product-configuration">
                        <div class="product-color w-50">
                            <span>Color</span>
                            <div class="color-choose">
                                <div>
                                    <input data-image="red" type="radio" id="red" name="color" value="red" checked>
                                    <label for="red"><span></span></label>
                                </div>
                                <div>
                                    <input data-image="blue" type="radio" id="blue" name="color" value="blue">
                                    <label for="blue"><span></span></label>
                                </div>
                                <div>
                                    <input data-image="black" type="radio" id="black" name="color" value="black">
                                    <label for="black"><span></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="cable-config">
                            <span>Size</span>
                            <div class="cable-choose">
                                <button>X</button>
                                <button>M</button>
                                <button>L</button>
                            </div>
                            {{-- <a href="#">like</a> --}}
                        </div>
                    </div>

                    <div class="product-detail-price">
                        <span class="mr-5 float-left">
                            @if ($producDetail->promotion_price == 0)
                                <h5 class="price-original">
                                    <span> {{ number_format($producDetail->unit_price)}}</span>
                                    <sup>đ</sup>
                                </h5>
                            @else
                                <h5 class="price-sale">
                                    <span> {{ number_format($producDetail->promotion_price)}}</span>
                                    <sup>đ</sup>
                                </h5>
                                <h5 class="price-original-sale">
                                    <span> {{ number_format($producDetail->unit_price)}}</span>
                                    <sup>đ</sup>
                                </h5>
                            @endif
                            </span>

                        <a href="{{route('orderNowPage',$producDetail->id)}}" class="btn btn-danger">Đặt hàng</a>
                        <a onclick="addToCart({{$producDetail->id}})" href="#" class="btn btn-outline-danger cart-btn mr-2">Thêm vào giỏ hàng</a>
                        <a href="{{route('homePageClient')}}" class="btn btn-outline-secondary">Chọn sản phẩm khác</a>
                    </div>
                    </div>
                </div>
                @endif
            </main>

        </div>
    </div>
</div>

@include('client.cart')

@endsection
@section('script')

<script>
    //Begin: top menu dropdown hidden
    $('.catalogies ').hover(function () {
            $('nav.menu').show();
        }, function () {
            $('nav.menu').hide();
        }
    );


    $(document).ready(function() {

        $('.color-choose input').on('click', function() {
            var headphonesColor = $(this).attr('data-image');
            $('.active').removeClass('active');
            $('.left-column img[data-image = ' + headphonesColor + ']').addClass('active');
            $(this).addClass('active');
        });
    });

    /*==================== Begin: Ajax add to cart =========================*/

    function addToCart($idProductItem){
        // alert($idProductItem);
        $.ajaxSetup({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        }); // fix lỗi 419

        $.ajax({
            type: "POST",
            url: "http://localhost/owen/public/gio-hang-ajax",
            data: {'idProduct' :  $idProductItem},
            dataType: "json",
            success: function (data) {
                $("#cart").load(" #cart");
               // location.reload(true);

            }
        });
    };
/*==================== End: Ajax add to cart =========================*/

</script>
@endsection


