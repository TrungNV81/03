@extends('template')
@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="content">
        <h2>History import file</h2>
        <table class="table table-striped table-bordered table-sm">
            <tbody>
                <tr style="text-align:center; background: linear-gradient(to bottom, #FFB88C, #DE6262);">
                    <td> File Name </td>
                    <td> Date </td>
                    <td> Status </td>
                </tr>
                @foreach ($historyFile as $data)
                <tr>
                    <td> {{ $data->file_name }} </td>
                    <td> {{ $data->created_at }} </td>
                    <td> {{ $data->status }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection