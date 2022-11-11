<div class='info' id="hours">
    <div class='box-info bg-white'>
        <div class="box-order">
            <div class='head align-center'>
                <h6>{{ __('Opening Hours') }}</h6>
            </div>
        </div>
        <div class="content py-0">
            <div class='schedule'>
                <ol class='items w-100'>
                    @foreach ($wh as $day=>$hours)
                        <li class="@if ($day==$currentDay) today @endif">
                            @if ($day==$currentDay)
                                <div class='day d-flex'>{{ __(ucfirst($day))}}
                                    <span class='tag d-flex justify-content-center align-items-center'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#00bc8b" width="8" id="BeBold" viewBox="0 0 14 14"><path id="Arrow-right-3" class="cls-1" d="M11.612,8.385l-5,5.2A1.608,1.608,0,0,1,3.92,12.389V1.611A1.608,1.608,0,0,1,6.607.419l5.005,5.2A1.87,1.87,0,0,1,11.612,8.385Z"></path></svg>
                                    </span>
                                </div>
                            @else
                                <div class='day'>{{ __(ucfirst($day))}} </div>
                            @endif
                            @foreach ($hours as $timeRange)
                                <div class='hours'>{{ $timeRange->start() }} - {{ $timeRange->end() }} </div>
                            @endforeach
                            
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>