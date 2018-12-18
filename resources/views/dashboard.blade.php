@extends('template')
@section('content')
{{--<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">--}}
    {{--<div class="content">--}}
        {{--<h2>History send mail</h2>--}}
        {{--<table class="table table-striped table-bordered table-sm">--}}
            {{--<tbody>--}}
            {{--<tr style="text-align:center; background: linear-gradient(to bottom, #FFB88C, #DE6262);">--}}
                {{--<td> Receiver </td>--}}
                {{--<td> File Zip </td>--}}
                {{--<td> Date </td>--}}
                {{--<td> Status </td>--}}
            {{--</tr>--}}
            {{--@foreach ($historySendMail as $data1)--}}
                {{--<tr>--}}
                    {{--<td> {{ $data1->receiver }} </td>--}}
                    {{--<td> {{ $data1->file_zip }} </td>--}}
                    {{--<td> {{ $data1->created_at }} </td>--}}
                    {{--<td> {{ $data1->status }} </td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
{{--</main>--}}
{{--<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">--}}
    {{--<div class="content">--}}
        {{--<h2>History import file</h2>--}}
        {{--<table class="table table-striped table-bordered table-sm">--}}
            {{--<tbody>--}}
            {{--<tr style="text-align:center; background: linear-gradient(to bottom, #FFB88C, #DE6262);">--}}
                {{--<td> File Name </td>--}}
                {{--<td> Date </td>--}}
                {{--<td> Status </td>--}}
            {{--</tr>--}}
            {{--@foreach ($historyFile as $data2)--}}
                {{--<tr>--}}
                    {{--<td> {{ $data2->file_name }} </td>--}}
                    {{--<td> {{ $data2->created_at }} </td>--}}
                    {{--<td> {{ $data2->status }} </td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
{{--</main>--}}
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i> Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-table fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalSuccessFile}}</div>
                            <div>File Import Success</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/historyFile') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalSuccessSendMail}}</div>
                            <div>Send Mail Success</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/historySendMail') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Line Chart
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Day</a>
                                </li>
                                <li><a href="#">Week</a>
                                </li>
                                <li><a href="#">Month</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-line-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Notifications Panel
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-calendar fa-fw"></i> Last Import File
                            <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-file fa-fw"></i> File Import Today
                            <span class="pull-right text-muted small"><em>30 files</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-envelope fa-fw"></i> Total Email Edit
                            <span class="pull-right text-muted small"><em>40 files</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-desktop fa-fw"></i> Last Login
                            <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                            <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-warning fa-fw"></i> Server Not Responding
                            <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                        </a>
                    </div>
                    <!-- /.list-group -->
                    <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
</div>
<script>
    $(function() {
        Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'morris-line-chart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [
                { y: '2014', a: 50, b: 90},
                { y: '2015', a: 65,  b: 75},
                { y: '2016', a: 50,  b: 50},
                { y: '2017', a: 75,  b: 60},
                { y: '2018', a: 80,  b: 65},
                { y: '2019', a: 90,  b: 70},
                { y: '2020', a: 100, b: 75},
                { y: '2021', a: 115, b: 75},
                { y: '2022', a: 120, b: 85},
                { y: '2023', a: 145, b: 85},
                { y: '2024', a: 160, b: 95}
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Total Success', 'Total Fail'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['gray','red']
        });
    });
</script>

<!-- /#page-wrapper -->
@endsection
