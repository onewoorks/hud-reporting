<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/paper.css') }}">

    </head>
    <body class="A4">

    <section class="sheet padding-20mm">
        @php 
            $rownum = 1;
            $location_number = 0;
        @endphp
        <table>
            <tbody>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tarikh</th>
                    <th rowspan="2">Nama Pencawang</th>
                    <th rowspan="2">Total</th>
                    <th colspan="2">Jenis</th>
                    <th rowspan="2">Muka Surat</th>
                </tr>
                <tr>
                    <th>Indoor</th>
                    <th>Outdoor</th>
                </tr>
                @foreach($reports as $day=>$report)
                    @php
                        $rowspan    = count($report);
                    @endphp
                    @foreach($report as $key=>$d)
                    <tr>
                        <td class='text-center'>{{$rownum++}}</td>
                        @if($rowspan > 0)
                        <td rowspan={{ $rowspan }} class='text-center'>{{ $day }}</td>
                        @endif
                        <td>{{ $key }}</td>
                        @if($rowspan > 0)
                        <td rowspan={{ $rowspan }} class='text-center'>{{ $rowspan }}</td>
                        @endif
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                        $rowspan = 0;
                    @endphp
                    @endforeach
                @endforeach
            </tbody>
        </table>

    </section>

    @foreach($reports as $day=>$report)
    @foreach($report as $loc=>$d)
    @php
        $location_number++;
        $status_inc = 'a';
    @endphp
    <section class="sheet padding-20mm">
        <div class='report-title'>{{ $report_title }} </div>
        <div>
            @foreach($report[$loc] as $label=>$progress)
            <div>
                @if($status_inc=='a')
                    <div class='location-title'>{{ $location_number }}. {{ $loc }}</div>
                @endif
                <div class='label-progress'>{{ $status_inc++ }}. <span class="text-uppercase">{{ $label }}</span></div>
                <div class="image-area">
                    @if(!empty($progress))
                        <div class="row p-2">
                        @php
                            $img_no = 0;
                        @endphp
                        @foreach($progress as $image)
                            @if($img_no < 4)
                            <div class='col-6 p-2'>
                                <div class="image-placeholder">
                                    <img src="http://localhost:8000{{ $image }}" class="img-report" />
                                </div>
                            </div>
                            
                            @php
                                $img_no++;
                            @endphp
                            @endif
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
    </section>
    @endforeach
    @endforeach
        
    </body>
</html>
