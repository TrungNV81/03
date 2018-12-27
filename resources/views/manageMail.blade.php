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
                                <form action="{{ url('add-group-mail') }}" method="POST">
                                {{ csrf_field() }}
                                    <label style="padding: 5px">Add group mail</label>
                                    <input style="display: inline-block; width: auto" class="form-control" type="text" name="group-email" value="">
                                    <button type="" class="btn btn-success"><i class="fa fa-plus-circle fa-fw"></i> Add</button>
                                    @if($errors->has('group-email'))
                                        <p style="color:red">{{ $errors->first('group-email') }}</p>
                                    @endif
                                </form>
                                <hr>
                                <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Group Mail</th>
                                    <th>Edit Group</th>
                                    <th>View Group</th>
                                    <th>Delete Group</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataGroupMail as $dataGroup)
                                    <tr>
                                        <form action="{{ url('edit-group-mail') }}" method="POST">
                                        {{ csrf_field() }}
                                        <th>
                                            <input style="display: inline-block; width: 100%" class="form-control" type="text" 
                                                    value="{{ $dataGroup->name }}" name="name_group">
                                        </th>
                                        <td>
                                            <input hidden name="id_group" value="{{ $dataGroup->id }}">
                                            <button class="btn btn-success center-block"> <i class="glyphicon glyphicon-refresh"></i> Update</button>
                                        </td>
                                        </form>
                                        <td>
                                            <button type="" class="btn btn-warning center-block" onclick="viewMail({{ $dataGroup->id }})" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye fa-fw"></i> View mail</button>
                                        </td>
                                        <td>
                                        <form action="{{ url('del-group-mail') }}" method="POST" id="form_upload{{ $dataGroup->id }}">
                                            {{ csrf_field() }}
                                                <input hidden name="id-group" value="{{ $dataGroup->id }}">
                                            </form>
                                            <button type="button" onclick="ConfirmDelete({{ $dataGroup->id }})" class="btn btn-danger center-block"> <i class="fa fa-trash-o fa-fw"></i> Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                
                                {{-- @endif --}}
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
	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div>
			<div id="data-mail"></div><br>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
