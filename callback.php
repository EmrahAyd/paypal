<?php
require_once 'vendor/autoload.php';
use Omnipay\Omnipay;

$PaypalClientId = 'AcreZULSEWIm4rAjflCtoVaq4R3B4f3V2BVY3Ab8M6Ed35BdzCZH6fuVNQ-8C6_e2QRO2yN40gAPd2Q0';
$PaypalClientSecret = 'EF6sZLFnm9XotZYDVjrZUORTtwWF9xN3WvlaYoyvS8y-qA5mQ8_WLGln05GPcgjE41p';

$PayPal = Omnipay::create('PayPal_Rest');
$PayPal->setClientId($PaypalClientId);
$PayPal->setSecret($PaypalClientSecret);
$PayPal->setTestMode($PayPalSandbox);
if(isset($_GET['PayerID']) && isset($_GET['paymentId'])) {
$response = $PayPal->completePurchase(array(
'payer_id' => $_GET['PayerID'],
'transactionReference' => $_GET['paymentId'],
))->send();
if ($response->isSuccessful()) {
// Eğer işlem başarılı olarak yapıldı ise ödeme ile alakalı bilgileri $PaymentData değişkenine atayalım.
$PaymentData = $response->getData();
// İşlem ID değeri.
$PaymentID = $PaymentData['id'];
// Ödeme yapan kişinin ID değeri.
$PayerID = $PaymentData['payer']['payer_info']['payer_id'];
// Ödeme yapan kişinin email adresi.
$PayerEmail = $PaymentData['payer']['payer_info']['email'];
// Ödeme yapılan miktar.
$Amount = $PaymentData['transactions'][0]['amount']['total'];
// İşlem durumu
$PaymentStatus = $PaymentData['state'];
echo 'İşlem Başarılı! Ödeme ID Değeri: '.$PaymentID;
}
else {
// Hata mesajını yazdıralım.
echo $response->getMessage();
}
}
else {
echo 'PayerID ve paymentId değerleri eksik!';
}
?>

<?php
if($_GET['status']){echo '<h3>Ödeme dönüşü</h3>';}else{echo '<h3>Ödeme dönüşü başarısız.</h3>';}
?>
