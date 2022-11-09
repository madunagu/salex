<?php 

$bitPay = app('Salex\Bitpay\Payment\Bitpay');
$invoice = $bitPay->generateInvoice();

?>

<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    You will be redirected to the Bitpay website in a few seconds.


    <form action="{{ $invoice->getURL() }}" id="bitpay_checkout" method="POST">
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">
        <input type="hidden" id="redirectURL" value="{{  $invoice->getURL() }}">
    </form>

    <script type="text/javascript">
        var redirectURL = document.getElementById("redirectURL").value;
        window.location.replace(redirectURL);
    </script>
</body>

<?php 

// <input type="hidden" id="redirectURL" value="{{  $invoice->getURL() }}">

?>