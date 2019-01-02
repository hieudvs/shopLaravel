<!DOCTYPE html>
<html lang="en"><head>
<title> Owen admin 2.0 </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{asset('source/assets/bootstrap/bootstrap.css ')}}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('source/assets/css/dashboard.css')}}">
</head>

<style>
html,
body {
height: 100%;
}

body {
display: -ms-flexbox;
display: flex;
-ms-flex-align: center;
align-items: center;
padding-top: 40px;
padding-bottom: 40px;
background-color: #f5f5f5;
}

.form-signin {
width: 100%;
max-width: 330px;
padding: 15px;
margin: auto;
}
.form-signin .checkbox {
font-weight: 400;
}
.form-signin .form-control {
position: relative;
box-sizing: border-box;
height: auto;
padding: 10px;
font-size: 16px;
}
.form-signin .form-control:focus {
z-index: 2;
}
.form-signin input[type="email"] {
margin-bottom: -1px;
border-bottom-right-radius: 0;
border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
margin-bottom: 10px;
border-top-left-radius: 0;
border-top-right-radius: 0;
}
</style>

<body class="text-center">

    <form action="{{route('loginPage')}}" method="post" class="form-signin" role="form" enctype="multipart/form-data">
        @csrf
        <img class="mb-4" src="{{asset("source/images/logotitle.png")}}" alt="" width="45px" height="45px">
        <h1 class="h4 mb-3 font-weight-normal">Trang quản trị Owen</h1>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="" name="txt_email" class="form-control" placeholder="Nhập email ..." required autofocus>
        <label for="inputPassword" class="sr-only">Mật khẩu</label>
        <input type="password" id="" name="txt_password" class="form-control" placeholder="Nhập mật khẩu ..." required>
        <div class="checkbox mb-3">
            <label>
             <input hidden type="checkbox" value="remember-me">
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>

        <div class="thongbao">
            <!-- Thông báo của hàm validate-->
            @if (count($errors) > 0)
            <div class="mx-auto" style="width:19%;">
                <div class="alert alert-success text-center">
                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Thông báo khi đăng nhập-->
            @if (Session::has('thongbao'))
                <div class="mx-auto" style="width:19%;">
                    <div class="alert alert-success text-center">
                        {{session::get('thongbao')}}
                    </div>
                </div>
            @endif
        </div>
    </form>

<!-------------------------------------------------------------------------------------------->
   <!-- jQuery 3.3.1-->
   <script type="text/javascript" src="{{asset('source/assets/js/jquery.js ')}}"></script>
   <script type="text/javascript" src=" {{asset('source/assets/bootstrap/popper.min.js')}} "></script>
   <!-- Bootstrap Core JavaScript 4.1.3-->
   <script type="text/javascript" src="{{asset('source/assets/bootstrap/bootstrap.js ')}}"></script>
   <!-- myJS-->
   <script type="text/javascript" src="{{asset('source/assets/js/dashboard.js')}}"></script>
   <!-- ckeditor 5 nhap lieu -->
   <script type="text/javascript" src="{{asset('source/assets/ckeditor5/classic/ckeditor.js ')}}"></script>

</body>
</html>
