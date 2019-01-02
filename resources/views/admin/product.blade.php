@extends('layouts.masterAdmin')

@section('content')

<!-- Begin: page title -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
    <h1 class="h5"> Quản lý sản phẩm </h1>
</div> <!-- End: page title  -->

@if ($methodProduct == 'add')

<!--  Begin: Khối thêm sản phẩm mới -->
<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addProduct" data-whatever="@mdo">
    <i class="fas fa-user-plus"></i> Thêm sản phẩm mới
</button>

<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Thêm sản phẩm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <!-- End: Thêm sản phẩm mới -->
                <div class="container-fluid" >
                    <div class="row">
                            <div class=" col-md-9 col-lg-9 ">
                                <form action="{{route('addProductPage')}}" method="post" role="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="">Tên sản phẩm*</label>
                                            <input type="text" class="form-control" id="" name="txt_ProductName" required maxlength="100" placeholder="...">
                                        </div>

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="">Danh mục cha*</label>
                                            <select id="btn_productType" name="txt_idType" class="form-control" >
                                                <option value="">Chọn ...</option>
                                                @if (!empty($subCategory))
                                                    @foreach ($subCategory as $val_subCategory)
                                                        <option value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div> <!-- End: Danh mục cha  -->

                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="">Danh mục con*</label>
                                                <select id="childCategory" name="txt_idTypeItem" class="form-control">
                                            </select>
                                        </div>  <!-- End: Danh mục con  -->

                                    </div>  <!-- End: Form-row  -->

                                    <div class="form-row">
                                        <div class="form-group col-md-3 col-lg-3">
                                                <label for="">Giá bán*</label>
                                                <input type="number" class="form-control"name="txt_unitPrice" required min="1" max="9999999">
                                            </div> <!-- End: Giá bán  -->
                                            <div class="form-group col-md-3 col-lg-3">
                                                <label for="">Giá sale*</label>
                                                <input type="number" class="form-control"name="txt_promotionPrice" required min="0" max="9000000">
                                            </div> <!-- End: giá sale  -->
                                            <div class="form-group col-md-3 col-lg-3">
                                                <label for="">Giá nhập*</label>
                                                 <input type="number" class="form-control" name="txt_unitPurchasePrice" required min="1" max="9000000">
                                        </div> <!-- End: Giá nhập  -->

                                        <div class="form-group col-md-3 col-lg-3">
                                            <label for="">Số lượng*</label>
                                            <input type="number" class="form-control" name="txt_qtyProduct" required min="0" max="5000">
                                        </div>
                                    </div> <!-- End: Form-row  -->

                                    <div class="form-row">
                                        <div class="form-group col-md-3 col-lg-3">
                                            <label for="">Đơn vị*</label>
                                            <select id="" name="txt_unit" class="form-control" >
                                                <option value="">Chọn ...</option>
                                                <option value="áo">áo</option>
                                                <option value="quần">quần</option>
                                                <option value="chiếc">chiếc</option>
                                            </select>
                                        </div> <!-- End: Form-group  -->
                                        <div class="form-group col-md-4 col-lg-4" >
                                            <label for="">Hình SP*</label>
                                            <input type="file" class="form-control btn-sm" id="" class="inputfile" onchange="readURL(this);" name="txt_images" required accept="image/gif, image/jpeg, image/png">
                                        </div>
                                        <div class="form-group col-md-4 col-lg-4">
                                            <label for="">Nhân viên đăng</label>
                                            <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                            <input type="text" class="form-control" id="" name="txt_idUser" hidden value="{{ Auth::user()->id}}">
                                        </div>
                                    </div> <!-- End: Form-row  -->

                                    <div class="form-group">
                                        <label for="">Mô tả</label>
                                        <div class="custom-file">
                                            <textarea class="w-100" name="txt_description" id="txt_description" cols="30" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" id="btn-addProduct" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button>
                                </form> <!-- End: Form thêm nhân viên -->
                            </div> <!-- end: Form col-md-9 col-lg-9-->
                            <div class="clearfix"></div>
                            <div class="col-md-3 col-lg-3 border-left">
                                <img class=" mt-4" width="100%" alt="" id="thumbimage" style="display: none" />
                            </div>  <!-- End: From nhập liệu -->
                    </div> <!-- End: row -->
                </div> <!-- End: container-fluid-->
            </div> <!-- End: modal-body -->
        </div> <!--  End: modal-dialog -->
    </div>  <!--  End: modal-content -->
</div>  <!--  End: modal fade-->
<!--  End: Khối colapse: thêm sản phẩm -->

@else
<!-- ======================Begin: Sửa thông tin sản phẩm-===================-->
<div class="clearfix"></div>
<div class="container" >
    <div class="row">
        <div class=" col-md-9 col-lg-9 ">
            <div class="card">
                <h5 class="card-header text-center">Sửa thông tin sản phẩm</h5>
                <div class="card-body">
                    <form action="{{route('editProductById',$dataProductById->id)}}" method="post" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4 col-lg-4">
                                    <label for="">Tên sản phẩm*</label>
                                    <input type="text" class="form-control" name="txt_ProductName" required
                                        value="{{$dataProductById->name}}">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá bán*</label>
                                    <input type="number" class="form-control" name="txt_unitPrice" required
                                        value="{{$dataProductById->unit_price}}" min="1" max="9000000">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá nhập*</label>
                                    <input type="number" class="form-control" name="txt_unitPurchasePrice" required
                                        value="{{$dataProductById->unit_purchase_price}}" min="1" max="9000000">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Giá sale*</label>
                                    <input type="number" class="form-control" name="txt_promotionPrice" required
                                        value="{{$dataProductById->promotion_price}}" min="0" max="8000000">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Đơn vị*</label>
                                    <select id="" name="txt_unit" class="form-control">
                                        <option selected value="{{$dataProductById->unit}}">{{$dataProductById->unit}}</option>
                                        <option value="áo">áo</option>
                                        <option value="quần">quần</option>
                                        <option value="chiếc">chiếc</option>
                                    </select>
                                </div> <!-- End: Form-group  -->
                            </div>  <!-- End: Form-row  -->
                            <div class="form-row">
                                <div class="form-group col-md-3 col-lg-3">
                                    <label for="">Danh mục cha*</label>
                                    <select id="btn_productTypeEdit" name="txt_idType" class="form-control" >
                                        <!-- Hiển thị tên danh mục cha -->
                                        @if (!empty($subCategory))
                                            @foreach ($subCategory as $val_subCategory)
                                                @if ($val_subCategory->id == $dataProductById->id_type_item)
                                                <option selected value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                                @else <option value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Danh mục con*</label>
                                    <select  name="txt_idTypeItem" class="form-control">
                                        <!-- Hiển thị tên danh mục con hiện tại -->
                                        @if (!empty($childCatagory))
                                            @foreach ($childCatagory as $val_childCatagory)
                                                @if ($val_childCatagory->id == $dataProductById->id_type_item)
                                                    <option selected value="{{$val_childCatagory->id}}">{{$val_childCatagory->name}}</option>

                                                @else <option value="{{$val_childCatagory->id}}">{{$val_childCatagory->name}}</option>
                                                @endif
                                            @endforeach


                                        @endif

                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-lg-2" >
                                    <label for="">Hình SP*</label>
                                    <input type="file" class="form-control btn-sm" id="" onchange="readURL(this);" name="txt_images" accept="image/gif, image/jpeg, image/png">
                                </div>
                                <div class="form-group col-md-2 col-lg-2">
                                    <label for="">Số lượng*</label>
                                    <input type="number" class="form-control" id="" name="txt_qtyProduct" required value="{{$dataProductById->qty_product}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Nhân viên đăng</label>
                                    <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                    <input type="text" class="form-control" id="" name="txt_idUser" hidden value="{{ Auth::user()->id}}">
                                </div>
                            </div> <!-- End: Form-row  -->

                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <div class="custom-file">
                                    <textarea class="w-100" name="txt_description" id="txt_description" cols="30" rows="6">{{$dataProductById->description}}</textarea>
                                </div>
                            </div>

                        <button type="submit" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button>

                    </form> <!-- End: Form sửa nhân viên -->
                </div> <!-- end: card-body-->
            </div> <!-- end: card-->
        </div> <!-- end: col-->

        <div class="clearfix"></div>
        <div class="col-md-3 col-lg-3 border-left">
            <img class=" mt-4" width="100%" alt="" id="thumbimage" style="display: none" />
            <img class=" mt-4" width="100%" alt="" id="oldThumbimage" src="{{asset("uploads/products/$dataProductById->images")}}"  />
        </div>  <!-- End: Hình sản phẩm -->

    </div> <!-- End: From nhập liệu -->
</div> <!-- End: container -->
@endif
<!-- ======================End: Edit sản phẩm -===================-->

<hr>
<div class="clearfix"></div>
<!-- ======================= Begin: Hiển thị sản phẩm =================-->

@if ($methodProduct == 'edit')
   <h1 hidden> {{$showData = 'none'}} </h1>
@else
    <h1 hidden> {{$showData = 'block'}} </h1>
@endif

<div class="row" style="display:{{$showData}};">
    <div class="col-sm-12 col-lg-12 col-xs-12">
        <h5>Danh sách sản phẩm</h5>
        <div class="table-responsive">
            <table id="table-product" class="table table-striped table-bordered w-100" cellspacing="0" cellpadding="4px">
                <thead>
                    <tr >
                        <th class="text-center">#</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá bán</th>
                        <th>Giá nhập</th>
                        <th>Giá sale</th>
                        <th>ĐV</th>
                        <th class="text-center">SL</th>
                        <th>D/M Cha</th>

                        <th>D/M C1</th>
                        <th>Hình ảnh</th>
                        {{-- <th>Nhân viên</th> --}}
                        <th>Chức năng</th>

                    </tr>
                </thead>
                <tbody >
                        <h1 style="display:none;">{{$stt=1}}</h1>
                    @if (!empty($dataAllProduct))

                        @foreach ($dataAllProduct as $itemProduct)
                        <tr id="tb-product" class="w-100">
                            <td class="text-center">{{$stt++}}</td>
                            <td class="text-truncate" style="max-width:200px;"> {{$itemProduct->name}}</td>
                            <td class="text-truncate"style="max-width:100px;">{{number_format($itemProduct->unit_price)}}</td>
                            <td class="text-truncate"style="max-width:100px;">{{number_format($itemProduct->unit_purchase_price)}}</td>
                            <td class="text-truncate"style="max-width:100px;" >{{number_format($itemProduct->promotion_price)}}</td>
                            <td class="text-truncate"style="max-width:10px;">{{$itemProduct->unit}}</td>
                            <td class="text-truncate"style="width:10px;"> {{$itemProduct->qty_product}}</td>
                            <!-- Hiển thị tên danh mục cha -->
                            <td class="text-truncate"style="max-width:150px;">
                                @if (!empty($childCatagory) && !empty($subCatagory))
                                    @foreach ($childCatagory as $val_childCatagory)
                                        @if ($val_childCatagory->id == $itemProduct->id_type_item)

                                            @foreach ($subCatagory as $val_subCatagory)
                                                @if ($val_subCatagory->id == $val_childCatagory->id_type)
                                                    {{$val_subCatagory->name}}
                                                    @break
                                                @endif
                                            @endforeach

                                        @endif
                                    @endforeach
                                @endif

                            </td>
                            <!-- Hiển thị tên danh mục con -->
                            <td class="text-truncate"style="max-width:100px;">
                                @if (!empty($childCatagory))
                                    @foreach ($childCatagory as $val_childCatagory)
                                        @if ($val_childCatagory->id == $itemProduct->id_type_item)
                                            {{$val_childCatagory->name}}
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td class="text-truncate"style="max-width:60px; min-width:10px;"><img width="60px" height="40px" src="{{asset("uploads/products/$itemProduct->images")}}" alt=""> </td>
                            {{-- <td class="text-truncate text-center"style="max-width:10px; min-width:10px;">{{$itemProduct->id_user}}</td> --}}


                            {{-- onclick="delEditRow()" data-idUser="{{$itemProduct->id}}" --}}
                            <td style="min-width:70px;">
                                <a  href="{{route('getProductById',$itemProduct->id)}}"  class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i> </a>
                                <a href="{{route('deleteProductById',$itemProduct->id)}}" class="btn btn-outline-secondary btn-sm"> <i class="far fa-calendar-times"></i> </a>  </a>
                            </td>

                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ======================= End: Hiển thị sản phẩm =================-->

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

    ClassicEditor
        .create( document.querySelector( '#txt_description' ), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        }).catch( error => {console.error( error ); });

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

    //ajax chọn danh mục con
    $('#btn_productType').change(function (e) {
        e.preventDefault();
        $.ajaxSetup({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        }); // fix lỗi 419

        var id_productTpye = $(this).val();
        // alert(id_productTpye);
        $.ajax({
            type: "post",
            url: "quan-ly-san-pham/danh-muc-con",
             data: {'idCatagory' :  id_productTpye},
            dataType: "html",
            success: function (data) {
                console.log(data);
                $('#childCategory option').remove();
                $('#childCategory').append(data);
            }
        });

    });

</script>
@endsection
