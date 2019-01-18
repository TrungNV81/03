@extends('template')
@section('content')

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
                    <div class="row">
                        <form action="{{ url('uploadFileConfig') }}" id="upload_form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            Choose your xlsm: <input type="file" name="file" class="form-control">
                        </form>
                        <button type="button" id="addbtn" class="btn btn-primary btn-lg" style="margin-top: 3%">Add data</button>
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
$("#addbtn").click(function(){
    $.ajax({
        type: 'POST',
        url: '{{ url("uploadFileConfig") }}',
        data: new FormData($("#upload_form")[0]),
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        complete: function(){
            
        },
        success: function (data){
            alert("Add data infomation success!");
        },
    });
});
</script>

@endsection
