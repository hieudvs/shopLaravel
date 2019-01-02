@extends('layouts.masterClient')

@section('style')
    <style> nav.menu{display:none;} </style>
@endsection

@section('content')

<!-- Begin: page title -->
<div class="container d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2 mt-2">
        <h1 class="h7 text-uppercase font-weight-bold text-primary"> Giỏ hàng </h1>
</div> <!-- End: page title  -->

<div id="order-cart" >
    <div class="container bg-white rounded" style="min-height:500px;">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class=" mt-3 mb-3">
                    <strong style="color:#4caf50;"> <i class="fa fa-info-circle" ></i> Thông báo:
                    </strong>
                    <span  id="thongbao"></span>
                </div>

                <table class="table table-hover">
                    <thead style="border-top:none;">
                      <tr>
                        <th scope="col" colspan="2" >Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Tổng</th>
                      </tr>
                    </thead>
                    <tbody >
                        <form action="" method="post" accept-charset="utf-8" >
                            @if (Session::has('cart'))
                            @foreach ($product_cart as $product)
                            <tr class="w-100"  id="showProductBuy-{{$product['item']['id']}}" >

                                <td class="w-10" >
                                    <a onclick="deleteProductAjax(this,{{$product['item']['id']}})"
                                        style="color: red; line-height: 62px; margin-right: 10px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>  <!-- End: btn xóa  -->

                                    <a class="thumbnail-cart" href="#">
                                        <img src="uploads/products/{{ $product['item']['images'] }}" alt="" style="width: 50px; height: 60px;">
                                    </a>  <!-- End: hình đại diện sản phẩm  -->
                                </td>  <!-- End: Nút xóa + hình đại diện SP  -->

                                <td class="w-40 nameOder" ><h4 class="font-weight-bold">{{ $product['item']['name'] }}</h4></td>

                                <td class="w-10">
                                    <input style="width:70px;" min="1" max="50"
                                            onchange="changePriceFlash(this, {{$product['item']['id']}})"
                                            type="number" class="form-control" id="numItem-{{$product['item']['id']}}"
                                            name="numItem[{{$product['item']['id']}}]"
                                            value="{{ $product['qty'] }}" >
                                    {{-- <span id="oldAmount" data-oldAmount=" {{ $product['qty'] }}" > {{ $product['qty'] }} </span> --}}
                                </td> <!-- End: Số lượng  -->

                                <td class="w-20" >
                                    <!-- Begin: Chọn Tong tien   -->
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
                                    <!-- End: tong tien  -->

                                </td> <!-- End: Đơn giá  -->

                                <td class="w-20" style="min-width:120px">
                                    <strong id="viewPrice-{{$product['item']['id']}}"
                                    @if (Session::has('cart'))
                                        data-price=" {{ $priceProduct }}"
                                        data-itemtotal="{{($product['qty'] * $priceProduct) }}">
                                            <span
                                                class="h6 font-weight-bold "> {{$totalPrice = number_format($product['qty'] * $priceProduct) }}
                                            </span>
                                            <sup>đ</sup>
                                        @endif

                                    </strong>
                                </td> <!-- End: Tổng giá từng loại SP  -->
                            </tr>
                            @endforeach
                            @endif
                        </form>
                    </tbody>
                </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="btn btn-outline-success" href="{{route('homePageClient')}}">
                <span class="glyphicon glyphicon-shopping-cart"></span> Tiếp tục mua hàng
            </a>
            <br />
        </div>
    </div>
        <!--Begin: Form thông tin người đặt hàng  -->
    <div class="">
        <br />
        <div class="cart-form">
            <form action="{{route('orderPage')}}" method="post" role="form" id="orderForm" enctype="multipart/form-data">
             {{-- <form action=""  role="form" id="btnSubmitCart" enctype="multipart/form-data"> --}}
                @csrf
                <div class="row">
            <div class="col-md-6">
                    <h3 class="cart-form-title">Thông tin khách hàng</h3>
                <div class="form-group">
                    <label>Họ và tên:*</label>
                    <input type="text"  id="txt_order_name" name="txt_order_name" required>
                </div> <!-- End: Form-group  -->
                <div class="form-group">
                    <label>Số điện thoại:*</label>
                    <input type="text"  id="txt_order_phone" name="txt_order_phone" required>
                </div> <!-- End: Form-group  -->
                <div class="form-group">
                    <label>Địa chỉ Email: </label>
                    <input type="email" id="txt_order_email" name="txt_order_email" required>
                </div> <!-- End: Form-group  -->
                <div class="form-group">
                    <label>Địa chỉ giao hàng*:</label>
                    <input type="text"  name="txt_order_address" required>
                </div> <!-- End: Form-group  -->
                <div class="form-group">
                    <label>Ghi chú đơn hàng:</label>
                    <textarea  name="txt_order_message"></textarea>
                </div> <!-- End: Form-group  -->
            </div>
            <!--Begin: Chọn loại hình thanh toán  -->
            <br />
            <div class="col-md-6">
                <div class="cart-info">
                    <div class="product-option payment">
                        <p><label><input onchange="showPaymentnote('0');" type="radio"  name="txt_order_payment" style="display:inline-block" checked value="COD"> Thanh toán khi nhận hàng</label></p>
                        <p  id="product-pay-note-0" class="product-pay-note">Khi nhận được hàng, quý khách vui lòng thanh toán trực tiếp cho nhân viên giao hàng</p>
                        <p><label><input onchange="showPaymentnote('1');" type="radio"  name="txt_order_payment" value="ATM"> Thanh toán chuyển khoản</label></p>
                        <p style="display: none;" id="product-pay-note-1" class="product-pay-note"><a href="#huong-dan-thanh-toan" target="_blank">Xem hướng dẫn chuyển khoản tại đây</a></p>
                    </div>
                </div>
                <div class="cart-info">
                    <div class="product-option">
                        <p>
                            <span><strong>Thành tiền</strong>: </span>
                            @if (Session::has('cart'))
                                <span id="beginShowTotalPrice">
                                    <span class="h6 text-danger font-weight-bold ">
                                        {{ number_format(session('cart')->totalPrice) }}
                                    </span>
                                    <sup class="text-danger font-weight-bold ">đ</sup>
                                </span>
                                <span id="endShowTotalPrice">
                                    <span id="flash-subtotal" data-subtotal="{{ session('cart')->totalPrice }} ">
                                        <span id="reLoadPriceTotol" class="h6 text-danger font-weight-bold">   {{number_format(session('cart')->totalPriceAll) }}</span>
                                        <sup class="text-danger font-weight-bold ">đ</sup>
                                    </span>
                                </span>
                            @else
                                <span id="emptyCart" class="h6 text-danger font-weight-bold ">0</span>
                            @endif
                            <span style="display:none;">
                                @if (Session::has('cart')){{  $money = number_format(session('cart')->totalPrice) }}@else 0 @endif
                                @if (!empty($money)){{ $total = (int)$money * 100000}} @endif
                            </span>
                        </p>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger" form="orderForm" id="">Đặt Hàng</button>
            </div>
            <div style="display:none;">
                <input type="hidden" name="Title" value="VPC 3-Party" />
                <table width="100%" align="center" border="0" cellpadding='0'
                       cellspacing='0'>
                    <tr class="shade">
                        <td width="1%">&nbsp;</td>
                        <td width="40%" align="right"><strong><em>URL cổng thanh toán - Virtual Payment Client
                                    URL:&nbsp;</em></strong></td>
                        <td width="59%">
                            <input type="text"
                                name="virtualPaymentClientURL"
                                size="63" value="https://mtf.onepay.vn/onecomm-pay/vpc.op"
                                maxlength="250" />
                        </td>
                    </tr>
                </table>
                <center>
                    <table class="background-image" summary="Meeting Results">
                        <thead>
                        <tr>
                            <th scope="col" width="250px">Name</th>
                            <th scope="col" width="250px">Input</th>
                            <th scope="col" width="250px">Chú thích</th>
                            <th scope="col">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><strong><em>Merchant ID</em></strong></td>
                            <td><input type="text" name="vpc_Merchant" value="ONEPAY" size="20"
                                       maxlength="16" /></td>
                            <td>Được cấp bởi OnePAY</td>
                            <td>Provided by OnePAY</td>
                        </tr>
                        <tr>
                            <td><strong><em>Merchant AccessCode</em></strong></td>
                            <td><input type="text" name="vpc_AccessCode" value="D67342C2"
                                       size="20" maxlength="8" /></td>
                            <td>Được cấp bởi OnePAY</td>
                            <td>Provided by OnePAY</td>
                        </tr>
                        <tr>
                            <td><strong><em>Merchant Transaction Reference</em></strong></td>
                            <td><input type="text" name="vpc_MerchTxnRef"
                                       value="<?php
                                       echo date ( 'YmdHis' ) . rand ();
                                       ?>" size="20"
                                       maxlength="40" /></td>
                            <td>ID giao dịch, giá trị phải khác nhau trong mỗi lần thanh(tối đa 40 ký tự)
                                toán</td>
                            <td>ID Transaction - (unique per transaction) - (max 40 char)</td>
                        </tr>
                        <tr>
                            <td><strong><em>Transaction OrderInfo</em></strong></td>
                            <td><input type="text" name="vpc_OrderInfo" value="JSECURETEST01"
                                       size="20" maxlength="34" /></td>
                            <td>Tên hóa đơn - (tối đa 34 ký tự)</td>
                            <td>Order Name will show on payment gateway (max 34 char)</td>
                        </tr>
                        <tr>
                            <td><strong><em>Purchase Amount</em></strong></td>
                            <td><input type="text" name="vpc_Amount"  value="@if (!empty($total)) {{$total}} @endif "    size="20" maxlength="10" /></td>
                            <td>Số tiền cần thanh toán,Đã được nhân với 100. VD: 100=1VND</td>
                            <td>Amount,Multiplied with 100, Ex: 100=1VND</td>
                        </tr>
                        <tr>
                            <td><strong><em>Receipt ReturnURL</em></strong></td>
                            <td><input type="text" name="vpc_ReturnURL" size="45"
                                       value="{{route('payments.internal')}}"
                                       maxlength="250" /></td>
                            <td>Url nhận kết quả trả về sau khi giao dịch hoàn thành.</td>
                            <td>URL for receiving payment result from gateway</td>
                        </tr>
                        <tr>
                            <td><strong><em>VPC Version</em></strong></td>
                            <td><input type="text" name="vpc_Version" value="2" size="20"
                                       maxlength="8" /></td>
                            <td>Phiên bản modul (cố định)</td>
                            <td>Version (fixed)</td>
                        </tr>
                        <tr>
                            <td><strong><em>Command Type</em></strong></td>
                            <td><input type="text" name="vpc_Command" value="pay" size="20"
                                       maxlength="16" /></td>
                            <td>Loại request (cố định)</td>
                            <td>Command Type(fixed)</td>
                        </tr>
                        <tr>
                            <td><strong><em>Payment Server Display Language Locale</em></strong></td>
                            <td><input type="text" name="vpc_Locale" value="vn" size="20"
                                       maxlength="5" /></td>
                            <td>Ngôn ngữ hiện thị trên cổng (vn/en)</td>
                            <td>Language use on gateway (vn/en)</td>
                        </tr>
                        <tr>
                            <td><strong><em>Currency code</em></strong></td>
                            <td><input type="text" name="vpc_Currency" value="VND" size="20"
                                       maxlength="5" /></td>
                            <td>Loại tiền tệ (VND)</td>
                            <td>Currency (VND)</td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="background-image" summary="Meeting Results">
                        <thead>
                        <tr>
                            <th scope="col" colspan="4">Addition Infomation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="250px"><strong><em>IP address</em></strong></td>
                            <td width="300px"><input type="text" name="vpc_TicketNo" maxlength="15"
                                                     value="<?php
                                                     echo $_SERVER ['REMOTE_ADDR'];
                                                     ?>" /></td>
                            <td width="250px">IP khách hàng</td>
                            <td>IP Client</td>
                        </tr>
                        <tr>
                            <td><strong><em>Shipping Address</em></strong></td>
                            <td><input type="text" name="vpc_SHIP_Street01" value="" size="20"
                                       maxlength="500" /></td>
                            <td>Địa chỉ gửi hàng</td>
                            <td>Shipping Address</td>
                        </tr>
                        <tr>
                            <td><strong><em>Shipping Province</em></strong></td>
                            <td><input type="text" name="vpc_SHIP_Provice" value="Hoan Kiem"
                                       size="20" maxlength="50" /></td>
                            <td>Quận Huyện(địa chỉ gửi hàng)</td>
                            <td>Shipping Province</td>
                        </tr>
                        <tr>
                            <td><strong><em>Shipping City</em></strong></td>
                            <td><input type="text" name="vpc_SHIP_City"
                                       value="Ha Noi" size="20"
                                       maxlength="50" /></td>
                            <td>Tỉnh/thành phố (địa chỉ khách hàng)</td>
                            <td>Shipping City</td>
                        </tr>
                        <tr>
                            <td><strong><em>Shipping Country</em></strong></td>
                            <td><input type="text" name="vpc_SHIP_Country" value="Viet Nam"
                                       size="20" maxlength="50" /></td>
                            <td>Quốc gia(địa chỉ khách hàng)</td>
                            <td>Shipping Country</td>
                        </tr>
                        <tr>
                            <td><strong><em>Customer Phone</em></strong></td>
                            <td><input type="text" name="vpc_Customer_Phone" value="840904280949" size="20"
                                       maxlength="50" /></td>
                            <td>Số điện thoại khách hàng</td>
                            <td>Customer Phone</td>
                        </tr>
                        <tr>
                            <td><strong><em>Customer email</em></strong></td>
                            <td><input type="text" name="vpc_Customer_Email" size="20"
                                       value="support@onepay.vn"
                                       maxlength="50" /></td>
                            <td>Địa chỉ hòm thư của khách hàng</td>
                            <td>Customer email</td>
                        </tr>
                        <tr>
                            <td><strong><em>Customer User Id</em></strong></td>
                            <td><input type="text" name="vpc_Customer_Id" value="thanhvt" size="20"
                                       maxlength="50" /></td>
                            <td>Tên tài khoản khách hàng trên hệ thống</td>
                            <td>Customer User Id</td>
                        </tr>
                        <tr>
                            <td><strong><em>Note</em></strong></td>
                            <td colspan="2">-  Không sử dụng tiếng việt có dấu trong các tham số gửi sang cổng thanh toán<br>-	Không sử dụng số tiền lẻ với cổng thanh toán test(ví dụ 0.2 đồng tức amount = 20)</td>
                            <td colspan="1">-  do not use vietnamese with sign. Convert to vietnamese no sign before send it to gateway<br>-	do not use decimal for amount for testing (100=1VND -> right; 120=1.2VND -> wrong)</td>
                        </tr>
                        </tbody>
                    </table>
                </center>
            </div>
                <!--End: Chọn loại hình thanh toán  -->
                {{-- <button type="submit" id="btn-addUser" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button> --}}
        </form>  <!-- End: Form thêm nhân viên -->
    </div>
    </div>  <!--End: Form thông tin người đặt hàng  -->
    </div> <!--End: Row  Khối thông tin đặt hàng-->

<!-- Thông báo khi nhập bị lỗi Mảng $errors do vatidate gửi ra =================-->
<div class="thongbao">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 offset-4">

                    @if (count($errors) > 0)
                    <div class="mx-auto" style="width:95%;">
                            <div class="alert alert-success text-center">
                                @foreach ($errors->all() as $error)
                                    {{$error}}
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- Thông báo khi lưu database thành công-->
                    @if (Session::has('thongbao'))
                    <div class="mx-auto" style="width:95%;">
                            <div class="alert alert-success text-center">
                                {{session::get('thongbao')}}
                            </div>
                        </div>
                    @endif
                </div>  <!-- End: Thông báo -->
            </div>
        </div>
    </div>
</div> <!--End: Container-->

@endsection

@section('script')

<script>
    $('#beginShowTotalPrice').show();
    $('#endShowTotalPrice').hide();

     $("#thongbao").append('Danh sách hàng bạn đã chọn mua');

    //Begin: top menu dropdown hidden
    $('.catalogies ').hover(function () {
            $('nav.menu').show();
        }, function () {
            $('nav.menu').hide();
        }
    );

    //Begin: Tùy chọn khối hình thức thanh toán
    function showPaymentnote(type){
        $('.product-pay-note').hide();
        $('#product-pay-note-'+type).show(300);
    } //End: Tùy chọn khối hình thức thanh toán


/*==================== Begin: Ajax xóa hàng hóa =========================*/

    function deleteProductAjax(e,$idProductItem){
        $.ajaxSetup({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        }); // fix lỗi 419

        $.ajax({
            type: "POST",
            url: "delete-cart-ajax",
            data: {'idProduct' :  $idProductItem},
            dataType: "json",
            success: function (data) {
                // alert(data.msg);
                $('#showProductBuy-'+$idProductItem).remove();
                location.reload(true);
                //$("#cart").load(" #cart");
            }
        });
    };
/*==================== End: Ajax xóa hàng hóa =========================*/

/* ============ Begin: Thêm bớt 1 loại sản phẩm giỏ hàng ở client =====================*/
function changePriceFlash(e, id){
    $('#beginShowTotalPrice').hide();
    $('#endShowTotalPrice').show();

  //  var oldAmountItem =  $('#oldAmount').data('oldAmount');
    var item  = $(e).val();


    if( item > 0  && item < 21){
        $("#thongbao").empty();
        $("#thongbao").append('Danh sách hàng bạn đã chọn mua');
        var price = $('#viewPrice-'+id).data('price');
        var itemtotal = $('#viewPrice-'+id).data('itemtotal');
        var newprice = price * item;
        $('#viewPrice-'+id).data('itemtotal', newprice);
        $('#viewPrice-'+id+' span').html(Number(newprice).toLocaleString('en'));

        var subtotal = $('#flash-subtotal').data('subtotal');
        var newsubtotle = (subtotal - itemtotal) + newprice;
        $('#flash-subtotal').data('subtotal', newsubtotle);
        $('#flash-subtotal span ').html(Number(newsubtotle).toLocaleString('en'));

        //cập nhật giỏ hàng
        $.ajaxSetup({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        }); // fix lỗi 419

        $.ajax({
            type: "post",
            url: "update-cart-ajax",
            data:   {'idProduct' :  id,
                     'amuontProduct' : item,
                     'totalPrice' : newsubtotle,
                     'amuontItem' : item,
                    //  'buocTang' : buoctang
                    },
            dataType: "json",
            success: function (data) {
                // $('#oldAmount').data('oldAmount', data.msg);
                // $('#oldAmount').html(Number(data.msg).toLocaleString('en'));

            }
        });

    }else{
        $("#thongbao").empty();
        $("#thongbao").append('Bạn vui lòng chọn số lượng trong khoản: 1 - 20');
    }
}
/* ============ End: Thêm bớt 1 loại sản phẩm giỏ hàng ở client  =====================*/

</script>
@endsection

