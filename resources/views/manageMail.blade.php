@extends('template') @section('content')
<?php $i = 0?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-cogs"></i> Manage Mail</h1>
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
                                <form action="{{ url('add-group') }}" method="POST">
                                {{ csrf_field() }}
                                    <label style="padding: 5px">Add group mail</label>
                                    <input style="display: inline-block; width: auto" class="form-control" type="text" name="group-email" value="">
                                    <button type="" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Add</button>
                                    @if($errors->has('new-email'))
                                        <p style="color:red">{{$errors->first('new-email')}}</p>
                                    @endif
                                </form>
                                <br>
                                <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>City</th>
                                        <th>View Group</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataGroupMail as $dataGroup)
                                        <form action="{{ url('manageMail') }}" method="GET">
                                            <tr>
                                                <th>{{ $dataGroup->name }}</th>
                                                <td>
                                                    <input type="hidden" value="{{ $dataGroup->id }}" name="id_group">
                                                    <button type="submit" class="btn btn-warning"><i class="fa fa-eye fa-fw"></i>  View mail in group</button>
                                                </td>
                                            </tr>
                                        </form>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                @if($id_group)
                                <div>
                                @if(count($dataMail) > 0)
                                        <form action="{{url('add-mail')}}" method="POST">
                                            {{ csrf_field() }}
                                            <label style="padding: 5px">Add new mail</label>
                                            <input style="display: inline-block; width: auto" class="form-control" type="email" name="new-email" value="">
                                            <input hidden value="{{ $id_group }}" id="id_group" name="id_group" />
                                            <button type="" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Add</button>
                                            @if($errors->has('new-email'))
                                                <p style="color:red">{{$errors->first('new-email')}}</p>
                                            @endif
                                        </form>
                                        <br>
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
                                                        <input hidden value="{{ $id_group }}" name="id_group" />
                                                        <button class="btn btn-danger center-block"><i class="fa fa-trash-o fa-fw"></i>  Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php $i++ ?> @endforeach
                                        </tbody>
                                    </table>
                                    <hr>
                                    @endif
                                    <input hidden value="{{ count($dataMail) }}" id="arrDataMail" />
                                    <button style="float: right" type="submit" class="btn btn-success" onclick="updateMail()">Update</button>
                                </div>
                                @endif
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
