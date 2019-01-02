<!DOCTYPE html>
<html lang="en">
<head>
	<title> Owen shop </title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <base href="asset"> --}}
	<link rel="stylesheet" href="{{asset('source/assets/bootstrap/bootstrap.css ')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('source/assets/css/resetCss.css ')}}">
    <link rel="stylesheet" href="{{asset('source/assets/css/myStyle.css ')}}">
    <link rel="stylesheet" href="{{asset('source/assets/css/detail-product.css ')}}">


    @yield('style')

</head>
<body class="desktop">

    @include('client.header')
    @yield('content')

    @include('client.footer')

<!-------------------------------------------------------------------------------------------->
    <!-- jQuery 3.3.1-->
     <script type="text/javascript" src="{{asset('source/assets/js/jquery.js ')}}"></script>
     <script type="text/javascript" src=" {{asset('source/assets/bootstrap/popper.min.js')}} "></script>
     <!-- Bootstrap Core JavaScript 4.1.3-->
     <script type="text/javascript" src="{{asset('source/assets/bootstrap/bootstrap.js ')}}"></script>
     <!-- myJS-->
     <script type="text/javascript" src="{{asset('source/assets/js/myQuery.js')}}"></script>
     <!-- ckeditor 5 nhap lieu -->
     {{-- <script type="text/javascript" src="{{asset('source/assets/ckeditor5/classic/ckeditor.js ')}}"></script> --}}
     <script type="text/javascript" src=" {{asset('source/assets/lazyLoad/jquery.lazy.min.js ')}} "></script>


    @yield('script')

</body>
</html>



