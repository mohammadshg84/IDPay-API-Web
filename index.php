<?php

echo ('درحال انتقال به درگاه پرداخت...');

$amount = $_GET['amount'];
$name = "NAME";
$desc = "DESCRIPTION";
require_once('variables.php');

$params = array(
  'order_id' => '101',
  'amount' => $amount,
  'phone' => '',
  'name' => $name,
  'desc' => $desc,
  'callback' => URL_CALLBACK,
);

idpay_payment_create($params);

function idpay_payment_create($params) {
    $header = array(
    'Content-Type: application/json',
    'X-API-KEY:' . APIKEY,
    'X-SANDBOX:' . SANDBOX,
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, URL_PAYMENT);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $result = curl_exec($ch);
  curl_close($ch);

  $result = json_decode($result);

  if (empty($result) || empty($result->link)) {

    print 'Exception message:';
    print '<pre>';
    print_r($result);
    print '</pre>';

    return FALSE;
}

  //Redirect to payment form
  header('Location:' . $result->link);
}
