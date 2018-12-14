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
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-table fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalFile}}</div>
                            <div>File Import</div>
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
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalSendMail}}</div>
                            <div>Send Mail</div>
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
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-edit fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalMail}}</div>
                            <div>Mail</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/manageMail') }}">
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
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i>History import file
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-1">
                        <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($historyFile as $data1)
                            <tr class="odd gradeX">
                                <td> {{ $data1->file_name }} </td>
                                <td> {{ $data1->created_at }} </td>
                                <td> {{ $data1->status }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i>History send mail
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-2">
                        <thead>
                        <tr>
                            <th>Receiver</th>
                            <th>File Zip</th>
                            <th>Date</th>
                            <th>Engine version</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($historySendMail as $data2)
                            <tr class="odd gradeX">
                                <td> {{ $data2->receiver }} </td>
                                <td> {{ $data2->file_zip }} </td>
                                <td> {{ $data2->created_at }} </td>
                                <td> {{ $data2->status }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
@endsection
