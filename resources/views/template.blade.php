<!DOCTYPE html>
<html lang="en">
<head>
    <title>STSekisanCenter</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="{{URL::asset('/js/managemail.js')}}"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="{{URL::asset('/js/setting.js')}}"></script>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
</head>
<body>
<nav class="navbar navbar-default sticky-top flex-md-nowrap p-0 bg-light">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('') }}">STExcelExport</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{ url('/logout') }}" style="color: #777">Sign out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa fa-wrench fa-fw"></i>
                                Manage history
                            </a>
                            <ul class="dropdown-content">
                                <a class="nav-link" href="{{ url('/historyFile') }}">
                                    <i class="fa fa-user fa-fw"></i>
                                    History file
                                </a>
                                <a class="nav-link" href="{{ url('/historySendMail') }}">
                                    <i class="fa fa-users fa-fw"></i>
                                    History send mail
                                </a>
                            </ul>
                        </li>
                    <li class="nav-item hover">
                        <a class="nav-link" href="{{ url('/manageMail') }}">
                            <i class="fa fa-files-o fa-fw"></i>
                            Manage mail
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/setting') }}">
                            <i class="fa fa-wrench fa-fw"></i>
                            Setting
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        @yield('content')
    </div>
</div>
</body>
</html>