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