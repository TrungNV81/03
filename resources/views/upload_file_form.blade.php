@extends('template')
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-upload fa-fw"></i> Upload file server</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-upload fa-fw"></i>Upload file
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        {{-- <div class="col-lg-12">
                            <form action="{{ url('uploadFile') }}" class="dropzone" id="upload-file-form" name="upload-file-form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            </form><br><br>
                            <button type="submit" class="btn btn-success pull-right" id="btnUpload">Upload</button>
                        </div> --}}
                        <form action="{{ url('uploadFileConfig') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            Choose your xls/csv File : <input type="file" name="file" class="form-control">
                         
                            <input type="submit" class="btn btn-primary btn-lg" style="margin-top: 3%">
                        </form>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>

@endsection
