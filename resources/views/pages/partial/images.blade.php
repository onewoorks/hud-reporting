@php
    $location_number = 0;
@endphp

@foreach($reports as $day=>$report)
    @foreach($report as $loc=>$d)
    @php
        $location_number++;
        $status_inc = 'a';
    @endphp
        <div class='page'>
            @foreach($report[$loc] as $label=>$progress)
            <div >
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
    @endforeach
@endforeach