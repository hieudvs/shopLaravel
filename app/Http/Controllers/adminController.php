<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;  // thư viện bảo mật
use Auth;
use Session;
use Validator;
use App\User;
use App\product;
use App\product_type;
use App\product_type_item;
use App\image;
use App\slide;
use App\news;
use App\bill;
use App\bill_detail;
use App\customer;


class adminController extends Controller
{
    public function __construct() {
      $this->middleware('clearCache');
    }

    //Phần login
    public function getLogin(){
        return view('admin.login');
    }
    public function postLogin(request $req){
        $check = $this->validate($req,
            [
                'txt_email'=> 'required|email',
                'txt_password'=>'required|min:6|max:20',
            ],
            [
                'txt_email.required'=> 'Vui lòng nhập Email',
                'txt_email.email'=> 'Email không đúng định dạng',
                'txt_password.required'=>'Vui lòng nhập mật khẩu',
                'txt_password.min'=>'Mật khẩu phải từ 6 ký tự',
                'txt_password.max'=>'Mật khẩu phải ít hơn 20 ký tự',
            ]
        );
        //Lấy về giá trị gán vào  1 mảng
        $credentials = array(
            'email'=> $req->txt_email,
            'password'=> $req->txt_password,
            'level'=>'1'
        );
        //dùng Auth kiểm tra trong database
        if (Auth::attempt($credentials)){
            return redirect()->route('adminHomePage')->with('thongbao',"Bạn đăng nhận thành công");
            // return redirect()->back()->with('thongbao',"Bạn đăng nhận thành công");
        }else{
            return redirect()->back()->with('thongbao',"Bạn đăng nhận thất bại");
        }
    }
    //Phần logout
    public function getLogout(){
        Auth::logout();
        return redirect()->route('getloginPage');
    }
    // Trang chủ admin
    public function getDashboard(){
        return view('admin.dashboard');
    }

    /*---------------------Begin: Bảng User ----------------------*/
    // Hiển thị nội dung trang Nhân viên
    public function getUserPage(){
        $dataAllUser = User::all();
        $methodUser = 'add';
        return view('admin.user',compact('dataAllUser','methodUser'));
    }

    //Thêm nhân viên ----------------------------------------------
    public function postUserRegister(request $req){
        /* Dùng form validate kiểm tra thông tin nhận về từ form->
            tra lại các cột trong database để gán thuộc tính,
            Cột nào bắt buột nhận thì thêm: required*/
        $this->validate($req,
            [
                'txt_name'=>'required',
                'txt_email'=> 'required|email|unique:users,email',
                'txt_phone'=>'required',
                'txt_address'=>'required',
                'txt_password'=>'required|min:6|max:20',
            ],
            [
                'txt_name.required'=>'Vui lòng nhập Họ tên',
                'txt_email.required'=> 'Vui lòng nhập Email',
                'txt_email.email'=> 'Email không đúng định dạng',
                'txt_email.unique'=> ' Email đã sử dụng',
                'txt_phone.required'=>'Vui lòng nhập số điện thoại',
                'txt_address.required'=>'Vui lòng nhập địa chỉ',
                'txt_password.required'=>'Vui lòng nhập mật khẩu',
                'txt_password.min'=>'Mật khẩu phải từ 6 ký tự',
                'txt_password.max'=>'Mật khẩu phải ít hơn 20 ký tự',
            ]
        );
        // Nhập dữ liệu vào database

        // $allReq =  $req->all();
        // $pass = $allReq['txt_password'];
        // $data = array(
        //     'name'=>$allReq['txt_name'],
        //      'email' => $allReq['txt_email'],
        //      'password' => bcrypt($pass),
        // );
        // $user = new User();
        // $result = $user->insert($data);

        $user = new User();
        $user->name = $req->txt_name; // $user = ten bang = bien nhan ve-> ten name o view
        $user->email = $req->txt_email;
        $user->phone = $req->txt_phone;
        $user->address = $req->txt_address;
        $user->position = $req->txt_position;
        $user->id_department = $req->txt_department;
        $user->level = $req->txt_level;
        $user->password = Hash::make($req->txt_password) ;

        $result = $user->save();
        if ($result) {
            return redirect()->back()->with('thongbao',"Thêm nhân viên: $req->txt_name => thành công");
        }
    }

    //Xóa nhân viên bằng id
    public function deleteUserById($userId){
        $result = User::find($userId)->delete();
        if ($result) {
            return redirect()->back()->with('thongbao',"Xóa nhân viên => thành công");
        }
    }

    //Sửa thông tin nhân viên --------------------------------------
    public function getUserById($userId){
        //Lấy thông tin user với id
        $dataUserById = User::find($userId);
        $methodUser = 'edit';
        return view('admin.user',compact('dataUserById','methodUser'));
    }
    public function postUserById(request $req,$userId){
        $this->validate($req,
            [
                'txt_name'=>'required',
                'txt_email'=> 'required|email',
                'txt_phone'=>'required',
                'txt_address'=>'required',
                'txt_password'=>'required|min:6|max:20',
            ],
            [
                'txt_name.required'=>'Vui lòng nhập Họ tên',
                'txt_email.required'=> 'Vui lòng nhập Email',
                'txt_email.email'=> 'Email không đúng định dạng',
                'txt_phone.required'=>'Vui lòng nhập số điện thoại',
                'txt_address.required'=>'Vui lòng nhập địa chỉ',
                'txt_password.required'=>'Vui lòng nhập mật khẩu',
                'txt_password.min'=>'Mật khẩu phải từ 6 ký tự',
                'txt_password.max'=>'Mật khẩu phải ít hơn 20 ký tự',
            ]
        );
        // Nhập dữ liệu vào database
        // Tạo biến  trỏ tới bảng Users thông qua model User
        $user = User::find($userId);
        $user->name = $req->txt_name; // $user = ten bang = bien nhan ve-> ten name o view
        $user->email = $req->txt_email;
        $user->phone = $req->txt_phone;
        $user->address = $req->txt_address;
        $user->position = $req->txt_position;
        $user->id_department = $req->txt_department;
        $user->level = $req->txt_level;
        $user->password = Hash::make($req->password) ;
        $result = $user->save();
        if ($result) {
            return redirect()->route('userPage')->with('thongbao',"Sửa thông tin => thành công");
        }
    }
    /*---------------------End: Bảng User ----------------------*/

/*---------------------Begin: Bảng Product ----------------------*/

    // Hiển thị nội dung trang Sản phẩm
    public function getProductPage(){
        $dataAllProduct = product::all();
        $subCatagory = product_type::all();
        $childCatagory = product_type_item::all();
        $methodProduct= 'add';
        return view('admin.product',compact('dataAllProduct','subCatagory','childCatagory','methodProduct'));
    }

    //Thêm sản phẩm
    public function postAddProduct(request $req){
        // $subCategory = product_type::first();

        if (!empty(product_type::first())) {
            //$childCategory = product_type_item::first();
            if (!empty(product_type_item::first())) {
            $this->validate($req,
                [
                    'txt_ProductName'=>'required',
                    'txt_unitPrice'=>'required',
                    'txt_unitPurchasePrice'=> 'required',
                    'txt_unit'=>'required',
                    'txt_idType'=>'required',
                    'txt_images'=>'required',
                ],
                [
                    'txt_ProductName.required'=>'Vui lòng nhập tên sản phẩm',
                    'txt_unitPrice.required'=> 'Vui lòng nhập giá bán',
                    'txt_unitPurchasePrice.required'=>'Vui lòng nhập giá nhập',
                    'txt_unit.required'=>'Vui lòng nhập đơn vị tính',
                    'txt_idType.required'=>'Vui lòng nhập loại sản phẩm',
                    'txt_images.required'=>'Vui lòng chọn ảnh sản phẩm',
                ]
            );
            $tensp = $req->txt_ProductName;
            if (!empty($tensp)) {
                if ($req->hasFile('txt_images')) {
                    //Lấy về file
                    $file = $req->file('txt_images');
                    //Kiểm tra đuôi file là gì, cho phép không
                    if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                        || $file->getClientOriginalExtension('txt_images') == 'JPG'
                        || $file->getClientOriginalExtension('txt_images') == 'png'
                        || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                        $imageName = $file->getClientOriginalName('txt_images');
                        $imageName = time()."_".$imageName;
                        $file->move('uploads/products', $imageName);

                    }else{
                        return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                    }
                }else{
                    return redirect()->back()->with('thongbao','Chưa chọn hình sản phẩm');
                }
            }else{
                return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin');
            }

            //Lưu dữ liệu vào database
            $product = new product();
            $product->name = $req->txt_ProductName;
            $product->id_type_item = $req->txt_idTypeItem;
            $product->unit_price = $req->txt_unitPrice;
            $product->unit_purchase_price = $req->txt_unitPurchasePrice;
            $product->promotion_price = $req->txt_promotionPrice;
            $product->unit = $req->txt_unit;
            $product->qty_product = $req->txt_qtyProduct;
            $product->id_producer = null;

            $product->description = $req->txt_description;
            $product->images = $imageName;
            $product->id_user = $req->txt_idUser;

            $result = $product->save();
            if ($result) {
                return redirect()->back()->with('thongbao',"Thêm sản phẩm: $req->txt_ProductName => thành công");
            }
            }else{ return redirect()->back()->with('thongbao','Chưa có danh mục sản phẩm - cấp 1 => Bạn tạo danh mục sản phẩm cấp 1 trước');}
        }else{ return redirect()->back()->with('thongbao','Chưa có danh mục sản phẩm cha => Bạn tạo danh mục sản phẩm cha trước');}
    }

    //Xóa sản phẩm:
    public function deleteProductById(request $req, $productId){
        //Lấy tên hình để xóa
        $fileName = product::where('id',$productId)->first();
        $result = product::find($productId)->delete();

        if (!empty($fileName)) {
            unlink("uploads/products/$fileName->images");
        }
        if ($result) {
            return redirect()->back()->with('thongbao',"Xóa sản phẩm => thành công");
        }
    }

    //Sửa thông tin sản phẩm
    public function getProductById($productId){
        $dataProductById = product::find($productId);
        $subCatagory = product_type::all();
        $childCatagory = product_type_item::all();
        $methodProduct = 'edit';
        return view('admin.product',compact('dataProductById','subCatagory','childCatagory','methodProduct'));
    }
    public function postEditProductById(request $req,$productId){
        $this->validate($req,
            [
                'txt_ProductName'=>'required',
                'txt_unitPrice'=>'required',
                'txt_unitPurchasePrice'=> 'required',
                'txt_unit'=>'required',
                'txt_idType'=>'required',
            ],
            [
                'txt_ProductName.required'=>'Vui lòng nhập tên sản phẩm',
                'txt_unitPrice.required'=> 'Vui lòng nhập giá bán',
                'txt_unitPurchasePrice.required'=>'Vui lòng nhập giá nhập',
                'txt_unit.required'=>'Vui lòng nhập đơn vị tính',
                'txt_idType.required'=>'Vui lòng nhập loại sản phẩm',
            ]
        );

        $product = product::find($productId);
        $tensp = $req->txt_ProductName;
        if (!empty($tensp)) {
            if ($req->hasFile('txt_images')) {
                //Lấy về file
                $file = $req->file('txt_images');
                //Kiểm tra đuôi file là gì, cho phép không
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                    $imageName = $file->getClientOriginalName('txt_images');
                    $oldFileName = $product->images;
                    //Kiểm tra xem có trùng tên hình đã lưu không
                    if ($oldFileName != $imageName) {
                        unlink("uploads/products/$oldFileName"); //Xóa hình cũ
                    }
                    $imageName = time()."_".$imageName;
                    $result = $file->move('uploads/products', $imageName);
                    $product->images = $imageName; // Lấy tên lưu vào database

                }else{ return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png'); }
            }
        }else{ return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin'); }

        //Lưu dữ liệu vào database
        $product->name = $req->txt_ProductName;
        $product->id_type_item = $req->txt_idTypeItem;
        $product->unit_price = $req->txt_unitPrice;
        $product->unit_purchase_price = $req->txt_unitPurchasePrice;
        $product->promotion_price = $req->txt_promotionPrice;
        $product->unit = $req->txt_unit;
        $product->qty_product = $req->txt_qtyProduct;
        $product->id_producer = null;
        $product->description = $req->txt_description;
        $result = $product->save();
        if ($result) {
            return redirect(route('productPage'))->with('thongbao',"Sửa sản phẩm: $req->txt_ProductName => thành công");
        }
    }

    //Begin: Danh mục sản phẩm chọn lúc tạo
    public function getChildCatagoryAjax(request $req){
        $childCatagory = product_type_item::where('id_type',$req->idCatagory)->get();

        foreach ($childCatagory as $value) {

            echo " <option value='". $value->id ."'>". $value->name ."</option>";
        }
    }
/*---------------------End: Bảng Product ----------------------*/

/*---------------------Begin: Bảng ProductType ----------------------*/

    // Hiển thị nội dung trang danh mục Sản phẩm
    public function getProductTypePage(){
        $dataAllProductType = product_type::all();
        $methodProduct= 'add';
        return view('admin.product-type',compact('dataAllProductType','methodProduct'));
    }

    //Thêm danh mục Sản phẩm
    public function postAddProductType(request $req){
        if (count(product_type::all())  >= 8) {
            return redirect()->back()->with('thongbao',"Thất bại => số lượng không quá 8");
        }else{
            $this->validate($req,
                ['txt_name'=>'required',],
                ['txt_name.required'=>'Vui lòng nhập tên sản phẩm',]
            );
            $productType = new product_type();
            $productTypeName = $req->txt_name;
            if (!empty($productTypeName)) {
                if ($req->hasFile('txt_images')) {
                    //Lấy về file
                    $file = $req->file('txt_images');
                    //Kiểm tra đuôi file là gì, cho phép không
                    if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                        || $file->getClientOriginalExtension('txt_images') == 'JPG'
                        || $file->getClientOriginalExtension('txt_images') == 'png'
                        || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                        if (!empty($file->getClientOriginalName('txt_images'))) {
                            $imageName = $file->getClientOriginalName('txt_images'); //dd($imageName_new);
                            /** //Kiểm tra xem có trùng tên hình không
                            if (!empty( product_type::where('images',$imageName_new)->first())) {
                                $imageName = time()."_".$imageName_new; //dd($imageName);
                            }// End: kiểm tra trùng tên
                            */
                            $imageName = time()."_".$imageName;
                            $file->move('uploads/admin', $imageName);
                        }else{
                            $imageName = null;
                        }
                    }else{
                        return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                    }
                }else{
                    $imageName = null;
                }
            }else{
                return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin');
            }
            //Lưu dữ liệu vào database
            $productType->name = $req->txt_name;
            $productType->description = $req->txt_description;
            $productType->id_user = $req->txt_idUser;
            $productType->images = $imageName;
            $result = $productType->save();
            if ($result) {
                return redirect()->back()->with('thongbao',"Thêm danh mục: $req->txt_name => thành công");
            }
        }
    }

    //Sửa thông tin danh mục
    public function getProductTypeById($productTypeId){
        $productTypeById = product_type::find($productTypeId);
        $methodProduct = 'edit';
        return view('admin.product-type',compact('productTypeById','methodProduct'));
    }
    public function postEditProductTypeById(request $req,$productTypeId){
        $this->validate($req,
            [ 'txt_name'=>'required', ],['txt_name.required'=>'Vui lòng nhập tên sản phẩm',]
        );

        $productType = product_type::find($productTypeId);
        $productTypeName = $req->txt_name;
        if (!empty($productTypeName)) {
            if ($req->hasFile('txt_images')) {
                //Lấy về file
                $file = $req->file('txt_images');
                //Kiểm tra đuôi file là gì, cho phép không
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                    $imageName = $file->getClientOriginalName('txt_images');

                    $oldFileName = $productType->images;
                    //Kiểm tra xem có trùng tên hình đã lưu không
                    if ($oldFileName != $imageName) {
                        if  (!empty($oldFileName)) {
                            unlink("uploads/admin/$oldFileName"); //Xóa hình cũ
                        }
                    }
                    $imageName = time()."_".$imageName;
                    $file->move('uploads/admin', $imageName);
                    $productType->images = $imageName; // Lấy tên lưu vào database
                }else{
                    return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                }
            }
        }else{
            return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin');
        }
        //Lưu dữ liệu vào database
        $productType->name = $req->txt_name;
        $productType->description = $req->txt_description;
        $productType->id_user = $req->txt_idUser;
        $result = $productType->save();
        if ($result) {
            return redirect(route('productTypePage'))->with('thongbao',"Sửa sản phẩm: $req->txt_name => thành công");
        }
   }

    //Xóa danh mục:
    public function deleteProductTypeById($productTypeId){
        //Lấy tên hình để xóa
        $fileName = product_type::where('id',$productTypeId)->first();
        $result = product_type::find($productTypeId)->delete();
        if (!empty($fileName->images)) {
            unlink("uploads/admin/$fileName->images");
        }
        if ($result) {
            return redirect()->back()->with('thongbao',"Xóa danh mục => thành công");
        }
    }

/*---------------------End: Bảng ProductType ----------------------*/

/*---------------------Begin: Bảng ProductTypeItem ----------------*/
    public function getProductTypeItemPage(){
        $dataProductTypeItem = product_type_item::all();
        $subCategory = product_type::all();
        $methodProduct= 'add';
        return view('admin.product-type-item',compact('dataProductTypeItem','subCategory','methodProduct'));
    }

    //Thêm danh mục Sản phẩm cấp 1
    public function postAddProductTypeItem(request $req){
        //Kiểm tra xem có danh mục cha chưa, nếu chưa  phải tạo danh mục cha trước
        //Vì 1 danh mục con cấp 1 , phải thuộc 1 danh mục cha nào đó
        $subCategory = product_type::first();
        if (!empty($subCategory->name)) {
            $this->validate($req,
                [
                    'txt_name'=>'required',
                    // 'txt_id_type_item'=>'required',
                ],
                [
                    'txt_name.required'=>'Vui lòng nhập tên sản phẩm',
                    //'txt_id_type_item.required'=>'Vui lòng chọn danh mục cha',
                ]
            );
            $productTypeItem = new product_type_item();
            $productTypeItemName = $req->txt_name;
            if (!empty($productTypeItemName)) {
                if ($req->hasFile('txt_images')) {
                    $file = $req->file('txt_images');
                    if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                        || $file->getClientOriginalExtension('txt_images') == 'JPG'
                        || $file->getClientOriginalExtension('txt_images') == 'png'
                        || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                        if (!empty($file->getClientOriginalName('txt_images'))) {
                            $imageName = $file->getClientOriginalName('txt_images');
                            $imageName = time()."_".$imageName;
                            $file->move('uploads/admin', $imageName);
                        }else{ $imageName = null; }
                    }else{ return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png'); }
                }else{ $imageName = null; }

                //Lưu dữ liệu vào database
                $productTypeItem->name = $req->txt_name;
                $productTypeItem->id_type = $req->txt_id_type;
                $productTypeItem->description = $req->txt_description;
                $productTypeItem->id_user = $req->txt_idUser;
                $productTypeItem->images = $imageName;
                $result = $productTypeItem->save();
                if ($result) {
                    return redirect()->back()->with('thongbao',"Thêm danh mục cấp 1: $req->txt_name => thành công");
                }

            }else{ return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin'); }

        }else{ return redirect()->back()->with('thongbao','Chưa có danh mục cha => Bạn tạo danh mục cha trước');}

    }

    //Sửa thông tin danh mục
    public function getProductTypeItemById($productTypeItemId){
        $productTypeItemById = product_type_item::find($productTypeItemId);
        $subCategory = product_type::all();
        $methodProduct = 'edit';
        return view('admin.product-type-item',compact('productTypeItemById','subCategory','methodProduct'));
    }
    public function postEditProductTypeItemById(request $req,$productTypeItemId){
        $this->validate($req,
            [
                'txt_name'=>'required',
                'txt_id_type'=>'required',
            ],
            [
                'txt_name.required'=>'Vui lòng nhập tên sản phẩm',
                'txt_id_type.required'=>'Vui lòng chọn danh mục cha',
        ]);

        $productTypeItem = product_type_item::find($productTypeItemId);
        $productTypeItemName = $req->txt_name;
        if (!empty($productTypeItemName)) {
            if ($req->hasFile('txt_images')) {
                $file = $req->file('txt_images');
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {
                    if (!empty($file->getClientOriginalName('txt_images'))) {
                        $imageName = $file->getClientOriginalName('txt_images');
                        //Kiểm tra xem có hình cũ không, nếu có thì xóa
                        if (!empty($productTypeItem->images)) {
                            $oldFileName = $productTypeItem->images;
                            //Kiểm tra xem có trùng tên hình đã lưu không
                            if ($oldFileName != $imageName) {
                                if  (!empty($oldFileName)) {
                                    unlink("uploads/admin/$oldFileName");
                                }
                            }
                        } // End: xóa hình cũ
                        $imageName = time()."_".$imageName;
                        $file->move('uploads/admin', $imageName);
                        $productTypeItem->images = $imageName;
                    }
                }else{ return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png'); }
            }
            //Lưu dữ liệu vào database
            $productTypeItem->name = $req->txt_name;
            $productTypeItem->id_type = $req->txt_id_type;
            $productTypeItem->description = $req->txt_description;
            $productTypeItem->id_user = $req->txt_idUser;
            $result = $productTypeItem->save();
            if ($result) {
                return redirect(route('productTypeItemPage'))->with('thongbao',"Sửa danh mục: $req->txt_name => thành công");
            }
        }else{ return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin'); }
    }

    //Xóa danh mục con cấp 1:
    public function deleteProductTypeItemById($productTypeItemId){
        //Lấy tên hình để xóa
        $fileName = product_type_item::where('id',$productTypeItemId)->first();
        $result = product_type_item::find($productTypeItemId)->delete();

        if (!empty($fileName->images)) {
            unlink("uploads/admin/$fileName->images");
        }
        if ($result) {
            return redirect()->back()->with('thongbao',"Xóa danh mục thành công");
        }
    }
    /*---------------------End: Bảng ProductTypeItem ------------------*/


    /*---------------------Begin: Bảng slide ----------------*/
    public function getSlidePage(){
        $dataSlide = slide::all();
        $methodProduct= 'add';
        return view('admin.slide',compact('dataSlide','methodProduct'));
    }

    //Thêm slide
    public function postAddSlide(request $req){

        $this->validate($req,
            [ 'txt_images'=>'required', ],['txt_images.required'=>'Vui lòng nhập hình slide',]
        );

            if ($req->hasFile('txt_images')) {
                //Lấy về file
                $file = $req->file('txt_images');
                //Kiểm tra đuôi file là gì, cho phép không
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                        $imageName = $file->getClientOriginalName('txt_images');
                        $imageName = time()."_".$imageName;
                        $file->move('uploads/slide',$imageName);
                }else{
                    return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                }
            }
        //Lưu dữ liệu vào database
        $slide = new slide();
        $slide->link = $req->txt_link;
        $slide->images = $imageName;
        $slide->id_user = $req->txt_idUser;
        $slide->slogan = $req->txt_solgan;


        $result = $slide->save();
        if ($result) {
            return redirect()->back()->with('thongbao',"Thêm slide => thành công");
        }
    }

    //Sửa thông tin slide
    public function getSlideById($slideId){
        $slideById = slide::find($slideId);
        $methodProduct = 'edit';
        return view('admin.slide',compact('slideById','methodProduct'));
    }

    public function postEditSlideById(request $req,$slideId){

        $slide = slide::find($slideId);
        if (!empty($slide)) {
            if ($req->hasFile('txt_images')) {
                //Nếu có file thì lấy file
                $file = $req->file('txt_images');
                //Kiểm tra đuôi file là gì, cho phép không
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                    $imageName = $file->getClientOriginalName('txt_images');

                    if(!empty($slide->images)){
                        $oldFileName = $slide->images;
                    }
                    //Kiểm tra xem có trùng tên hình đã lưu không
                    if ($oldFileName != $imageName) {
                        if (!empty($oldFileName)) {
                            unlink("uploads/slide/$oldFileName"); //Xóa hình cũ
                        }
                    }
                    $imageName = time()."_".$imageName;
                    $file->move('uploads/slide', $imageName);
                    $slide->images = $imageName;
                }else{
                    return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                }
            }
        }else{
            return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin');
        }
        //Lưu dữ liệu vào database
        $slide->link = $req->txt_link;
        $slide->id_user = $req->txt_idUser;
        $slide->slogan = $req->txt_solgan;
        $result = $slide->save();
        if ($result) {
            return redirect(route('slidePage'))->with('thongbao',"Sửa slide thành công");
        }
    }

    //Xóa slide:
    public function deleteSlideById($slideId){
        //Lấy tên hình để xóa
        $fileName = slide::where('id',$slideId)->first();
        $result = slide::find($slideId)->delete();
        if (!empty($fileName->images)) {
            unlink("uploads/slide/$fileName->images");
        }
        if ($result) { return redirect()->back()->with('thongbao',"Xóa slide thành công"); }
    }
    /*---------------------End: Bảng slide ----------------*/

    /** ================== Begin: Trang tin tức =========== */
        public function getNewsPage(){
            $dataNews = news::all();
            $methodProduct= 'add';
            return view('admin.news',compact('dataNews','methodProduct'));
        }

        //Thêm tin tức
    public function postAddNews(request $req){
    $this->validate($req,
            [
                'txt_images'=>'required',
                'txt_title'=>'required',
                'txt_content'=>'required',
            ],
            [
                'txt_images.required'=>'Vui lòng nhập hình đại diện',
                'txt_title.required'=>'Vui lòng nhập tiêu đề',
                'txt_content.required'=>'Vui lòng nhập nội dung',
            ]
        );

        if ($req->hasFile('txt_images')) {
            //Lấy về file
            $file = $req->file('txt_images');
            //Kiểm tra đuôi file là gì, cho phép không
            if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                || $file->getClientOriginalExtension('txt_images') == 'JPG'
                || $file->getClientOriginalExtension('txt_images') == 'png'
                || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                    $imageName = $file->getClientOriginalName('txt_images');
                    $imageName = time()."_".$imageName;
                    $file->move('uploads/news',$imageName);
            }else{
                return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
            }
        }
        //Lưu dữ liệu vào database
        $news = new news();
        $news->title = $req->txt_title;
        $news->images = $imageName;
        $news->id_user = $req->txt_idUser;
        $news->content = $req->txt_content;
        $news->description = $req->txt_description;

        $result = $news->save();
        if ($result) {
            return redirect()->back()->with('thongbao',"Thêm tin tức => thành công");
        }
    }

    //Sửa thông tin slide
    public function getNewsById($newsId){
        $dataEditNews = news::find($newsId);
        $methodProduct = 'edit';
        return view('admin.news',compact('dataEditNews','methodProduct'));
    }

    public function postEditNewsById(request $req,$newsId){
        $news = news::find($newsId);
        if (!empty($news)) {
            if ($req->hasFile('txt_images')) {
                //Nếu có file thì lấy file
                $file = $req->file('txt_images');
                //Kiểm tra đuôi file là gì, cho phép không
                if ($file->getClientOriginalExtension('txt_images') == 'jpg'
                    || $file->getClientOriginalExtension('txt_images') == 'JPG'
                    || $file->getClientOriginalExtension('txt_images') == 'png'
                    || $file->getClientOriginalExtension('txt_images') == 'PNG') {

                    $imageName = $file->getClientOriginalName('txt_images');

                    if(!empty($news->images)){
                        $oldFileName = $news->images;
                    }
                    //Kiểm tra xem có trùng tên hình đã lưu không
                    if ($oldFileName != $imageName) {
                        if (!empty($oldFileName)) {
                            unlink("uploads/news/$oldFileName"); //Xóa hình cũ
                        }
                    }
                    $imageName = time()."_".$imageName;
                    $file->move('uploads/news', $imageName);
                    $news->images = $imageName;
                }else{
                    return redirect()->back()->with('thongbao','Chọn file: .jpg hoặc .png');
                }
            }
        }else{
            return redirect()->back()->with('thongbao','Nhập đầy đủ thông tin');
        }
        //Lưu dữ liệu vào database

        $news->title = $req->txt_title;
        $news->id_user = $req->txt_idUser;
        $news->content = $req->txt_content;
        $news->description = $req->txt_description;

        $result = $news->save();
        if ($result) {
            return redirect(route('newsAdminPage'))->with('thongbao',"Sửa tin tức => thành công");
        }
    }

    //Xóa tin tức:
    public function deleteNewsById($newsId){
        //Lấy tên hình để xóa
        $fileName = news::where('id',$newsId)->first();
        $result = news::find($newsId)->delete();
        if (!empty($fileName->images)) {
            unlink("uploads/news/$fileName->images");
        }
        if ($result) { return redirect()->back()->with('thongbao',"Xóa slide thành công"); }
    }

/** Begin: Trang hiển thị đơn hàng */
    public function getBillPage(){
        $dataBill = bill::all();
        $dataBillDetail = bill_detail::all();
        $dataProduct = product::all();
        $dataCustomer = customer::all();
        $methodBill = 'add';
        return view('admin.bill',compact('dataBill','dataBillDetail','dataProduct','dataCustomer','methodBill'));
    }

    //Xóa
    public function deleteBillById($idBill){

        bill_detail::where('id_bill',$idBill)->delete();
        bill::find($idBill)->delete();
        return redirect()->back()->with('thongbao',"Xóa đơn hàng thành công");
    }


/** End: Trang hiển thị đơn hàng */


}
