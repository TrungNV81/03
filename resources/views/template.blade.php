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
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <span class="logo-text">STExcelExport</span>
            </a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messenger">
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i>Sign out</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-table fa-fw"></i> Manage History<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('/historyFile') }}"><i class="fa fa-history"></i> History import file</a>
                            </li>
                            <li>
                                <a href="{{ url('/historySendMail') }}"><i class="fa fa-history"></i> History send mail</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-envelope-o fa-fw"></i> Setting Mail<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('/manageMail') }}"><i class="fa fa-cogs"></i> Manage mail</a>
                            </li>
                            <li>
                                <a href="{{ url('/templateMail') }}"><i class="fa fa-cogs"></i> Template mail</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="{{ url('/uploadFile') }}"><i class="fa fa-upload fa-fw"></i> Upload File Server</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    @yield('content')
</div>
</body>
</html>
