<div id="overload_upload"> </div>
@extends('template')
@section('content')
    <style>
        #loading {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 100000;
            width: 100vw;
            height: 100vh;
            background-color: rgba(192, 192, 192, 0.5);
            background-image: url("https://i.stack.imgur.com/MnyxU.gif");
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-upload fa-fw"></i> Upload file information</h1>
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
                    <div class="col-lg-12">
                        <div class="row">
                            <form action="{{ url('uploadFileInfomation') }}" id="upload_form" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                Choose your file xlsm:
                                <input type="file" name="file" id="fileInput" required="true">
                                <h5>Or drag and drop files below</h5>
                                <div id="dropContainer" class="upload-drop-zone">
                                    Just drag and drop files here
                                </div>
                            </form>
                            <button type="button" id="addbtn" class="btn btn-success pull-right">Add data</button>
                            <!-- /.col-lg-6 (nested) -->
                        </div>
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
    $(function () {
        dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
            evt.preventDefault();
        };
        dropContainer.ondrop = function (evt) {
            // pretty simple -- but not for IE :(
            fileInput.files = evt.dataTransfer.files;
            evt.preventDefault();
        };
    });
    var pullfiles = function () {
        // love the query selector
        var fileInput = document.querySelector("#fileInput");
        var files = fileInput.files;
        // cache files.length
        var fl = files.length;
        if (fl > 1) {
            setTimeout(function () {
                alert("Allow only a file to be uploaded, please select again. ");
            }, 0);
            location.replace("{{url ('upload-file')}}");
        }
    };
    // set the input element onchange to call pullfiles
    document.querySelector("#fileInput").onchange = pullfiles;
    
    function showLoader() {
        $("#overload_upload").attr("id","loading");
    }
    function hideLoader() {
        $("#loading").attr("id","overload_upload");
    }
    $("#addbtn").click(function(){
        showLoader();
        $.ajax({
            type: 'POST',
            beforeSend: function() {
                showLoader();
            },
            url: '{{ url("uploadFileInfomation") }}',
            data: new FormData($("#upload_form")[0]),
            async: true,
            processData: false,
            contentType: false,
            cache: false,
            complete: function(){
                hideLoader();
            },
            success: function (data){
                alert("Add data infomation success!");
            },
        });
    });
</script>

@endsection
