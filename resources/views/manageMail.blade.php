@extends('template')
@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <form name="manageMail" action="{{ url('edit-mail') }}" method="POST">
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
                                <input class="form-control" type="text" name="mail{{ $data->id }}" value="{{ $data->email }}">
                            </td>
                            @if($data->status == '1')
                            <td>
                                <input class="form-control" type="checkbox" name="status{{ $data->id }}"
                                 value="{{ $data->status }}" class="form-check-input" checked>
                            </td>
                            @else
                            <td>
                                <input class="form-control" type="checkbox" name="status{{ $data->id }}"
                                 value="{{ $data->status }}" class="form-check-input">
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </div>
    </form>
</main>
@endsection