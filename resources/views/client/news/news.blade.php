@extends('layouts.masterClient')

@section('style')
    <style> nav.menu{display:none;} </style>
@endsection

@section('content')
 <!-- Begin: page title -->
<div class="container d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2 mt-2">
    <h1 class="h7 text-uppercase font-weight-bold text-primary"> Tin tức </h1>
</div> <!-- End: page title  -->

  <!--begin page content trang tin tức -->
  <div id="news">
    <div class="container bg-white pt-4" style="min-height:600px;">
      <div class="row">

        <!--begin danh muc tin tuc cot ben trai -->
         <div class="col-md-8">
             @if (!empty($newsData))


            @foreach ($newsData as $newsItem)
                <div class="card-group col-sm-6 mb-2" style="float:left;">
                    <div class="card" >
                        <img class="card-img-top" src="{{asset("uploads/news/$newsItem->images ")}}" width="auto" height="350px">
                        <div class="card-body">
                            <a href="{{route("detailNewsPage",$newsItem->id)}}">
                                <h5 class="card-title font-weight-bold">{{$newsItem->title}}</h5>
                            </a>
                            <small class="text-muted">{{$newsItem->created_at}}</small>
                            <p class="card-text">{{$newsItem->description}}</p>
                            <a href="{{route("detailNewsPage",$newsItem->id)}}" class="card-link">Xem tiếp</a>
                        </div>
                    </div>
                </div>
            @endforeach

            @endif
        </div>  <!--end danh muc tin tuc cot ben trai -->

          <!--begin tin nổi bật cột bên phải -->
         <div class="col-md-4">
           <br/>
           <br/>
          <h5>CHƯƠNG TRÌNH KHUYẾN MÃI</h5>
          <div class="clearfix list-group-item list-group-item-action">
              <img src="{{asset("source/images/admin/AO0VBDJ9_2.jpg")}}" alt="..." class="mx-auto d-block" width="100%" height="">
              {{-- <a href="newskhuyenmai.html"><p>Khuyến mãi hot tháng 11/2018...</p></a>
              <small class="text-muted">Vừa mới đăng</small> --}}
          </div>
          <hr/>
          <h6>CÓ THỂ BẠN QUAN TÂM</h6>
          <div class="list-group">
            <div class="clearfix list-group-item list-group-item-action">
              <img src="{{asset("source/images/admin/AO0VBDJ9_2.jpg")}}" class="float-left mr-2" width="80px" height="80px">
              <a href="#"><p>Phong cách thời trang nam tính của siêu sao Tom Cruise...</p></a>
              <small class="text-muted">20:50 16/11/2018</small>
            </div>
            <div class="clearfix list-group-item list-group-item-action">
                    <img src="{{asset("source/images/admin/AO0VBDJ9_2.jpg")}}" class="float-left mr-2" width="80px" height="80px">
                <a href="#"><p>Những xu hướng lên ngôi tại tuần lễ thời trang nam giới xuân hè 2019...</p></a>
                <small class="text-muted">00:10 15/11/2018</small>
            </div>
            {{-- <hr/>
            <h6>ĐƯỢC XEM NHIỀU NHẤT</h6>
            <div class="list-group">
                <div class="clearfix list-group-item list-group-item-action">
                  <img src="images/news/right/news10.jpg" alt="..." class="float-left mr-2" width="60px" height="80px">
                  <a href="news10.html"><p>Nam giới Trung Quốc trang điểm mỗi ngày: Xã hội thời nay đòi hỏi thế...</p></a>
                  <small class="text-muted">14:10 15/11/2018</small>
                </div>
                <div class="clearfix list-group-item list-group-item-action">
                    <img src="images/news/right/news11.jpg" alt="..." class="float-left mr-2" width="60px" height="80px">
                    <a href="news11.html"><p>Trương Thanh Long khoe body khỏe khoắn và nam tính với thời trang Owen...</p></a>
                    <small class="text-muted">21:10 15/11/2018</small>
                </div>
            </div> --}}
         </div>
         <!--end tin nổi bật cột bên phải -->
      </div>
    </div>
  </div>
  <!--end page content trang tin tức -->


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

</script>
@endsection
