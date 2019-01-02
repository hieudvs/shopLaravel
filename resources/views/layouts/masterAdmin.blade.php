<!DOCTYPE html>
<html lang="en"><head>
	<title> Owen admin 2.0 </title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <base href="asset"> --}}
    <link rel="stylesheet" href="{{asset('source/assets/bootstrap/bootstrap.css ')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

     <!-- DataTables CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('source/assets/css/dashboard.css ')}}">



</head>
<body >
    @include('admin.header')
    @yield('content')
    @include('admin.footer')

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

     <!-- DataTables JavaScript -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    @yield('script')

</body>
</html>



