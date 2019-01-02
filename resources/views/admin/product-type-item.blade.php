@extends('layouts.masterAdmin')

@section('content')

<!-- Begin: page title -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
    <h1 class="h5"> Quản lý Danh mục sản phẩm - cấp 1</h1>
</div> <!-- End: page title  -->

@if ($methodProduct == 'add')

<!-- ======================Begin: Thêm loại sản chẩm: danh mục cha-===================-->
<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addProduct" data-whatever="@mdo">
    <i class="fas fa-user-plus"></i> Thêm Danh mục cấp 1
</button>

<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Thêm Danh mục cấp 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <!-- End: Thêm sản phẩm mới -->
                <div class="container-fluid" >
                    <div class="row">
                        <div class=" col-md-9 col-lg-9 ">
                            <form action="{{route('addProductTypeItemPage')}}" method="post" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4 col-lg-4">
                                        <label for="">Tên danh mục cấp 1*</label>
                                        <input type="text" class="form-control" id="" name="txt_name" required placeholder="...">
                                    </div>
                                    <div class="form-group col-md-4 col-lg-4">
                                        <label for="">Danh mục cha*</label>
                                        <select id="btn_productType" name="txt_id_type" class="form-control" >
                                            <option value="">Chọn ...</option>
                                            @if (!empty($subCategory))
                                                @foreach ($subCategory as $val_subCategory)
                                                    <option value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div> <!-- End: Danh mục cha  -->
                                    <div class="form-group col-md-4 col-lg-4" >
                                        <label for="">Hình đại diện*</label>
                                        <input type="file" class="form-control btn-sm" name="txt_images" class="inputfile" onchange="readURL(this);" required accept="image/gif, image/jpeg, image/png">
                                    </div>
                                    <div hidden class="form-group col-md-3 col-lg-3">
                                        <label>Nhân viên đăng</label>
                                        <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                        <input type="text" class="form-control" id="" name="txt_idUser" hidden value="{{ Auth::user()->id}}">
                                    </div> <!-- End: Form-row  -->
                                </div>  <!-- End: Form-row  -->
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

<!-- ======================End: Thêm loại sản chẩm: danh mục cha-===================-->
@else

<!-- ======================Begin: Sửa loại sản chẩm: danh mục cha-===================-->
<div class="clearfix"></div>
<div class="container" >
    <div class="row">
        <div class=" col-md-9 col-lg-9 ">
            <div class="card">
                <h5 class="card-header text-center">Sửa thông tin danh mục con cấp 1</h5>
                <div class="card-body">
                    {{-- <form action="{{route('editProductTypeById',$productTypeById->id)}}" method="post" role="form" enctype="multipart/form-data"> --}}
                        <form action="" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4 col-lg-4">
                                <label for="">Tên danh mục cấp 1*</label>
                                <input type="text" class="form-control" name="txt_name" value="{{$productTypeItemById->name}}" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                                <label for="">Danh mục cha*</label>
                                <select id="btn_productType" name="txt_id_type" class="form-control" required>

                                    @if (!empty($subCategory))
                                        @foreach ($subCategory as $val_subCategory)
                                            @if ($val_subCategory->id == $productTypeItemById->id_type)
                                                <option selected value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                            @else  <option value="{{$val_subCategory->id}}">{{$val_subCategory->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div> <!-- End: Danh mục cha  -->
                            <div class="form-group col-md-4 col-lg-4" >
                                <label for="">Hình đại diện*</label>
                                <input type="file" class="form-control btn-sm" name="txt_images" class="inputfile" onchange="readURL(this);" accept="image/gif, image/jpeg, image/png">
                            </div>
                            <div hidden class="form-group col-md-3 col-lg-3">
                                <label>Nhân viên đăng</label>
                                <input type="text" class="form-control" readonly value="{{ Auth::user()->name}}">
                                <input type="text" class="form-control" id="" name="txt_idUser" hidden value="{{ Auth::user()->id}}">
                            </div> <!-- End: Form-row  -->
                        </div>  <!-- End: Form-row  -->
                        <div class="form-group">
                            <label for="">Mô tả</label>
                            <div class="custom-file">
                                <textarea class="w-100" name="txt_description" id="txt_description" cols="30" rows="6">
                                    {{$productTypeItemById->description}}
                                </textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button>

                    </form> <!-- End: Form sửa  -->
                </div> <!-- end: card-body-->
            </div> <!-- end: card-->
        </div> <!-- end: col-->

        <div class="clearfix"></div>
        <div class="col-md-3 col-lg-3 border-left">
            <img class=" mt-4" width="100%" alt="" id="thumbimage" style="display: none" />
            <img class=" mt-4" width="100%" alt="" id="oldThumbimage" src="{{asset("uploads/admin/$productTypeItemById->images")}}"  />
        </div>  <!-- End: Hình sản phẩm -->

    </div> <!-- End: From nhập liệu -->
</div> <!-- End: container -->


<!-- ======================End: Sửa chi tiết loại sản chẩm: danh mục cha -===================-->
@endif
<hr>
<div class="clearfix"></div>
<!-- ============ Begin: Hiển thị chi tiết loại sản chẩm: danh mục cha ==============-->

@if ($methodProduct == 'edit')
   <h1 hidden> {{$showData = 'none'}} </h1>
@else
    <h1 hidden> {{$showData = 'block'}} </h1>
@endif

<div class="row" style="display:{{$showData}};">
    <div class="col-sm-12 col-lg-12 col-xs-12">
        <h5>Danh sách sản phẩm cấp 1</h5>
        <div class="table-responsive">
            <table id="table-product" class="table table-striped table-bordered" >
                <thead>
                    <tr >
                        <th class="text-center">STT</th>
                        <th>Tên danh mục cấp 1</th>
                        <th>Danh mục cha</th>
                        <th>Mô tả</th>
                        <th>Hình đại diện</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    @if (!empty($dataProductTypeItem))
                        <h1 style="display:none;">{{$stt=1}}</h1>
                        @foreach ($dataProductTypeItem as $productTypeItem)
                        <tr id="tb-product" >
                            <td class="text-center" style="width:40px;">{{$stt++}}</td>
                            <td class="text-truncate" style="max-width:200px;"> {{$productTypeItem->name}}</td>
                            <!-- Hiển thị tên danh mục cha -->
                            <td class="text-truncate" style="max-width:200px;">
                                @if (!empty($subCategory))
                                    @foreach ($subCategory as $val_subCategory)
                                        @if ($val_subCategory->id == $productTypeItem->id_type)
                                            <span>{{$val_subCategory->name}}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td class="text-truncate"style="max-width:15px;">{!! $productTypeItem->description !!}</td>
                            <td class="text-truncate "style="max-width:100px; min-width:10px;"><img width="60px" height="60px" src="{{asset("uploads/admin/$productTypeItem->images")}}" alt=""></td>

                            <td style="width:70px;">
                                <a  href="{{route('getProductTypeItemById',$productTypeItem->id)}}"  class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i> </a>
                                <a href="{{route('deleteProductTypeItemById',$productTypeItem->id)}}" class="btn btn-outline-secondary btn-sm"> <i class="far fa-calendar-times"></i> </a>  </a>
                            </td>

                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End: Hiển thị chi tiết loại sản chẩm: danh mục cha-->

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

</script>
@endsection

