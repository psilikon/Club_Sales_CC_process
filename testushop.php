<?php
echo "starting...";

$loginId = "api@cmssubscriptions";
$password = "motivated2";
$emailAddress = "joelshas@yahoo.com";
$phoneNumber = "7277441783";
$firstName = "JOEL";
$lastName = "SHASTEEN";
$address1 = "533 BELLEVIEW BLVD";
$address2 = "";
$city = "CLEARWATER";
$state = "FL";
$country = "US";
$postalCode = "33756";
$shipFirstName = "JOEL";
$shipLastName = "SHASTEEN";
$shipAddress1 = "533 BELLEVIEW BLVD";
$shipAddress2 = "";
$shipCity = "CLEARWATER";
$shipState = "FL";
$shipCountry = "US";
$shipPostalCode = "33756";
$couponCode = "";
$paySource = 'CREDITCARD';
//$cardNumber = "5120255004369421";
$cardNumber = "0000000000000000";
$cardSecurityCode = "6671";
$cardYear = "16";
$cardMonth = "10";
$campaignId = "13";
$product1_id = "59";
$product1_qty = "1";
$dataString = 'loginId='.$loginId.'&password='.$password.'&emailAddress='.$emailAddress.'&phoneNumber='.$phoneNumber.'&firstName='.$firstName.'&lastName='.$lastName.'&address1='.$address1.'&address2='.$address2
.'&city='.$city.'&state='.$state.'&country='.$country.'&postalCode='.$postalCode.'&shipFirstName='.$shipFirstName.'&shipLastName='.$shipLastName.'&shipAddress1='.$shipAddress1
.'&shipAddress2='.$shipAddress2.'&shipCity='.$shipCity.'&shipState='.$shipState.'&shipCountry='.$shipCountry.'&shipPostalCode='.$shipPostalCode.'&couponCode='.$couponCode
.'&paySource='.$paySource.'&cardNumber='.$cardNumber.'&cardSecurityCode='.$cardSecurityCode.'&cardYear='.$cardYear.'&cardMonth='.$cardMonth.'&campaignId='.$campaignId
            .'&product1_id='.$product1_id.'&product1_qty='.$product1_qty;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api2.konnektive.com/order/import/");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

echo $response;
echo "finish";
curl_close($ch);

?>
