@extends('template') @section('content')
<?php $i = 0?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class=" content" style="text-align:center;">
        <form>
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="text-align: center">
                    <h2 style="text-align: center">Manage Mail</h2>
                    <table class="table table-striped table-bordered table-sm">
                        <tbody>
                            <tr style="text-align:center; background: linear-gradient(to bottom, #FFB88C, #DE6262);">
                                <td> Email </td>
                                <td> Status </td>
                            </tr>
                            @foreach ($dataMail as $data)
                            <tr>
                                <td>
                                    <input class="form-control" type="text" name="mail{{ $data->id }}" value="{{ $data->email }}" id="email{{$i}}">
                                </td>
                                @if($data->status == '1')
                                <td>
                                    <input class="form-control" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}" checked>
                                </td>
                                @else
                                <td>
                                    <input class="form-control" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}">
                                </td>
                                @endif
                            </tr>
                            <?php $i++ ?> @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <input hidden value="{{count($dataMail)}}" id="arrDataMail" />
        <button class="btn btn-success" onclick="UpdateMail()"> Update </button>
    </div>
</main>
@endsection
