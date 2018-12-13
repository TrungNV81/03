@extends('template')
@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="content">
        <h2>Setting time run batch</h2>
        <br>
        <form action="{{url('setting')}}" method="POST" role="form">
        {{csrf_field()}}
            <table class="table table-striped table-sm" style="text-align: left; width: 50%; border: none !important;">
                <tbody>
                    <tr style="line-height: 35px;">
                        <td style="font-weight: bold"> Time </td>
                        <td> <input class="form-control" type="text" name="time" value="{{ $timeRunBatch->time }}"> </td>
                        <td>minutes</td>
                    </tr>
                    <tr style="text-align: center"><td colspan="3"><button type="submit" class="btn btn-success">Update</button></td></tr>
                </tbody>
            </table>
        </form>
    </div>
</main>
@endsection