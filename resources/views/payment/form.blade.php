<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оплата через Robokassa</title>
</head>
<body>
<script language="JavaScript"
        src="https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?
            MerchantLogin={{ $merchant_login }}&
            OutSum={{ $out_sum }}&
            IsTest={{$IsTest }}&
            InvoiceID={{ $invid }}&
            Description={{ urlencode($description) }}&
            SignatureValue={{ $signature_value }}">
</script>
</body>
</html>
