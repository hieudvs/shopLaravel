@extends('layouts.masterAdmin')

@section('content')

<!-- Begin: page title -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
    <h1 class="h5"> Quản lý nhân viên </h1>
</div> <!-- End: page title  -->


<!--====================== Begin: add user Form -=======================-->
@if ($methodUser == 'add')

<!--  Begin: Khối modal: thêm nhân viên -->
<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addUer" data-whatever="@mdo">
    <i class="fas fa-user-plus"></i> Thêm nhân viên mới
</button>

<div class="modal fade" id="addUer" tabindex="-1" role="dialog" aria-labelledby="addUer" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Thêm nhân viên mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Begin: add Form -->
                <div class="container-fluid addColapse" >
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('registerUserPage')}}" method="post" role="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Họ tên*</label>
                                            <input type="text" class="form-control" id="" name="txt_name" required placeholder="Nhập Họ tên">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Email*</label>
                                            <input type="email" class="form-control" id="" name="txt_email" required placeholder="Nhập Email">
                                        </div>
                                    </div>  <!-- End: Form-row  -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Số điện thoại*</label>
                                            <input type="text" class="form-control" id="" name="txt_phone" required placeholder="Nhập số điện thoại">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Mật khẩu*</label>
                                            <input type="password" class="form-control" id="" name="txt_password" required placeholder="Nhập mật khẩu" min="6" max="20">
                                        </div>
                                    </div> <!-- End: Form-row  -->
                                    <div class="form-group">
                                        <label for="">Địa chỉ*</label>
                                        <input type="text" class="form-control" id="" name="txt_address" required placeholder="Nhập địa chỉ">
                                    </div> <!-- End: Form-group  -->
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="">Chức vụ</label>
                                            <select id="" name="txt_position" class="form-control">
                                                <option value="">Chọn ...</option>
                                                <option value="Giám đốc">Giám đốc</option>
                                                <option value="Phó giám đốc">Phó giám đốc</option>
                                                <option value="Trưởng phòng">Trưởng phòng</option>
                                                <option value="Trưởng nhóm">Trưởng nhóm</option>
                                                <option value="Nhân viên">Nhân viên</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="">Phòng ban</label>
                                            <select id="" name="txt_department" class="form-control">
                                                <option value="">Chọn ...</option>
                                                <option value="Giám đốc">Giám đốc</option>
                                                <option value="Kinh doanh">Kinh doanh</option>
                                                <option value="Kho hàng">Kho hàng</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="">Level*</label>
                                            <input type="number" class="form-control" id="" name="txt_level" required>
                                        </div>
                                    </div> <!-- End: Form-row  -->
                                    <button type="submit" id="btn-addUser" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button>
                                </form> <!-- End: Form thêm nhân viên -->

                            </div> <!-- end: card-body-->
                        </div> <!-- end: card-->
                    </div> <!-- End: From nhập liệu -->
                </div> <!-- End: modal-body -->
            </div> <!--  End: modal-dialog -->
        </div> <!--  End: modal-dialog -->
    </div>  <!--  End: modal-content -->
</div>  <!--  End: modal fade-->


@else
<!-- ======================Begin: Edit user Form -===================-->
<div class="clearfix"></div>
<div class="container" >
    <div class="row">
        <div class=" offset-3 col-sm-6 ">
            <div class="card">
                <h5 class="card-header text-center">Sửa nhân viên</h5>
                <div class="card-body">
                    <form action="{{route('editUserById',$dataUserById->id)}}" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Họ tên*</label>
                                <input type="text" class="form-control" id="" name="txt_name" value="{{ $dataUserById->name}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Email*</label>
                                <input type="email" class="form-control" id="" name="txt_email" required value="{{ $dataUserById->email}}">
                            </div>
                        </div>  <!-- End: Form-row  -->

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Số điện thoại*</label>
                                <input type="text" class="form-control" id="" name="txt_phone" required value="{{ $dataUserById->phone}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Mật khẩu*</label>
                                <input type="password" class="form-control" id="" name="txt_password" required value="{{ $dataUserById->password}}">
                            </div>
                        </div> <!-- End: Form-row  -->

                        <div class="form-group">
                            <label for="">Địa chỉ*</label>
                            <input type="text" class="form-control" id="" name="txt_address" required value="{{ $dataUserById->address}}">
                        </div> <!-- End: Form-group  -->

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Chức vụ</label>
                                <input type="text" class="form-control" id="" name="txt_position" value="{{ $dataUserById->position}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Phòng ban</label>
                                <select id="" name="txt_department" class="form-control">
                                    <option selected>{{ $dataUserById->id_department}}</option>
                                    <option value="Giám đốc">Giám đốc</option>
                                    <option value="Kinh doanh">Kinh doanh</option>
                                    <option value="Kho hàng">Kho hàng</option>
                                </select>
                            </div>

                            @if ($dataUserById->level == '1')
                                <h1 hidden> {{$showEditLevelBoss = 'readonly'}} </h1>
                             @else
                                <h1 hidden> {{$showEditLevelBoss = ''}} </h1>
                            @endif

                            <div class="form-group col-md-2">
                                <label for="">Level*</label>
                            <input type="number" {{$showEditLevelBoss}} class="form-control" id="" name="txt_level"  value="{{ $dataUserById->level}}">
                            </div>
                        </div> <!-- End: Form-row  -->

                        <button type="submit" class="btn btn-outline-secondary btn-block text-uppercase">Xác nhận</button>

                    </form> <!-- End: Form sửa nhân viên -->
                </div> <!-- end: card-body-->
            </div> <!-- end: card-->
        </div> <!-- end: col-->
    </div> <!-- End: From nhập liệu -->
</div> <!-- End: container -->
@endif
<!-- ======================End: Edit User Form -===================-->


<hr>
<div class="clearfix"></div>
<!-- ======================= Begin: Show User =================-->
@if ($methodUser == 'edit')
   <h1 hidden> {{$showData = 'none'}} </h1>
@else
    <h1 hidden> {{$showData = 'block'}} </h1>
@endif

<div class="row" style="display:{{$showData}};">
    <div class="col-sm-12 col-lg-12">
        <h5>Danh sách nhân viên</h5>
        <div class="table-responsive">
            <table id="tableView" class="table table-striped table-bordered" style="width:100%">
            {{-- <table class="table table-striped table-sm table-hover table-responsive"> --}}
            <thead>
                <tr >
                    <th class="text-center">STT</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số ĐT</th>
                    <th>Địa chỉ</th>
                    <th>Chức vụ</th>
                    <th>Phòng ban</th>
                    {{-- <th>Mật khẩu</th> --}}
                    <th class="text-center">Level</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody >
                @if (!empty($dataAllUser))
                    <h1 style="display:none;">{{$stt=1}}</h1>
                    @foreach ($dataAllUser as $itemUser)
                    <tr >
                        <td class="text-center">{{$stt++}}</td>
                        <td class="text-truncate" style="max-width:200px;"> {{$itemUser->name}}</td>
                        <td class="text-truncate"style="max-width:200px;">{{$itemUser->email}}</td>
                        <td class="text-truncate"style="max-width:200px;">{{$itemUser->phone}}</td>
                        <td class="text-truncate"style="max-width:230px;" >{{$itemUser->address}}</td>
                        <td class="text-truncate"style="max-width:200px;">{{$itemUser->position}}</td>
                        <td class="text-truncate"style="max-width:200px;">{{$itemUser->id_department}}</td>
                        {{-- <td class="text-truncate"style="max-width:100px; min-width:10px;"> xxxxxx</td> --}}
                        <td class="text-truncate text-center"style="max-width:10px; min-width:10px;">{{$itemUser->level}}</td>

                        @if ($itemUser->level == '1')
                            <h1 hidden> {{$showDelete = 'none'}} </h1>
                        @else
                                <h1 hidden> {{$showDelete = 'initial'}} </h1>
                        @endif

                        <td style="max-width:100px; min-width:70px;">
                            <a href="{{route('getUserById',$itemUser->id)}}" style="display:{{$showDelete}}" class="btn btn-outline-secondary btn-sm">  <i class="fas fa-pencil-alt"></i> </a>
                            <a href="{{route('deleteUserById',$itemUser->id)}}" style="display:{{$showDelete}}" class="btn btn-outline-secondary btn-sm">   <i class="far fa-calendar-times"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End: show User-->

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

    $(document).ready(function() {
        $('#tableView').DataTable();
    } );

</script>
@endsection
