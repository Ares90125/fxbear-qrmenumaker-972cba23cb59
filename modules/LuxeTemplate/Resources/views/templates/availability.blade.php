@if(!empty($openingTime))
<div class="w-100 top-bar sticky_horizontal danger ">
    <div class="d-flex align-items-center justify-content-center">
        {{__('Opens')}} {{ $openingTime }} hrs. &nbsp;<a  data-toggle="modal" data-target="#schedule-week" class=""><span class="d-flex justify-content-center align-items-center">See schedule &nbsp;<svg width="9" fill="#e64f57" viewBox="-0.0136718 -11.4297 7.02733 4.11522" xmlns="http://www.w3.org/2000/svg"><path d="M3.28-7.43c.14.14.29.14.43 0l3.17-3.23c.16-.15.16-.31 0-.47l-.2-.2c-.15-.15-.31-.15-.47 0L3.47-8.55 .73-11.34c-.17-.17-.32-.17-.47 0l-.2.19c-.17.16-.17.31 0 .46Z"/></svg></span></a>
    </div>
</div>
@endif
@if(!empty($closingTime))
<div class="w-100 top-bar sticky_horizontal success ">
    <div class="d-flex align-items-center justify-content-center">
        {{__('Opened until')}} {{ $closingTime }} hrs. &nbsp;<a  data-toggle="modal" data-target="#schedule-week" class=""><span class="d-flex justify-content-center align-items-center">See schedule &nbsp;<svg width="9" fill="green" viewBox="-0.0136718 -11.4297 7.02733 4.11522" xmlns="http://www.w3.org/2000/svg"><path d="M3.28-7.43c.14.14.29.14.43 0l3.17-3.23c.16-.15.16-.31 0-.47l-.2-.2c-.15-.15-.31-.15-.47 0L3.47-8.55 .73-11.34c-.17-.17-.32-.17-.47 0l-.2.19c-.17.16-.17.31 0 .46Z"/></svg></span></a>
    </div>
</div>
@endif