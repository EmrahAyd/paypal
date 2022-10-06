<?php
require_once 'vendor/autoload.php';
use Omnipay\Omnipay;

// 'Buraya Az Önce Aldığımız Client Id Değerini Yazın'
$PaypalClientId = 'AcreZULSEWIm4rAjflCtoVaq4R3B4f3V2BVY3Ab8M6Ed35BdzCZH6fuVNQ-8C6_e2QRO2yN40gAPd2Q0';
// 'Buraya Az Önce Aldığımız Secret Key Değerini Yazın'
$PaypalClientSecret = 'EF6sZLFnm9XotZYDVjrZUORTtwWF9xN3WvlaYoyvS8y-qA5mQ8_WLGln05GPcgjE41p';
// Para birimini evrensel formatta girin. USD, EUR, GBP gibi. (Not: TRY desteklemiyor!)
$PaypalCurrency = 'PLN';
// PayPal'ı eğer Sandbox (Test) modunda kullanıyor iseniz true, eğer canlı modda ise false yapın.
$PayPalSandbox = true;
// Buraya ödeme miktarını girin.
$PaymentAmount = '10';
// Buraya geri dönüş yani callback url adresini girin.
$CallbackUrl = 'https://localhost/paypal/callback.php';
// Buraya işlem iptal olursa yönlenecek adresi girin.
$CancelUrl = 'https://localhost/paypal/callback.php?status=no';

$PayPal = Omnipay::create('PayPal_Rest');
$PayPal->setClientId($PaypalClientId);
$PayPal->setSecret($PaypalClientSecret);
$PayPal->setTestMode($PayPalSandbox);
$response = $PayPal->purchase(array(
'amount' => $PaymentAmount,
'currency' => $PaypalCurrency,
'returnUrl' => $CallbackUrl,
'cancelUrl' => $CancelUrl,
))->send();
if ($response->isRedirect()) {
// Eğer işlem başarılı olursa ödeme sayfasına yönlendir.
$response->redirect();
}
else {
// Eğer işlem başarısız olursa ekrana hata mesajını yazdır.
echo $response->getMessage();
}
?>