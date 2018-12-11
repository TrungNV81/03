<!DOCTYPE html>
<html lang="en">
<head>
    <title>STSekisanCenter</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
</head>
<body>
<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-md-4 login-sec">
                <h2 class="text-center">LOGIN</h2>
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
                               name="password" value="123456">
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
                        <button type="submit" class="btn btn-login float-right">Login</button>
                    </div>

                </form>
            </div>
            <div class="col-md-8 banner-sec">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg"
                                 alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-text">
                                    <h2>This is Heaven</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                                 src="https://images.pexels.com/photos/7097/people-coffee-tea-meeting.jpg"
                                 alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-text">
                                    <h2>This is Heaven</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                                 src="https://images.pexels.com/photos/872957/pexels-photo-872957.jpeg"
                                 alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-text">
                                    <h2>This is Heaven</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>