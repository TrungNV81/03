@extends('template')
@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="content" style="text-align: center">
        <h2>Setting time run batch and template mail</h2>
        <br>
        <form>
            <table class="table table-striped table-sm" style="width: 50%">
                <tbody>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Time </td>
                        <td> <input class="form-control" type="text" id="time" value="{{ $timeRunBatch->time }}"> </td>
                        <td>minutes</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-sm">
                <tbody>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Email subject </td>
                        <td colspan="2"> <input class="form-control" type="text" id="subject" value="{{ $templateEmail->subject }}"> </td>
                    </tr>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Recipient's name </td>
                        <td colspan="2"> <input class="form-control" type="text" id="receiver" value="{{ $templateEmail->receiver }}"> </td>
                    </tr>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Email body </td>
                        <td colspan="2">
                            <textarea style="min-height: 250px" class="form-control" id="body">{{ $templateEmail->body }}</textarea>
                        </td>
                    </tr>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Sender's name </td>
                        <td colspan="2"> <input class="form-control" type="text" id="sender" value="{{ $templateEmail->sender }}"> </td>
                    </tr>
                    <tr style="text-align: center"><td colspan="3"></td></tr>
                </tbody>
            </table>
        </form>
        <button class="btn btn-success" onclick="Update()">Update</button>
    </div>
</main>
@endsection