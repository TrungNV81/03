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
           body{
                    font-family:Meiryo !important;
                    padding:0px !important; 
                    margin:0px !important;
                }
            div.breakNow { page-break-inside:avoid !important; page-break-after:always !important; }
            .circle{
                background: rgb(0, 217, 255);
                text-align: center !important;
                border-radius: 12px;
                height: 24px; 
                width: 24px;
                position: absolute !important;
                font-size:11px;
                display: inline-block;
                padding:0px !important;
                margin:0px !important;
            }
            .td1{
                text-align: right; 
                font-size:10px;
                width: 13% !important;
                padding:0px !important;
                margin:0px !important;
            }
            .td2{
                text-align: right; 
                font-size:15px;
                width: 5% !important;
                padding:0px !important;
                margin:0px !important;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                <?php 
                    $page = (int)(count($dataPDF1)/72);
                ?>
                @if($page >0)
                    @for ($j = 0; $j < $page; $j++)                  
                    <!-- @if($j*72 < count($dataPDF1)) -->
                    <div style="text-align: center;">{{ $dataPDF1[0]->Q }}_１階先行壁</div>
                    <table style="page-break-after:always;width: 100%;">   
                        @for ($i = $j*72; $i < ($j + 1)*72; $i+=4)
                            <tr style="width: 100%;">                   
                                @if ($i < count($dataPDF1))
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>   
                                    <td class = "td1">{{ $dataPDF1[$i]->C }} [{{ $dataPDF1[$i]->J}}] {{ $dataPDF1[$i]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i]->M}}x{{ $dataPDF1[$i]->N}} </td>
                                
                                @endif

                                @if ($i < count($dataPDF1) -1)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>
                                    <td class = "td1">{{ $dataPDF1[$i + 1]->C }} [{{ $dataPDF1[$i + 1]->J}}] {{ $dataPDF1[$i + 1]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i + 1]->M}}x{{ $dataPDF1[$i + 1]->N}} </td>
                                    
                                @endif

                                @if ($i < count($dataPDF1) -2)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>
                                    <td class = "td1">{{ $dataPDF1[$i + 2]->C }} [{{ $dataPDF1[$i + 2]->J}}] {{ $dataPDF1[$i + 2]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i + 2]->M}}x{{ $dataPDF1[$i + 2]->N}} </td>
                                    
                                @endif
                                
                                @if ($i < count($dataPDF1) - 3)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td> 
                                    <td class = "td1">{{ $dataPDF1[$i + 3]->C }} [{{ $dataPDF1[$i + 3]->J}}] {{ $dataPDF1[$i + 3]->K}} </td>
                                    <td>&nbsp;&nbsp;</td> 
                                    <td class = "td2">{{ $dataPDF1[$i + 3]->M}}x{{ $dataPDF1[$i + 3]->N}} </td>
                                    
                                @endif
                            </tr>                    
                            @endfor
                    </table>
                    <!-- @endif -->
                    @endfor
                @endif
                @if(($page * 72 < count($dataPDF1)) || $page == 0)
                <div style="text-align: center;">{{ $dataPDF1[0]->Q }}_１階先行壁</div>
                    <table style="width: 100%;">   
                        @for ($i = 0; $i < count($dataPDF1); $i+=4)
                            <tr style="width: 100%;">                   
                                @if ($i < count($dataPDF1))
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>   
                                    <td class = "td1">{{ $dataPDF1[$i]->C }} [{{ $dataPDF1[$i]->J}}] {{ $dataPDF1[$i]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i]->M}}x{{ $dataPDF1[$i]->N}} </td>
                                
                                @endif

                                @if ($i < count($dataPDF1) -1)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>
                                    <td class = "td1">{{ $dataPDF1[$i + 1]->C }} [{{ $dataPDF1[$i + 1]->J}}] {{ $dataPDF1[$i + 1]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i + 1]->M}}x{{ $dataPDF1[$i + 1]->N}} </td>
                                    
                                @endif

                                @if ($i < count($dataPDF1) -2)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td>
                                    <td class = "td1">{{ $dataPDF1[$i + 2]->C }} [{{ $dataPDF1[$i + 2]->J}}] {{ $dataPDF1[$i + 2]->K}} </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td class = "td2">{{ $dataPDF1[$i + 2]->M}}x{{ $dataPDF1[$i + 2]->N}} </td>
                                    
                                @endif
                                
                                @if ($i < count($dataPDF1) - 3)
                                    <td style = "padding-top:3px;"> <span class="circle" ><b>1F</b></span></td> 
                                    <td class = "td1">{{ $dataPDF1[$i + 3]->C }} [{{ $dataPDF1[$i + 3]->J}}] {{ $dataPDF1[$i + 3]->K}} </td>
                                    <td>&nbsp;&nbsp;</td> 
                                    <td class = "td2">{{ $dataPDF1[$i + 3]->M}}x{{ $dataPDF1[$i + 3]->N}} </td>
                                    
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
