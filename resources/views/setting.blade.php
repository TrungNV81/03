@extends('template')
@section('content')
{{--<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">--}}
    {{--<div class="content" style="text-align: center">--}}
        {{--<h2>Setting time run batch and template mail</h2>--}}
        {{--<br>--}}
        {{--<form>--}}
            {{--<table class="table table-striped table-sm" style="width: 50%">--}}
                {{--<tbody>--}}
                    {{--<tr style="line-height: 35px;">--}}
                        {{--<td style="font-weight: bold"> Time </td>--}}
                        {{--<td> <input class="form-control" type="text" id="time" value="{{ $timeRunBatch->time }}" maxlength="4"></td>--}}
                        {{--<td>minutes</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td>--}}
                            {{--<p style="color:red;text-align:left;" hidden id="showError">Invalid (Time run batch: >=10 minutes, must be a number)</p>--}}
                        {{--</td>--}}
                        {{--<td></td>--}}
                    {{--</tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}
            {{--<table class="table table-sm">--}}
                {{--<tbody>--}}
                    {{--<tr style="line-height: 35px;">--}}
                        {{--<td style="font-weight: bold"> Email subject </td>--}}
                        {{--<td colspan="2"> <input class="form-control" type="text" id="subject" value="{{ $templateEmail->subject }}"> </td>--}}
                    {{--</tr>--}}
                    {{--<tr style="line-height: 35px;">--}}
                        {{--<td style="font-weight: bold"> Recipient's name </td>--}}
                        {{--<td colspan="2"> <input class="form-control" type="text" id="receiver" value="{{ $templateEmail->receiver }}"> </td>--}}
                    {{--</tr>--}}
                    {{--<tr style="line-height: 35px;">--}}
                        {{--<td style="font-weight: bold"> Email body </td>--}}
                        {{--<td colspan="2">--}}
                            {{--<textarea style="min-height: 250px" class="form-control" id="body">{{ $templateEmail->body }}</textarea>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr style="line-height: 35px;">--}}
                        {{--<td style="font-weight: bold"> Sender's name </td>--}}
                        {{--<td colspan="2"> <input class="form-control" type="text" id="sender" value="{{ $templateEmail->sender }}"> </td>--}}
                    {{--</tr>--}}
                    {{--<tr style="text-align: center"><td colspan="3"></td></tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--</form>--}}
        {{--<button class="btn btn-success" onclick="Update()">Update</button>--}}
    {{--</div>--}}
{{--</main>--}}

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-cogs"></i> Setting template mail</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-gear fa-fw"></i>Setting template mail
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form>
                                <table class="table table-striped table-sm" style="width: 50%">
                                    <tbody>
                                    <tr style="line-height: 35px;">
                                        <td style="font-weight: bold;vertical-align: middle"> Time run batch </td>
                                        <td> <input class="form-control" type="text" id="time" value="{{ $timeRunBatch->time }}" maxlength="4"></td>
                                        <td style="vertical-align: middle">minutes</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <p style="color:red;text-align:left;" hidden id="showError">Invalid (Time run batch: >=5 minutes, must be a number)</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <td class="form-email"> Email subject </td>
                                        <td class="border-top-none" colspan="2"> <input class="form-control" type="text" id="subject" value="{{ $templateEmail->subject }}"> </td>
                                    </tr>
                                    <tr>
                                        <td class="form-email"> Recipient's name </td>
                                        <td class="border-top-none" colspan="2"> <input class="form-control" type="text" id="receiver" value="{{ $templateEmail->receiver }}"> </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top: none;text-align: right;font-weight: bold;vertical-align: top"> Email body </td>
                                        <td class="border-top-none" colspan="2">
                                            <textarea style="min-height: 250px" class="form-control" id="body">{{ $templateEmail->body }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="form-email"> Sender's name </td>
                                        <td class="border-top-none" colspan="2"> <input class="form-control" type="text" id="sender" value="{{ $templateEmail->sender }}"> </td>
                                    </tr>
                                    {{--<tr style="text-align: center"><td colspan="3"></td></tr>--}}
                                    </tbody>
                                </table>
                            </form>
                            <hr>
                            <button style="float: right" class="btn btn-success" onclick="Update()">Update</button>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
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
