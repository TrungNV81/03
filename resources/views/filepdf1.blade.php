<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$filename}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:103,600" rel="stylesheet" type="text/css">

    <style type="text/css">
        body {
            font-family: Meiryo !important;
            padding: 0px !important;
            margin: 0px !important;
        }

        div.breakNow {
            page-break-inside: avoid !important;
            page-break-after: always !important;
        }

        .circle {
            background: rgb(0, 217, 255);
            text-align: center !important;
            border-radius: 10px;
            height: 20px;
            width: 20px;
            position: absolute !important;
            font-size: 11px;
            display: inline-block;
            padding: 0px !important;
            margin: 0px !important;
            line-height: 10px;
            margin-top: 5px !important;
        }

        td {
            line-height: 15px;
            height: 20px;
        }

        table {
            border-spacing: 0px;
        }

        .circle2 {
            background: rgb(255, 77, 77);
            text-align: center !important;
            border-radius: 10px;
            height: 20px;
            width: 20px;
            position: absolute !important;
            font-size: 11px;
            display: inline-block;
            padding: 0px !important;
            margin: 0px !important;
            line-height: 10px;
            margin-top: 5px !important;
        }

        .td1 {
            text-align: right;
            font-size: 10px;
            width: 13% !important;
        }

        .td2 {
            text-align: right;
            font-size: 17px;
            width: 5% !important;
            padding-right: 8px !important;
            padding-bottom: 4px !important;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                <?php 
                    $page = (int)(count($dataPDF)/76);
                    // echo $page;
                ?> @if($page >0) @for ($j = 0; $j
                < $page; $j++) @if($j*76 < count($dataPDF)) <div style="text-align: center;">{{ $filename }}</div>
            <table style="page-break-after:always;width: 103%;">
                @for ($i = $j*76; $i
                < ($j + 1)*76; $i+=4) <tr style="width: 103%;">
                    @if ($i
                    < count($dataPDF)) @if($dataPDF[$i]->B == '1階')
                        <td>
                            <span class="circle" style="">
                                <b>1F</b>
                            </span>
                        </td>
                        @else
                        <td>
                            <span class="circle2" style="">
                                <b>2F</b>
                            </span>
                        </td>
                        @endif @if($dataPDF[$i]->K == 'マーク付きベベル')
                        <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}]マーク </td>
                        @elseif($dataPDF[$i]->K == '耐水ベベル')
                        <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}]耐水 </td>
                        @else
                        <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}] {{ $dataPDF[$i]->K}} </td>
                        @endif
                        <td>&nbsp;&nbsp;</td>
                        <td class="td2">{{ $dataPDF[$i]->M}}x{{ $dataPDF[$i]->N}}</td>

                        @endif @if ($i
                        < count($dataPDF) -1) @if($dataPDF[$i]->B == '1階')
                            <td>
                                <span class="circle" style="">
                                    <b>1F</b>
                                </span>
                            </td>
                            @else
                            <td>
                                <span class="circle2" style="">
                                    <b>2F</b>
                                </span>
                            </td>
                            @endif @if($dataPDF[$i + 1]->K == 'マーク付きベベル')
                            <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}]マーク </td>
                            @elseif($dataPDF[$i + 1]->K == '耐水ベベル')
                            <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}]耐水 </td>
                            @else
                            <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}] {{ $dataPDF[$i + 1]->K}} </td>
                            @endif
                            <td>&nbsp;&nbsp;</td>
                            <td class="td2">{{ $dataPDF[$i + 1]->M}}x{{ $dataPDF[$i + 1]->N}}</td>

                            @endif @if ($i
                            < count($dataPDF) -2) @if($dataPDF[$i]->B == '1階')
                                <td>
                                    <span class="circle" style="">
                                        <b>1F</b>
                                    </span>
                                </td>
                                @else
                                <td>
                                    <span class="circle2" style="">
                                        <b>2F</b>
                                    </span>
                                </td>
                                @endif @if($dataPDF[$i + 2]->K == 'マーク付きベベル')
                                <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}]マーク </td>
                                @elseif($dataPDF[$i + 2]->K == '耐水ベベル')
                                <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}]耐水 </td>
                                @else
                                <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}] {{ $dataPDF[$i + 2]->K}} </td>
                                @endif

                                <td>&nbsp;&nbsp;</td>
                                <td class="td2">{{ $dataPDF[$i + 2]->M}}x{{ $dataPDF[$i + 2]->N}}</td>

                                @endif @if ($i
                                < count($dataPDF) - 3) @if($dataPDF[$i]->B == '1階')
                                    <td>
                                        <span class="circle" style="">
                                            <b>1F</b>
                                        </span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="circle2" style="">
                                            <b>2F</b>
                                        </span>
                                    </td>
                                    @endif @if($dataPDF[$i + 3]->K == 'マーク付きベベル')
                                    <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}]マーク </td>
                                    @elseif($dataPDF[$i + 3]->K == '耐水ベベル')
                                    <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}]耐水 </td>
                                    @else
                                    <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}] {{ $dataPDF[$i + 3]->K}} </td>
                                    @endif
                                    <td>&nbsp;&nbsp;</td>
                                    <td class="td2">{{ $dataPDF[$i + 3]->M}}x{{ $dataPDF[$i + 3]->N}}</td>

                                    @endif
                                    </tr>
                                    @endfor
            </table>
            <!-- @endif -->
            @endfor @endif @if(($page * 76
            < count($dataPDF)) || $page==0 ) <div style="text-align: center;">{{ $filename }}</div>
        <table style="width: 103%;">
            @for ($i = $page * 76; $i
            < count($dataPDF); $i+=4) <tr style="width: 103%;">
                @if ($i
                < count($dataPDF)) @if($dataPDF[$i]->B == '1階')
                    <td>
                        <span class="circle" style="">
                            <b>1F</b>
                        </span>
                    </td>
                    @else
                    <td>
                        <span class="circle2" style="">
                            <b>2F</b>
                        </span>
                    </td>
                    @endif @if($dataPDF[$i]->K == 'マーク付きベベル')
                    <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}]マーク </td>
                    @elseif($dataPDF[$i]->K == '耐水ベベル')
                    <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}]耐水 </td>
                    @else
                    <td class="td1">{{ $dataPDF[$i]->C }} [{{ $dataPDF[$i]->J}}] {{ $dataPDF[$i]->K}} </td>
                    @endif
                    <td>&nbsp;&nbsp;</td>
                    <td class="td2">{{ $dataPDF[$i]->M}}x{{ $dataPDF[$i]->N}}</td>

                    @endif @if ($i
                    < count($dataPDF) -1) @if($dataPDF[$i]->B == '1階')
                        <td>
                            <span class="circle" style="">
                                <b>1F</b>
                            </span>
                        </td>
                        @else
                        <td>
                            <span class="circle2" style="">
                                <b>2F</b>
                            </span>
                        </td>
                        @endif @if($dataPDF[$i + 1]->K == 'マーク付きベベル')
                        <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}]マーク </td>
                        @elseif($dataPDF[$i + 1]->K == '耐水ベベル')
                        <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}]耐水 </td>
                        @else
                        <td class="td1">{{ $dataPDF[$i + 1]->C }} [{{ $dataPDF[$i + 1]->J}}] {{ $dataPDF[$i + 1]->K}} </td>
                        @endif
                        <td>&nbsp;&nbsp;</td>
                        <td class="td2">{{ $dataPDF[$i + 1]->M}}x{{ $dataPDF[$i + 1]->N}}</td>

                        @endif @if ($i
                        < count($dataPDF) -2) @if($dataPDF[$i]->B == '1階')
                            <td>
                                <span class="circle" style="">
                                    <b>1F</b>
                                </span>
                            </td>
                            @else
                            <td>
                                <span class="circle2" style="">
                                    <b>2F</b>
                                </span>
                            </td>
                            @endif @if($dataPDF[$i + 2]->K == 'マーク付きベベル')
                            <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}]マーク </td>
                            @elseif($dataPDF[$i + 2]->K == '耐水ベベル')
                            <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}]耐水 </td>
                            @else
                            <td class="td1">{{ $dataPDF[$i + 2]->C }} [{{ $dataPDF[$i + 2]->J}}] {{ $dataPDF[$i + 2]->K}} </td>
                            @endif

                            <td>&nbsp;&nbsp;</td>
                            <td class="td2">{{ $dataPDF[$i + 2]->M}}x{{ $dataPDF[$i + 2]->N}}</td>

                            @endif @if ($i
                            < count($dataPDF) - 3) @if($dataPDF[$i]->B == '1階')
                                <td>
                                    <span class="circle" style="">
                                        <b>1F</b>
                                    </span>
                                </td>
                                @else
                                <td>
                                    <span class="circle2" style="">
                                        <b>2F</b>
                                    </span>
                                </td>
                                @endif @if($dataPDF[$i + 3]->K == 'マーク付きベベル')
                                <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}]マーク </td>
                                @elseif($dataPDF[$i + 3]->K == '耐水ベベル')
                                <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}]耐水 </td>
                                @else
                                <td class="td1">{{ $dataPDF[$i + 3]->C }} [{{ $dataPDF[$i + 3]->J}}] {{ $dataPDF[$i + 3]->K}} </td>
                                @endif
                                <td>&nbsp;&nbsp;</td>
                                <td class="td2">{{ $dataPDF[$i + 3]->M}}x{{ $dataPDF[$i + 3]->N}}</td>

                                @endif
                                </tr>

                                @endfor
        </table>
        @endif
    </div>
    </div>
    </div>
</body>

</html>