<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>xxx</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:103,600" rel="stylesheet" type="text/css">
    <title>Document</title>
    <style>
        body {
            width: 100%;
            font-weight: bold !important;
            font-family: Meiryo !important;
            padding: 0% !important;
            margin: 0% !important;
        }

        .title-heading {
            font-size: 64px;
            text-align: center;
        }

        .location {
            font-size: 40px;
            margin-left: 25%;
        }

        .house {
            float: right;
            height: 55px;
            font-size: 40px;
            line-height: 37px;
            position: absolute;
            top: 24%;
        }

        .content {}

        .content {
            clear: both;
        }

        .content>* {
            text-align: center;
            border: 7px solid black;
            font-size: 28px;
        }

        .content>*>label {}

        .content .td2_1 {
            float: left;
            width: 30%;
            font-size: 80px;
            line-height: 80px;
            padding: 0px !important;
            margin: 0px !important;
        }

        .content .td2_2 {
            float: right;
            width: 50%;
            font-size: 64px;
            line-height: 65px;
            text-align: center;
        }

        .floor {
            color: white;
            background: black;
            font-size: 45px;
            width: 100px;
            height: 100px;
            margin-top: 70px;
            text-align: center;
            position: absolute;
            top: 52%;
            line-height: 30px;
            display: block;
        }

        .floor>span {
            position: absolute;
            top: 10%;
            left: 20%;
            display: block;
        }

        .name-house {
            position: absolute;
            top: 60%;
        }

        .name-house-up {
            position: absolute;
            font-size: 45px;
            display: block;
        }

        .product {
            font-size: 80px;
            width: 100px;
        }

        .warning {
            position: absolute;
            top: 70%;
            float: left;
            font-size: 40px;
            display: block;
        }

        .here {
            position: absolute;
            top: 60%;
            float: right;
            font-size: 40px;
            display: block;
        }

        .here>span {
            font-size: 70px !important;
        }
    </style>
</head>

<body>
    {{-- @for($i = 0 ;$i < 6; $i ++) --}}
    <div style="page-break-inside:avoid;">
        <div class="title-heading">
            {{ $dataPDF[0]->billing_name }}
        </div>
        <div class="location">
            {{ $dataPDF[0]->property_name }}
        </div>
        <div class="house">様邸</div>
        <div class="content">
            <div class="td2_1 ">
                <label>先行壁</label>
            </div>
            <div class="td2_2">
                <label>{{ $dataPDF[0]->request_no1 }}-{{ $dataPDF[0]->request_no2 }}-①</label>
            </div>
        </div>
        <div class="floor">
            <span>1F</span>
        </div>
        <div class="name-house">
            <span class="product">{{ $dataPDF[0]->delivery_time_1 }} 積</span>
            <span class=" name-house-up">この邸名は</span>
        </div>
        <div class="">
            <label class="warning">※原板は含まれていません</label>
            <label class="here"><span>⼭</span>　あります</label>
        </div>
    </div>
    {{-- @endfor --}}
</body>

</html>