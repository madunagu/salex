@php
$phone = core()->getConfigData('general.general.phone.phone');
@endphp

<div class="phone-contact btn btn-link" id="phone-contact">
    <div class="mini-phone-content">
        <div class="phone-text">24/7 SUPPORT</div>
        <i class="material-icons-outlined">phone</i>
        <span class="fs14 fw4">{{$phone}}</span>
    </div>

</div>