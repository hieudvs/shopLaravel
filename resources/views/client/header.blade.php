    <!-- Begin: header -->
    <div id="header">
        <!-- Begin: header-top -->
        <div id="header-top" class="clearfix">
            <div class="container">
              <div class="row">
                <!-- Begin:top-menu -->
                <div id="menuTop" class="col-md-2 col-lg-2 col-xs-6 ">
                    <div class="catalogies ">
                        <a href="" class="pull-menu-top" id="pull-menu-top"> <i class="fas fa-bars" ></i> </a>
                        <span> Danh mục sản phẩm <i class="fa fa-caret-down"></i> </span>
                        <nav class="menu ">
                            <ul class="sub-nav-item">
                                @if (!empty($subCategory))
                                @foreach ($subCategory as $val_subCategory)

                                <li class="nav-item">
                                    <a href="{{route('subProductTypePage',$val_subCategory->id)}}">
                                        <h3> <img src=" {{asset("uploads/admin/$val_subCategory->images")}}"  alt=""> {{$val_subCategory->name}}</h3>
                                    </a>
                                    <ul class="submenu">
                                        <div class="container">
                                            <div class="row">
                                                @if (!empty($itemCategory))

                                                @foreach ($itemCategory as $value)
                                                    @if ($value->id_type == $val_subCategory->id)
                                                    <!-- Begin: submenu-item 1-->
                                                    <li class="col-lg-3 col md-4 col-xs-6">
                                                        <a href="{{route('childProductTypePage',$value->id)}}">
                                                            <div class="img-submenu">
                                                                <img src="{{asset("uploads/admin/$value->images")}}">

                                                            </div>
                                                        </a>
                                                        <h4>{{$value->name}}</h4>
                                                    </li>  <!-- end: submenu-item -->
                                                    @endif
                                                @endforeach
                                                @endif


                                            </div> <!-- End: row -->
                                        </div>  <!-- End: container -->
                                    </ul>  <!-- End: submenu-->
                                </li>  <!-- End: nav-item 1 -->

                                @endforeach
                                @endif


                            </ul>  <!-- End: sub-nav-item -->
                        </nav> <!-- End: #itop-menu -->
                    </div>   <!-- End: categories -->
                </div>
                <!-- End:top-menu -->

                <!-- Begin:logo -->
                <div id="logoTop" class="col-md-2 col-sm-3">
                    <a href="{{route('homePageClient')}}">
                    <img class="logo-top" src="{{asset('source/images/logoOwen.png')}}" alt="">
                    </a>
                </div>
                <!-- End:logo -->

                <!-- Begin:searchForm -->
                <div id="searchTop" class="col-md-3 col-xs-6">
                    <form role="search" action="{{route('searchProductPage')}}" method="get" class="search-top">
                        <input class="form-control mr-sm-2 search-text" type="text" name="key" id="" placeholder="Bạn tìm gì? ">
                        <button class="btn-search" type="submit"> <i class="fa fa-search"></i> </button>
                    </form>
                </div> <!-- End:searchForm -->

                <!-- Begin: news + hotline-->
                <div class="col-md-5  text-right header-support" >
                    <a href="{{route('newsPage')}}"> <button class="btn btn-light btn-xs">Tin tức</button> </a>
                    <span class="hotline-top"> Tổng đài: <b> <a href="tel:19000000"> 1900.000</a></b> (8:00 - 18:00) </span>
                </div>
                <!-- End: news + hotline -->

              </div>
            </div>
        </div> <!-- End: header-top -->

        <div id="header-middle"></div>
