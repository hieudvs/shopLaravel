<div id="header-bottom" class="clearfix">
    <!-- Begin: main slide -->
    <div class=" main-slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 d-none d-sm-block"></div>
                <div class="col-sm-10 col-xs-12  slide-mobile" >

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="margin-left:15px;">
                        <ol class="carousel-indicators">
                            @foreach( $dataSlide as $slide )
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                            @endforeach

                        </ol>
                        <div class="carousel-inner" role="listbox">
                                @foreach( $dataSlide as $slide )
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{asset("uploads/slide/$slide->images")}}" alt="">
                                       {{-- <div class="carousel-caption d-none d-md-block">
                                          <p>{{ $photo->slogan }}</p>
                                       </div> --}}
                                </div>
                             @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- End: main slide -->
</div>
