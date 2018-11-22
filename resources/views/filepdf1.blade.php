<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <style  type="text/css">
            body {font-family:Meiryo !important;}
            #circle span{
                width: 30px;
                height: 30px;
                border-radius: 15px;
                background: rgb(0, 217, 255);
                position: absolute;
                text-align: center;
            }
            .td1{
                text-align: right; 
                font-size:10px;
            }
            .td2{
                text-align: right; 
                font-size:15px;
                padding-right: 2px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                <font size="2">
                <table>
                    @for ($i = 0; $i < count($dataPDF1); $i+=4)
                        <tr>
                            @if ($i < count($dataPDF1))
                                <td id = "circle"> <span >1F</span></td>   
                                <td class = "td1">{{ $dataPDF1[$i]->C }} [{{ $dataPDF1[$i]->J}}] {{ $dataPDF1[$i]->K}} </td>
                                <td class = "td2">{{ $dataPDF1[$i]->M}} X {{ $dataPDF1[$i]->N}} </td>
                            @endif

                            @if ($i < count($dataPDF1) -1)
                                <td id = "circle"> <span >1F</span></td>   
                                <td class = "td1">{{ $dataPDF1[$i + 1]->C }} [{{ $dataPDF1[$i + 1]->J}}] {{ $dataPDF1[$i + 1]->K}} </td>
                                <td class = "td2">{{ $dataPDF1[$i + 1]->M}} X {{ $dataPDF1[$i + 1]->N}} </td>
                            @endif

                            @if ($i < count($dataPDF1) -2)
                                <td id = "circle"> <span >1F</span></td>   
                                <td class = "td1">{{ $dataPDF1[$i + 2]->C }} [{{ $dataPDF1[$i + 2]->J}}] {{ $dataPDF1[$i + 2]->K}} </td>
                                <td class = "td2">{{ $dataPDF1[$i + 2]->M}} X {{ $dataPDF1[$i + 2]->N}} </td>
                            @endif
                            
                            @if ($i < count($dataPDF1) - 3)
                                <td id = "circle"> <span >1F</span></td>    
                                <td class = "td1">{{ $dataPDF1[$i + 3]->C }} [{{ $dataPDF1[$i + 3]->J}}] {{ $dataPDF1[$i + 3]->K}} </td>
                                <td class = "td2">{{ $dataPDF1[$i + 3]->M}} X {{ $dataPDF1[$i + 3]->N}} </td>
                            @endif
                        </tr>
                    @endfor
                </table>
                </div>
            </div>
        </div>
    </body>
</html>
