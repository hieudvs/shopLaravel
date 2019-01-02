

<div id="new-product">
    <div class="container">
        <div class="product-header mt-3">
            <img src="source/images/logotitle.png" alt="">
            <span>Sản phẩm mới</span>
        </div>
        <div class="row">
            <div class="product-list mt-3">
                @if (!empty($dataAllProduct))
                    @foreach ($dataAllProduct as $itemProduct)
                    <div class="product-item col-sm-3 col-xs-6 " id="productItem-{{$itemProduct->id}}">
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
                                        {{-- <a id="btn-buy" class="btn btn-default btn-xs" href="{{route('addToCart', $itemProduct->id)}}">
                                            Chọn Mua
                                        </a> --}}
                                        <a onclick="addToCart(this,{{$itemProduct->id}})" class="btn btn-default btn-xs">
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
            <div  id="allProductPaginate" style="margin:auto;">@if(!empty($dataAllProduct)){{ $dataAllProduct->links() }}@endif</div> <!-- End: Phan trang -->
        </div> <!-- End: row -->
    </div> <!-- End: container-->
</div> <!-- End: new-produc -->




