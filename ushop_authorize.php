<?php
$uniqueid = $_POST['uniqueid'];
$loginId = "api@cmssubscriptions";
$password = "motivated2";
$emailAddress = $_POST['emailAddress'];
$phoneNumber = $_POST['phoneNumber'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$postalCode = $_POST['postalCode'];
$shipFirstName = $_POST['shipFirstName'];
$shipLastName = $_POST['shipLastName'];
$shipAddress1 = $_POST['shipAddress1'];
$shipAddress2 = $_POST['shipAddress2'];
$shipCity = $_POST['shipCity'];
$shipState = $_POST['shipState'];
$shipCountry = $_POST['shipCountry'];
$shipPostalCode = $_POST['shipPostalCode'];
$couponCode = $_POST['couponCode'];
$paySource = $_POST['paySource'];
$cardNumber = $_POST['cardNumber'];
//$cardNumber = "0000000000000000";
$cardSecurityCode = $_POST['cardSecurityCode'];
$cardYear = $_POST['cardYear'];
$cardMonth = $_POST['cardMonth'];
$campaignId = $_POST['campaignId'];
$product1_id = $_POST['product1_id'];
$product1_qty = $_POST['product1_qty'];
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

$jsonDecoded = json_decode($response, true);

$returnResult = $jsonDecoded['result'];
$returnOid = $jsonDecoded['message']['orderId'];

/*
if($returnResult == "SUCCESS") {
    $con = mysql_connect("localhost","cron","1234");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
        $error++;
    }
    mysql_select_db("FORMS", $con);

    $query = "UPDATE webform0 SET ushop_tid = '$returnOid' WHERE uniqueid = '$uniqueid'";
    $result = mysql_query($query);
}
*/

echo $response;
curl_close($ch);

?>
