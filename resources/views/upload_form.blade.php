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
                            <form action="{{ url('uploadFile') }}" class="dropzone" id="upload-file-form" name="upload-file-form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            </form><br><br>
                            <button type="submit" class="btn btn-success pull-right" id="btnUpload">Upload</button>
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

<script type="text/javascript">
    Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone('#upload-file-form', {
            // paramName: "files",
            url: './uploadFile',
            method: 'POST',
            maxFilesize: 25, 
            maxFiles: 12,
            parallelUploads: 12,
            uploadMultiple: false,
            autoProcessQueue: false,
            acceptedFiles: ".csv",
            addRemoveLinks: true,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    type: 'POST',
                    url: '{{ url("deleteFile") }}',
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {filename: name},
                    success: function (data){
                        alert("File has been successfully removed!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
        });
        $('#btnUpload').on('click', function(){
            myDropzone.processQueue();
        });
</script>
@endsection
