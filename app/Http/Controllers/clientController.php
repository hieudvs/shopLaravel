<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Hash;  // thư viện bảo mật
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Validator;
use App\User;
use App\product;
use App\product_type;
use App\product_type_item;
use App\Cart;
use Illuminate\Support\MessageBag;
use App\customer;
use App\bill;
use App\bill_detail;
use App\slide;
use App\news;


class clientController extends Controller
{
    //Begin: Trang Chủ
    public function getHomePage(){
        $dataAllProduct = product::paginate(4);
        $dataSaleProduct = product::where('promotion_price','<>', 0)->paginate(8);
        return view('client.home',compact('dataAllProduct','dataSaleProduct'));
    }

    //Begin:Danh mục sản phẩm của menu cha
    public function getSubProductType($subTypeId){
        $subCategoryById =  product_type::find($subTypeId);
        return view('client.products.sub-category', compact('subCategoryById'));
    }

    //Begin: danh mục sản phẩm của menu cấp 1
    public function getChildProductType($childTypeId){
        //Lấy id danh mục con-> truy ra id_type(product_type_item) = id_type_item (product_type)
        $productTypeId =  product_type_item::find($childTypeId);
        // Tìm được id_type_item(của bảng sản phẩm)-> lấy sản phẩm
        if (!empty($productTypeId)) {
            $idProductTypeItem = $productTypeId->id_type;
            $childCategoryById = product_type_item::where('id',$childTypeId)->first(); //tên con
            $subCategoryById = product_type::where('id',$idProductTypeItem)->first(); //tên cha
            $productChildType = product::where('id_type_item',$childTypeId)->paginate(16);
            return view('client.products.child-category', compact('productChildType','childCategoryById','subCategoryById'));
        }

    }

    //Begin: gọi khối AllProduct
    public function getAllProductPaginate(){
        $dataAllProduct = product::paginate(4);
        return view('client.products.allProduct',compact('dataAllProduct'));
        //    //return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
        //    return redirect()->back();
    }

    //Begin: gọi khối Sale-product
    public function getSaleProductPaginate(){
        $dataSaleProduct = product::where('promotion_price','<>', 0)->paginate(8);
        return view('client.products.saleProduct',compact('dataSaleProduct'));
    }

    //Begin: search-Product
    public function getSearchProduct(request $req){
        $productSearch = product::where('name', 'like', '%' .$req->key .'%')
                             ->orWhere('unit_price', 'like', '%' .$req->key .'%')
                             ->paginate(8);
        return view('client.search',compact('productSearch'));
    } //End: search-Product

    //Begin: Page: detail-product
    public function getDetailProduct($idProduct){
        $producDetail = product::find($idProduct);
        return view('client.products.detailProduct',compact('producDetail'));
    }

    //Begin: thêm vào Gỏi hàng
    public function getAddToCart(request $req, $idProduct){

        //Lấy thông tin sản phẩm với id nhận được từ route
        $product = product::find($idProduct);
        //Tạo 1 biến session tên cart, Nếu có rồi thì lấy gtri k thì cho null
        $oldCart = session('cart')?session('cart'):null;
        //Trỏ tới model Cart ,truyền vào giá trin cart cũ
        $cart = new Cart($oldCart);
        // dùng phương thức add đã viết sẵn ở model Cart để thêm hàng
        $cart->add($product,$idProduct);
        // Sau khi add thành công add giỏ hàng này vào session ten cart, gia tri la $cart
        $req->session()->put('cart',$cart); //dd($cart);
        return redirect()->back();  // Trả lại trang cũ
        //return response('Hello World', 200)->back();
    }
    public function getAddToCartAjax(request $req){
        $product = product::find($req->idProduct);
        $oldCart = session('cart')?session('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product,$req->idProduct);
        $req->session()->put('cart',$cart);

        return response()->json(['msg'=> "$req->idProduct"]);
    }

    //xóa 1 dòng sản phẩm trong giỏ hàng
    public function getDelItemCart($id){
        $oldCart = session::has('cart')?session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0 ) {
            session::put('cart',$cart);
        }else{
             session::forget('cart');

        }
        return redirect()->back();
    }
    //Xoas 1 dongf sanr phaamr bange ajax
    public function getDelItemCartAjax(request $req){
        $oldCart = session::has('cart')?session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($req->idProduct);
        if (count($cart->items) > 0 ) {
            session::put('cart',$cart);
        }else{
            session::forget('cart');
        }
        $oldCart = session('cart')?session('cart'):null;
        return response()->json(['msg'=> "$req->idProduct"]);
    }

    //update gio hang ajax
    public function updateCartAjax(request $req){
        $product = product::find($req->idProduct);
        $oldCart = session('cart')?session('cart'):null;
        $cart = new Cart($oldCart);
        $cart->update($product,$req->idProduct,$req->amuontProduct, $req->totalPrice);
        $req->session()->put('cart',$cart);
    }

    //End: Gỏi hàng

    //Begin: Chọn mua ngay
    public function getProductOrderNow(request $req,$id_product){
        $product = product::find($id_product);
        $oldCart = session('cart')?session('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product,$id_product);
        $req->session()->put('cart',$cart);
        return redirect()->route('orderPage');
    }

    //Begin: Trang đặt hàng
    public function getProductOrder(){
        return view('client.order');
    }

    public function postProductOrder(Request $req){

        if ($req->session()->has('cart')) {
            $this->validate($req,
                [
                    'txt_order_name' => 'required',
                    'txt_order_phone'=> 'required',
                    'txt_order_email'=> 'required|email',
                    'txt_order_address'=> 'required',
                    // 'txt_order_payment'=> 'required',
                ],
                [
                    'txt_order_name.required' =>' Nhập tên bạn',
                    'txt_order_phone.required'=> ' Nhập số điện thoại',
                    'txt_order_email.required'=> 'Vui lòng nhập Email',
                    'txt_order_email.email'=> 'Email không đúng định dạng',
                    'txt_order_email.unique'=> ' Email đã sử dụng',
                    'txt_order_address.required'=> ' Nhập địa chỉ',
                    // 'txt_order_payment.required'=> ' Chọn phương thức thanh toán',
                ]
            );
            $cusEmailCheck = customer::where('email',$req->txt_order_email)->first();

            // Lưu thông tin người đặt hàng vào bảng customer

           if ($req->txt_order_payment == "COD"){
               if (!empty($cusEmailCheck)) {
                   $customerId = $cusEmailCheck->id;
               }else{
                   $customer = new customer();
                   $customer->name = $req->txt_order_name;
                   $customer->email = $req->txt_order_email;
                   $customer->phone = $req->txt_order_phone;
                   $customer->address = $req->txt_order_address;
                   $customer->save();
                   $customerId = $customer->id;
               }

               //Lưu thông tin  đơn hàng vào  bảng bill
               $cart = Session::get('cart');

               $bill = new bill();
               $bill->id_customer = $customerId;
               $bill->date_order = date('Y-m-d');
               $bill->money_total = $cart->totalPrice;
               $bill->payment = $req->txt_order_payment;
               $bill->note = $req->txt_order_message;
               $bill->save();

               // Lưu thông tin vào bảng bill_detail
               // vì giỏ hàng có thể có nhiều sản phẩm nên phải dùng vòng lặp để lưu
               foreach ($cart->items as $key => $value) {
                   $bill_detail = new bill_detail;
                   $bill_detail->id_bill = $bill->id;
                   $bill_detail->id_product = $key;
                   $bill_detail->quantity = $value['qty'];
                   $bill_detail->unit_price = ($value['price']/$value['qty']);
                   $bill_detail->save();
               }
               //Lưu xong xóa giỏ hàng
               Session::forget('cart');
               return redirect()->back()->with('thongbao',"Bạn đã đặt mua => thành công");

           }else{
               //Ngươc lại, khi text trả vè là ATM thì nhảy sang thanh toan OnePay
               $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
               $vpcURL = $_POST["virtualPaymentClientURL"] . "?";
               unset($_POST["virtualPaymentClientURL"]);
               unset($_POST["SubButL"]);
               $stringHashData = "";
               ksort ($_POST);
               $tran = "ch_1CsSpfChKxeisY5P" .str_random(8);
               $data=[
                   'property_id' => Session::get('payment_property_id'),
                   'checkin' => Session::get('payment_checkin'),
                   'checkout' => Session::get('payment_checkout'),
                   'number_of_guests' => Session::get('payment_number_of_guests'),
                   'price_list' => Session::get('payment_price_list'),
                   'country' => Session::get('payment_country'),
                   'message_to_host' => Session::get('message_to_host_'),
                   'paymode' => 'OnePay',
                   'payment_method_id' => '5',
                   'transaction_id' => $tran,
                   'amount' => Session::get('amount')
               ];
               if (!empty($cusEmailCheck)) {
                   $customerId = $cusEmailCheck->id;
               }else{
                   $customer = new customer();
                   $customer->name = $req->txt_order_name;
                   $customer->email = $req->txt_order_email;
                   $customer->phone = $req->txt_order_phone;
                   $customer->address = $req->txt_order_address;
                   $customer->save();
                   $customerId = $customer->id;
               }
               //Lưu thông tin  đơn hàng vào  bảng bill
               $cart = Session::get('cart');

               $bill = new bill();
               $bill->id_customer = $customerId;
               $bill->date_order = date('Y-m-d');
               $bill->money_total = $cart->totalPrice;
               $bill->payment = $req->txt_order_payment;
               $bill->note = $req->txt_order_message;
               $bill->save();

               // Lưu thông tin vào bảng bill_detail
               // vì giỏ hàng có thể có nhiều sản phẩm nên phải dùng vòng lặp để lưu
               foreach ($cart->items as $key => $value) {
                   $bill_detail = new bill_detail;
                   $bill_detail->id_bill = $bill->id;
                   $bill_detail->id_product = $key;
                   $bill_detail->quantity = $value['qty'];
                   $bill_detail->unit_price = ($value['price']/$value['qty']);
                   $bill_detail->save();
               }
               //Lưu xong xóa giỏ hàng
               Session::forget('cart');

               $code = str_random('6');
               $appendAmp = 0;
               foreach($_POST as $key => $value) {
                   if ($key == "vpc_OrderInfo" )
                       $value = $code;
                   if (strlen($value) > 0) {
                       if ($appendAmp == 0) {
                           $vpcURL .= urlencode($key) . '=' . urlencode($value);
                           $appendAmp = 1;
                       } else {
                           $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                       }
                       if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                           $stringHashData .= $key . "=" . $value . "&";
                       }
                   }
               }
               $stringHashData = rtrim($stringHashData, "&");
               if (strlen($SECURE_SECRET) > 0) {
                   $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)));
               }
               return Redirect::to($vpcURL);
           }
        }else{return redirect()->back()->with('thongbao',"Giỏ hàng trống");}
    }

    public function getInternal(){
        $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
        $data=[];
        $vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
        unset ( $_GET ["vpc_SecureHash"] );
        $data['errorExists'] = false;
        ksort ($_GET);
        if (strlen ( $SECURE_SECRET ) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
            $stringHashData = "";
            foreach ( $_GET as $key => $value ) {
                if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
            $stringHashData = rtrim($stringHashData, "&");
            if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)))) {
                $data['hashValidated'] = "CORRECT";
            } else {
                $data['hashValidated'] = "INVALID HASH";
            }
        } else {
            $data['hashValidated'] = "INVALID HASH";
        }

        $data['amount'] = $this->null2unknown( $_GET ["vpc_Amount"] );
        $data['locale'] = $this->null2unknown( $_GET ["vpc_Locale"] );
        $data['command'] = $this->null2unknown ( $_GET ["vpc_Command"] );
        $data['version'] = $this->null2unknown ( $_GET ["vpc_Version"] );
        $data['orderInfo'] = $this->null2unknown ( $_GET ["vpc_OrderInfo"] );
        $data['merchantID'] = $this->null2unknown ( $_GET ["vpc_Merchant"] );
        $data['merchTxnRef'] = $this->null2unknown ( $_GET ["vpc_MerchTxnRef"] );
        $data['transactionNo'] = $this->null2unknown ( $_GET ["vpc_TransactionNo"] );
        $data['txnResponseCode'] = $this->null2unknown ( $_GET ["vpc_TxnResponseCode"] );

        $data['transStatus'] = "";
        if($data['hashValidated']=="CORRECT" && $data['txnResponseCode']=="0"){
            $data['transStatus'] = "Giao dịch thành công";
        }elseif ($data['hashValidated']=="INVALID HASH" && $data['txnResponseCode']=="0"){
            $data['transStatus'] = "Giao dịch Pendding";
        }else {
            $data['transStatus'] = "Giao dịch thất bại";
        }
        return redirect('dat-hang/?code=' .$_GET['vpc_OrderInfo'])->with('thongbao',"Bạn đã đặt mua thành công");
    }
    function null2unknown($data) {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }
    function getResponseDescription($responseCode) {
        switch ($responseCode) {
            case "0" :
                $result = "Giao dịch thành công - Approved";
                break;
            case "1" :
                $result = "Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3" :
                $result = "Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4" :
                $result = "Không đúng access code - Invalid access code";
                break;
            case "5" :
                $result = "Số tiền không hợp lệ - Invalid amount";
                break;
            case "6" :
                $result = "Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7" :
                $result = "Lỗi không xác định - Unspecified Failure ";
                break;
            case "8" :
                $result = "Số thẻ không đúng - Invalid card Number";
                break;
            case "9" :
                $result = "Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10" :
                $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11" :
                $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12" :
                $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13" :
                $result = "Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21" :
                $result = "Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "99" :
                $result = "Người sủ dụng hủy giao dịch - User cancel";
                break;
            default :
                $result = "Giao dịch thất bại - Failured";
        }
        return $result;
    }

    public function withdraws(Request $request){
        $photos = Photo::where('user_id', \Auth::user()->id)->get();
        $photo_ids = [];
        foreach ($photos as $key => $value) {
            $photo_ids[] = $value->id;
        }
        $payment_sum = Payment::whereIn('photo_id', $photo_ids)->sum('amount');
        $withdraw_sum = Withdraw::where('user_id', Auth::user()->id)->sum('amount');
        $data['total'] = $total = $payment_sum - $withdraw_sum;
        if ($_POST) {
            if ($total >= $request->amount) {
                $withdraw = new Withdraw;
                $withdraw->user_id = Auth::user()->id;
                $withdraw->amount = $request->amount;
                $withdraw->status = 'Pending';
                $withdraw->save();
                $data['success'] = 1;
                $data['message'] = 'Success';
            } else {
                $data['success'] = 0;
                $data['message'] = 'Balance exceed';
            }
            echo json_encode($data);
            exit;
        }

        $data['details'] = Auth::user()->details_key_value();
        $data['results'] = Withdraw::where('user_id', Auth::user()->id)->get();
        return view('payment.withdraws', $data);
    }
/** =========== End: Thanh toán - đặt hàng ==================*/

/** =========== Begin: Trang tin tức ========================*/
    public function getNewsPage(){
        $newsData = news::paginate(4);

        return view('client.news.news',compact('newsData'));
    }

    public function getDetailNewsPage($idNews){
        $newsById =  news::find($idNews);
        return view('client.news.new-detail',compact('newsById'));
    }





}
