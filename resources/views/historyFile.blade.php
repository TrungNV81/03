@extends('template')
@section('content')
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
                {{--@foreach ($historyFile as $data)--}}
                {{--<tr>--}}
                    {{--<td> {{ $data->file_name }} </td>--}}
                    {{--<td> {{ $data->created_at }} </td>--}}
                    {{--<td> {{ $data->status }} </td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
{{--</main>--}}
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">History import file</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    History import file
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-1">
                        <thead>
                        <tr>
                            <td>File Name</td>
                            <td>Date</td>
                            <td>Status</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($historyFile as $data)
                            <tr  class="odd gradeX">
                                <td> {{ $data->file_name }} </td>
                                <td> {{ $data->created_at }} </td>
                                <td> {{ $data->status }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
@endsection
