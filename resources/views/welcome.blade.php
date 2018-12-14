@extends('template')
@section('content')
{{--<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">--}}
    {{--<div class="content">--}}
        {{--<h1 class="welcome">Welcome to STSekisanCenter</h1>--}}
        {{--<img src="{{ asset('image/STSekisanCenter.jpg') }}" class="img" alt="STSekisanCenter" >--}}
    {{--</div>--}}
{{--</main>--}}

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Welcome to STSekisanCenter</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <img src="{{ asset('image/STSekisanCenter.jpg') }}" class="img img-responsive" alt="STSekisanCenter" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
@endsection
