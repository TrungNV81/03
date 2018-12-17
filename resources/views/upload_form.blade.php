@extends('template')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Upload file</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table fa-fw"></i>Upload file
                </div>
                <!-- /.panel-heading -->
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <!-- Standar Form -->
                            <form action="{{ url('uploadSubmit') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <h5>Select files from your computer</h5>
                                <input type="file" id="fileInput" name="csv-file[]" required="true" multiple>
                                <h5>Or drag and drop files below</h5>
                                <div id="dropContainer" class="upload-drop-zone">
                                    Just drag and drop files here
                                </div>
                                <input type="submit" id="js-upload-submit" class="btn btn-success" value="Upload File">
                            </form>
                        </div>
                    </div>
                </div> <!-- /container -->
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
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
