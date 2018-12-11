@extends('template')
@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="content">
        <h2>Manage Mail</h2>
        <table class="table table-striped table-bordered table-sm">
            <tbody>
                <tr style="text-align:center; background: linear-gradient(to bottom, #FFB88C, #DE6262);">
                    <td width=7%> id </td>
                    <td> email </td>
                    <td> Status </td>
                </tr>
                @foreach ($dataMail as $data)
                <tr>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $data->id }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $data->email }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $data->status }}">
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-success">Update</button>
    </div>
</main>
@endsection