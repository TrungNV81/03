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
                        <div class="col-lg-12">
                            <!-- Standar Form -->
                            <form action="{{ url('uploadFile') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <h5>Select files from your computer</h5>
                                <input type="file" id="fileInput" name="csv-file[]" required="true" multiple>
                                <h5>Or drag and drop files below</h5>
                                <div id="dropContainer" class="upload-drop-zone">
                                    Just drag and drop files here
                                </div>
                                <hr>
                                <input style="float: right" type="submit" id="js-upload-submit" class="btn btn-success" value="Upload File">
                            </form>
                        </div>
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


<script>
    $(function () {
        dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
            evt.preventDefault();
        };
        dropContainer.ondrop = function(evt) {
            // pretty simple -- but not for IE :(
            fileInput.files = evt.dataTransfer.files;
            evt.preventDefault();
        };
    })
</script>
@endsection
