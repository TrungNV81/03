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
                {{--@foreach ($historySendMail as $data)--}}
                {{--<tr>--}}
                    {{--<td> {{ $data->receiver }} </td>--}}
                    {{--<td> {{ $data->file_zip }} </td>--}}
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
            <h1 class="page-header">History send mail</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    History send mail
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
                        @foreach ($historySendMail as $data)
                            <tr  class="odd gradeX">
                                <td> {{ $data->receiver }} </td>
                                <td> {{ $data->file_zip }} </td>
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
<!-- /#page-wrapper -->
@endsection
