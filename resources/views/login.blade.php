<!DOCTYPE html>
<html lang="en">
<head>
    <title>STSekisanCenter</title>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
{{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>--}}

<!-- Bootstrap Core CSS -->
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{ asset('/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('/morrisjs/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{URL::asset('/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{URL::asset('/metisMenu/metisMenu.min.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{URL::asset('/raphael/raphael.min.js')}}"></script>
    <script src="{{URL::asset('/morrisjs/morris.min.js')}}"></script>
    <script src="{{URL::asset('/data/morris-data.js')}}"></script>

    <!-- DataTables JavaScript -->
    <script src="{{URL::asset('/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('/datatables-responsive/dataTables.responsive.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{URL::asset('/dist/js/sb-admin-2.js')}}"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example-1').DataTable({
                responsive: true,
                "order": [[ 1, "desc" ]]
            });
            $('#dataTables-example-2').DataTable({
                responsive: true,
                "order": [[ 2, "desc" ]]
            });
        });
        $(document).ready(function() {
            $('#dataTables-example-3').DataTable( {
                "ordering": false,
                "columns": [
                    { "orderDataType": "dom-text", type: 'email' },
                    { "orderDataType": "dom-checkbox", type: 'checkbox' },
                    null
                ]
            } );
        } );
    </script>

    <script src="{{URL::asset('/js/managemail.js')}}"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="{{URL::asset('/js/setting.js')}}"></script>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
</head>
<body id="login">
{{--<section class="login-block">--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-4 login-sec">--}}
                {{--<h2 class="text-center">LOGIN</h2>--}}
                {{--<form action="{{url('login')}}" method="POST" role="form" class="login-form">--}}
                    {{--@if($errors->has('errorlogin'))--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
                            {{--{{$errors->first('errorlogin')}}--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleInputEmail1" class="text-uppercase">Username</label>--}}
                        {{--<!-- <input type="text" class="form-control" id="email" placeholder="Email" name="email"--}}
                               {{--value="{{old('email')}}"> -->--}}
                            {{--<input type="text" class="form-control" id="email" placeholder="Email" name="email"--}}
                               {{--value="admin">--}}
                        {{--@if($errors->has('email'))--}}
                            {{--<p style="color:red">{{$errors->first('email')}}</p>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleInputPassword1" class="text-uppercase">Password</label>--}}
                        {{--<input type="password" class="form-control" id="password" placeholder="Password"--}}
                               {{--name="password" value="123456">--}}
                        {{--@if($errors->has('password'))--}}
                            {{--<p style="color:red">{{$errors->first('password')}}</p>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="form-check">--}}
                        {{--<label class="form-check-label">--}}
                            {{--<input type="checkbox" class="form-check-input">--}}
                            {{--<small>Remember Me</small>--}}
                        {{--</label>--}}
                        {{--{!! csrf_field() !!}--}}
                        {{--<button type="submit" class="btn btn-login float-right">Login</button>--}}
                    {{--</div>--}}

                {{--</form>--}}
            {{--</div>--}}
            {{--<div class="col-md-8 banner-sec">--}}
                {{--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">--}}
                    {{--<ol class="carousel-indicators">--}}
                        {{--<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
                        {{--<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
                        {{--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
                    {{--</ol>--}}
                    {{--<div class="carousel-inner" role="listbox">--}}
                        {{--<div class="carousel-item active">--}}
                            {{--<img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg"--}}
                                 {{--alt="First slide">--}}
                            {{--<div class="carousel-caption d-none d-md-block">--}}
                                {{--<div class="banner-text">--}}
                                    {{--<h2>This is Heaven</h2>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor--}}
                                        {{--incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis--}}
                                        {{--nostrud exercitation</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="carousel-item">--}}
                            {{--<img class="d-block img-fluid"--}}
                                 {{--src="https://images.pexels.com/photos/7097/people-coffee-tea-meeting.jpg"--}}
                                 {{--alt="First slide">--}}
                            {{--<div class="carousel-caption d-none d-md-block">--}}
                                {{--<div class="banner-text">--}}
                                    {{--<h2>This is Heaven</h2>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor--}}
                                        {{--incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis--}}
                                        {{--nostrud exercitation</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="carousel-item">--}}
                            {{--<img class="d-block img-fluid"--}}
                                 {{--src="https://images.pexels.com/photos/872957/pexels-photo-872957.jpeg"--}}
                                 {{--alt="First slide">--}}
                            {{--<div class="carousel-caption d-none d-md-block">--}}
                                {{--<div class="banner-text">--}}
                                    {{--<h2>This is Heaven</h2>--}}
                                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor--}}
                                        {{--incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis--}}
                                        {{--nostrud exercitation</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</section>--}}

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <H2 class="logo">STSekisanCenter</H2>
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">LOGIN</h3>
                </div>
                <div class="panel-body">
                    <form action="{{url('login')}}" method="POST" role="form" class="login-form">
                        @if($errors->has('errorlogin'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{$errors->first('errorlogin')}}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="text-uppercase">Username</label>
                        <!-- <input type="text" class="form-control" id="email" placeholder="Email" name="email"
                               value="{{old('email')}}"> -->
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email"
                                   value="admin">
                            @if($errors->has('email'))
                                <p style="color:red">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                   name="password" value="">
                            @if($errors->has('password'))
                                <p style="color:red">{{$errors->first('password')}}</p>
                            @endif
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input">
                                <small>Remember Me</small>
                            </label>
                            {!! csrf_field() !!}
                            <button style="float: right" type="submit" class="btn btn-login btn-warning">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
