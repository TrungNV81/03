@extends('template') @section('content')
<?php $i = 0?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Mail</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit fa-fw"></i>Manage Mail
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{url('add-mail')}}" method="POST">
                                {{ csrf_field() }}
                                    <label style="padding: 5px">Add new mail</label>
                                    <input style="display: inline-block; width: auto" class="form-control" type="email" name="new-email" value="">
                                    <button type="" class="btn btn-success">Add</button>
                                    @if($errors->has('new-email'))
                                        <p style="color:red">{{$errors->first('new-email')}}</p>
                                    @endif
                                </form>
                                <hr>
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-3">
                                    <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dataMail as $data)
                                        <tr class="odd gradeX">
                                            <td>
                                                <input class="form-control" type="email" name="mail{{ $data->id }}" value="{{ $data->email }}" id="email{{$i}}">
                                            </td>
                                            @if($data->status == '1')
                                            <td>
                                                <input class="form-control auto" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}" checked>
                                            </td>
                                            @else
                                            <td>
                                                <input class="form-control auto" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}">
                                            </td>
                                            @endif
                                            <td>
                                                <form action="{{ url('del-mail') }}" method="POST">
                                                {{ csrf_field() }}
                                                    <input hidden name="id-mail" value="{{ $data->id }}">
                                                    <button class="btn btn-danger center-block">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $i++ ?> @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <input hidden value="{{count($dataMail)}}" id="arrDataMail" />
                                <button style="float: right" type="submit" class="btn btn-success" onclick="updateMail()">Update</button>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

@endsection
