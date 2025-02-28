<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовая оплата</title>
</head>
<body>
<h1>Тестовая оплата через Robokassa</h1>

<script language="JavaScript" src="https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.js">
    MerchantLogin={{ $merchant_login }};
    DefaultSum={{ $default_sum }};
    InvoiceID={{ $invid }};
    Description="{{ $description }}";
    SignatureValue={{ $signature_value }};
    IsTest = {{$is_test}};
</script>
</body>
</html>
