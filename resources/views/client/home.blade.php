@extends('layouts.masterClient')

@section('content')

    @include('client.slide')
    </div>  <!-- End: header -->

    <!-- Begin: content pages -->
<div id="contentPage" class="clearfix">

    <!-- Begin: gioi thieu -->
    <div id="show" class="pt-3 pb-3 d-none d-sm-block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12 " style="box-shadow: 0px 0px 10px #aaa; padding:0px;">
                    <img src="{{asset("source/images/admin/AO0VBDJ9_2.jpg")}}" class="img-thumbnail" alt="Cinque Terre" width="376" height="220">
                </div>
                <div class="col-lg-4 col-xs-12" style="box-shadow: 0px 0px 10px #aaa; padding:0px;">
                    <img src="{{asset("source/images/admin/AO0VBIO8_1.jpg")}}" class="img-thumbnail" alt="Cinque Terre" width="376" height="220">
                </div>
                <div class="col-lg-4 col-xs-12" style="box-shadow: 0px 0px 10px #aaa; padding:0px;">
                    <img src="{{asset("source/images/admin/AO0VBLJR_3.jpg")}}" class="img-thumbnail" alt="Cinque Terre" width="376" height="220">
                </div>
            </div>
        </div>
    </div>

    <!-- End: gioi thieu -->

    <div id="product" class="clearfix">

        @include('client.products.allProduct')
        @include('client.products.saleProduct')
        @include('client.cart')

    </div> <!-- End: product -->


    </div> <!-- End: content pages -->

@endsection



@section('script')

<script>

/*==================== Begin: PAGINATION =========================*/
$('#allProductPaginate').click(function (e) {
    e.preventDefault();

	$(document).on('click','#allProductPaginate .pagination a', function(e){
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
		 getAllProducts(page);
		  //location.hash = page;
    });

	function getAllProducts(page){
		$.ajax({
			url: 'getAllProductPag?page='+page
		}).done(function(data){
            console.log('getAllProducts');
              $("#new-product").html(data);
             location.hash = page;
		});
	}

}); //End: All product page

$('#saleProductPaginate').click(function (e) {
    e.preventDefault();

	$(document).on('click','#saleProductPaginate .pagination a', function(e){
		e.preventDefault();
		var page = $(this).attr('href').split('page=')[1];
        getSaleProducts(page);
		//location.hash = page;
    });

	function getSaleProducts(page){
		$.ajax({
			url: 'getsaleProductPag?page='+page
		}).done(function(data){
            console.log('getSaleProducts');
            $("#sale-product").html(data);
            location.hash = page;
		});
	}

}); // End: Sale product page
/*==================== End: PAGINATION =========================*/

/*==================== Begin: Ajax add to cart =========================*/

    function addToCart(e,$idProductItem){
        $.ajaxSetup({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        }); // fix lỗi 419

        $.ajax({
            type: "POST",
            url: "gio-hang-ajax",
            data: {'idProduct' :  $idProductItem},
            dataType: "json",
            success: function (data) {
            // alert(data.msg);
            //location.reload(true);
            //$("#cart").load(location.href+ " #cart>*","");
            //location.reload(true);
            $("#cart").load(" #cart");
            }
        });
    };

/*==================== End: Ajax add to cart =========================*/




</script>



@endsection
