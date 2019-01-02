@extends('layouts.masterAdmin')

@section('content')

<!-- Begin: page title -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
    <h1 class="h5"> Quản lý đơn hàng</h1>
</div> <!-- End: page title  -->

@if ($methodBill == 'edit')
   <h1 hidden> {{$showData1 = 'block'}} </h1>
@else
    <h1 hidden> {{$showData1 = 'none'}} </h1>
@endif
<!-- ============ Begin: Xem chi tiết đơn hàng ==============-->
<div class="clearfix"></div>
<div class="container" >
    <div class="row" style="display:{{$showData1}};">
        <div class=" col-md-9 col-lg-9 ">
            <div class="card">
                <h5 class="card-header text-center">Sửa thông tin sản phẩm</h5>
                <div class="card-body">
                    <form action="" method="post" role="form" enctype="multipart/form-data">
                            @csrf
                            @if (!empty($dataBillById))


                            <div class="form-row">
                                <div class="form-group col-md-4 col-lg-4">

                                    <label for="">Mã đơn*</label>
                                    <input type="text" class="form-control" name="txt_ProductName" required
                                value="#{{$dataBillById->id}}">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá bán*</label>
                                    @if (!empty($dataBillDetailById))
                                        @foreach ($dataBillDetailById as $itemBillDetail)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBillDetail->id_product == $itemProduct->id)
                                                    <span>+ {{$itemProduct->name}}</span> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá nhập*</label>
                                    <input type="number" class="form-control" name="txt_unitPurchasePrice" required
                                        value="" min="1" max="9000000">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá sale*</label>
                                    <input type="number" class="form-control" name="txt_promotionPrice" required
                                        value="" min="0" max="8000000">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Đơn vị*</label>

                                </div> <!-- End: Form-group  -->
                            </div>  <!-- End: Form-row  -->


                            @endif

                    </form> <!-- End: Form sửa nhân viên -->
                </div> <!-- end: card-body-->
            </div> <!-- end: card-->
        </div> <!-- end: col-->

        <div class="clearfix"></div>
        <div class="col-md-3 col-lg-3 border-left">
            <img class=" mt-4" width="100%" alt="" id="thumbimage" style="display: none" />
            {{-- <img class=" mt-4" width="100%" alt="" id="oldThumbimage" src="{{asset("uploads/products/$dataProductById->images")}}"  /> --}}
        </div>  <!-- End: Hình sản phẩm -->

    </div> <!-- End: From nhập liệu -->
</div> <!-- End: container -->

<!-- ============ Begin: Xem chi tiết đơn hàng ==============-->


<div class="clearfix"></div>
<!-- ============ Begin: Hiển thị đơn hàng ==============-->

@if ($methodBill == 'edit')
   <h1 hidden> {{$showData = 'none'}} </h1>
@else
    <h1 hidden> {{$showData = 'block'}} </h1>
@endif

<div class="row" style="display:{{$showData}};">
    <div class="col-sm-12 col-lg-12 col-xs-12">
        <h5></h5>
        <div class="table-responsive">
            <table id="table-product" class="table table-striped table-bordered w-100" cellspacing="0" cellpadding="4px">
                <thead>
                    <tr >
                        <th class="text-center">Mã</th>
                        <th>Tên sản phẩm</th>
                        <th>SL</th>
                        <th>Đơn giá</th>
                        <th>Tổng</th>
                        <th>Thành tiền</th>
                        <th>Hình</th>
                        <th>Loại</th>
                        <th>Khách hàng</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody >
                    @if (!empty($dataBill))
                        @foreach ($dataBill as $itemBill)
                        <tr id="tb-product" class="w-100">
                            <td class="text-center" style="max-width:30px;">#{{$itemBill->id}}</td>

                            @if (!empty($dataBillDetail))

                                <td class="text-truncate w-20" style="max-width:200px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBill_detail->id_product == $itemProduct->id)
                                                        <span>+ {{$itemProduct->name}}</span> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </td>  <!-- End: Tên SP -->

                                <td class="text-truncate" style="max-width:30px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBill_detail->id_product == $itemProduct->id)
                                                        <span>{{$itemBill_detail->quantity}}</span> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </td> <!-- End: Số luọng -->

                                <td class="text-truncate" style="max-width:100px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBill_detail->id_product == $itemProduct->id)
                                                        <span>{{number_format($itemBill_detail->unit_price )}}</span> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </td>  <!-- End: đơn giá -->

                                <td class="text-truncate" style="max-width:100px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBill_detail->id_product == $itemProduct->id)
                                                        <span>{{number_format($itemBill_detail->unit_price * $itemBill_detail->quantity)}}</span> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </td>  <!-- End: Tổng  -->

                                <td class="text-truncate" style="max-width:100px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            <span>{{number_format($itemBill->money_total)}}</span>
                                            @break
                                        @endif
                                    @endforeach
                                </td>  <!-- End: Thành tiền-->

                                <td class="text-truncate" style="max-width:50px;">
                                    @foreach ($dataBillDetail as $itemBill_detail)
                                        @if ($itemBill_detail->id_bill  == $itemBill->id)
                                            @if (!empty($dataProduct))
                                                @foreach ($dataProduct as $itemProduct)
                                                    @if ($itemBill_detail->id_product == $itemProduct->id)
                                                        <img src="{{asset("uploads/products/$itemProduct->images")}}" width="40px" height="40px"> <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </td>  <!-- End: Hình sp -->

                                <td class="text-truncate" style="max-width:50px;">
                                        @foreach ($dataBillDetail as $itemBill_detail)
                                            @if ($itemBill_detail->id_bill  == $itemBill->id)
                                                <span>{{$itemBill->payment}}</span>
                                                @break
                                            @endif
                                        @endforeach
                                    </td>  <!-- End: Loại thanh toán-->

                                <td class="text-truncate" style="max-width:250px;">
                                    @if (!empty($dataCustomer))
                                        @foreach ($dataCustomer as $itemCustomer)
                                            @if ($itemCustomer->id == $itemBill->id_customer)
                                            <span>{{$itemCustomer->name}}</span> <br>
                                            <span>{{$itemCustomer->phone}}</span> <br>
                                            <span>{{$itemCustomer->address}}</span>
                                            @break
                                            @endif
                                        @endforeach
                                    @endif
                                </td>  <!-- End: tt khách hàng -->
                            @endif

                            <td style="width:30px;">
                                <a href="{{route('deleteBillById',$itemBill->id)}}" class="btn btn-outline-secondary btn-sm"> <i class="far fa-calendar-times"></i> </a>  </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- ============ End: Hiển thị ==============-->

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

@endsection


@section('script')
<script>
    $('#table-product').DataTable();
    //Hiển thị hình sản phẩm xem trước
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#thumbimage").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
                $("#thumbimage").show();
                $("#oldThumbimage").hide();
            }
            else {
                $("#thumbimage").attr('src', input.value);
                $("#thumbimage").show();
            }
        }
</script>
@endsection

