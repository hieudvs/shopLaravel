
<!-- Begin: giỏ hàng -->
<div id="cart">
@if (Session::has('cart'))
    <span hidden> {{$display ='block'}} </span>
@else
    <span hidden> {{$display ='none'}} </span>
@endif

<div  class="cart" style="display:{{$display}};">
    <div class="fix-cart">
        <div class="fix-cart-list">
            <div class="container cart-product">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-sx-12">
                        <table class="table table-hover">
                            <thead style="border-top:none;">
                              <tr>
                                <th scope="col" colspan="2" >Sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Tổng tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                                <form action="" method="post" accept-charset="utf-8" id="cartSubmit">
                                    @if (Session::has('cart'))
                                    @foreach ($product_cart as $product)
                                    <tr class="w-100">
                                        <td class="w-10" >
                                            <a class=""
                                                href="{{ route('delItemCart',$product['item']['id']) }}"
                                                style="color: red; line-height: 62px; margin-right: 10px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a class="thumbnail-cart" href="#">
                                                <img class="lazy" data-src="uploads/products/{{ $product['item']['images'] }}" alt="" style="width: 50px; height: 60px;">
                                            </a>
                                        </td>
                                        <td class="w-40" ><h4 class="font-weight-bold">{{ $product['item']['name'] }}</h4></td>
                                        <td class="w-10">
                                            <input style="width:70px;" min="1" max="50"
                                                    onchange="changePriceFlash(this, {{$product['item']['id']}})"
                                                    type="number" class="form-control" id="numItem"
                                                    name="numItem[{{$product['item']['id']}}]"
                                                    value="{{ $product['qty'] }}">
                                        </td>
                                        <td class="w-20">
                                            <!-- Begin: Chọn giá hiển thị   -->
                                            @if ($product['item']['promotion_price'] == 0)
                                            <h5 class="price-original">
                                                <span hidden> {{ $priceProduct = $product['item']['unit_price'] }}</span>
                                                <span> {{ number_format($product['item']['unit_price'])}}</span>
                                                <sup>đ</sup>
                                            </h5>
                                            @else
                                                <span hidden> {{ $priceProduct = $product['item']['promotion_price'] }}</span>
                                                <h5 class="price-sale">
                                                    <span> {{ number_format($product['item']['promotion_price'])}}</span>
                                                    <sup>đ</sup>
                                                </h5>
                                                <h5 class="price-original-sale">
                                                    <span class="h6"> {{ number_format($product['item']['unit_price'])}}</span>
                                                    <sup>đ</sup>
                                                </h5>
                                        @endif
                                        <!-- End: Chọn giá hiển thị   -->
                                        </td>
                                        <td class="w-20">
                                            <strong id="viewPrice-{{$product['item']['id']}}"
                                                data-price="{{ $priceProduct }}">
                                                <span class="h6 font-weight-bold ">{{number_format($product['qty'] *   $priceProduct) }}</span>
                                                <sup>đ</sup>
                                            </strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-show">
            <!-- Begin: Chọn giá hiển thị   -->
            @if (Session::has('cart'))
                @if ($product['item']['promotion_price'] == 0)
                    <span hidden> {{ $priceProduct = $product['item']['unit_price'] }}</span>
                @else
                    <span hidden> {{ $priceProduct = $product['item']['promotion_price'] }}</span>
                @endif

            @endif
            <!-- End: Chọn giá hiển thị   -->

            {{-- <a id="show_cart" title="Xem chi tiết">
                Giỏ hàng (@if (Session::has('cart')){{ $totalCart = session('cart')->totalQty }}@else 0 @endif)
                <i class="fa fa-angle-double-up"></i>
                <span class="price"><span>@if (Session::has('cart')) {{ number_format(session('cart')->totalPrice) }}@else Trống @endif</span><sup>đ</sup></span>
            </a> --}}

            <a id="show_cart" title="Xem chi tiết">
                    Giỏ hàng
                    <i class="fas fa-shopping-cart"></i>
                    <span class="price"><span>@if (Session::has('cart')) {{ number_format(session('cart')->totalPrice) }}@else Trống @endif</span><sup>đ</sup></span>
                </a>
            <a class="btn btn-default btn-xs btn-fix-cart" href=" {{route('orderPage')}} " title="">Đặt Hàng</a>
        </div> <!-- End: giỏ hàng -->

    </div> <!-- End: giỏ hàng -->



    <!-- Begin: btn-fix-cart-right -->
    <a href="{{route('orderPage')}}"  title="Cart" id="btnCart">
        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
        <span class="qtyProductCart ">@if (Session::has('cart')){{ $totalCart = session('cart')->totalQty }}@else 0 @endif</span>
    </a>
    <div class="fix-cart-info text-center " style="display:none">
        <h5 class="h6 "> Tổng tiền</h5>
        <span class="h6">
            @if (Session::has('cart')) {{ number_format(session('cart')->totalPrice) }}@else 0 @endif
        </span>  <sup class="h6 ">đ</sup>
    </div>
    <!-- End: btn-fix-cart-right -->
</div> <!-- End: class:cart -> ẩn giỏ hàng khi không có hàng -->
</div>

<script>

    //Begin: Thêm bớt giỏ hàng ở client
    function changePriceFlash(e, id){
        var item  = $(e).val();
        if( item > 0 ){

            var price = $('#viewPrice-'+id).data('price');
            var itemtotal = $('#viewPrice-'+id).data('itemtotal');
            var newprice = price * item;
            $('#viewPrice-'+id).data('itemtotal', newprice);
            $('#viewPrice-'+id+'>span').html(Number(newprice).toLocaleString('vi'));
            var subtotal = $('#flash-subtotal').data('subtotal');
            var newsubtotle = (subtotal - itemtotal) + newprice;
            $('#flash-subtotal').data('subtotal', newsubtotle);
            $('#flash-subtotal>span').html(Number(newsubtotle).toLocaleString('vi'));
            var alltotal = $('#flash-total').data('total');
            var newalltotal = (alltotal - itemtotal) + newprice;
            $('#flash-total').data('total', newalltotal);
            $('#flash-total>span').html(Number(newalltotal).toLocaleString('vi'));
        }
    };  //End: Thêm bớt giỏ hàng ở client

</script>










