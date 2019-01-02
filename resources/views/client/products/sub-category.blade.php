@extends('layouts.masterClient')

@section('style')
    <style> nav.menu{display:none;} </style>
@endsection

@section('content')

<!-- Begin: page title -->
<div class="container d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2 mt-2">
<h1 class="h8 text-uppercase font-weight-bold text-primary"> {{$subCategoryById->name}}</h1>
</div> <!-- End: page title  -->

    <div id="search-product">
        <div class="container bg-white rounded" style="min-height:500px;">
            <div class="row">
                <div class="product-list mt-3">
                    @if(!empty($subCategoryById))
                    <div class="beta-products-details ml-3">
                        <p class="pull-left"> Có {{count($subCategoryById->product)}} Sản phẩm</p>
                            <div class="clearfix"></div>
                        </div>

                    @foreach ($subCategoryById->product as $itemProduct)
                    <div class="product-item col-sm-3 col-xs-6 ">
                        <div class="col-product-item">
                            <a href="{{route('detailProductPage',$itemProduct->id)}}" title="{{$itemProduct->name}}">
                                <div class="product-image">
                                    <img class="img-product" src="{{asset("uploads/products/$itemProduct->images")}}" alt="" >
                                </div>
                                <div class="product-info">
                                    <div class="product-info-name">
                                        <h5> {{$itemProduct->name}}</h5>
                                    </div>
                                    <div class="product-price text-center">
                                        @if ($itemProduct->promotion_price == 0)
                                            <h5 class="price-original">
                                                <span> {{ number_format($itemProduct->unit_price)}}</span>
                                                <sup>đ</sup>
                                            </h5>
                                        @else
                                            <h5 class="price-sale">
                                                <span> {{ number_format($itemProduct->promotion_price)}}</span>
                                                <sup>đ</sup>
                                            </h5>
                                            <h5 class="price-original-sale">
                                                <span> {{ number_format($itemProduct->unit_price)}}</span>
                                                <sup>đ</sup>
                                            </h5>
                                        @endif
                                    </div>

                                    <div class="bt-add-to-cart ">
                                        <a class="btn btn-default btn-xs" href="{{route('addToCart', $itemProduct->id)}}">
                                            Chọn Mua
                                        </a>
                                    </div>

                                </div>
                                @if ($itemProduct->promotion_price != 0)
                                    <div class="sale-label">
                                        <span>{{(int)(100-(($itemProduct->promotion_price * 100 )/$itemProduct->unit_price))}}%</span>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div> <!-- End: product-item -->
                    @endforeach

                    @endif
                </div> <!-- End: product-list -->
                {{-- <div  id="allProductPaginate">@if(!empty($productWithType)) {{ $productWithType->links() }} @endif</div> <!-- End: Phan trang --> --}}
            </div> <!-- End: row -->
        </div> <!-- End: new-produc -->

    </div> <!-- End: container-->
</div> <!-- End: product -->

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
