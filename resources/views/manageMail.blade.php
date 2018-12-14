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
                                <form>
                                    {{ csrf_field() }}
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example-3">
                                        <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dataMail as $data)
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input class="form-control" type="text" name="mail{{ $data->id }}" value="{{ $data->email }}" id="email{{$i}}">
                                                </td>
                                                @if($data->status == '1')
                                                    <td>
                                                        <input style="height: auto" class="form-control" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}" checked>
                                                    </td>
                                                @else
                                                    <td>
                                                        <input style="height: auto" class="form-control" type="checkbox" name="status{{ $data->id }}" class="form-check-input" id="status{{$i}}">
                                                    </td>
                                                @endif
                                            </tr>
                                            <?php $i++ ?> @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                <input hidden value="{{count($dataMail)}}" id="arrDataMail" />
                                <button type="submit" class="btn btn-success"  onclick="UpdateMail()">Update</button>
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
