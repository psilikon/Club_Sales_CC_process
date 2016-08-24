<?php
require("usps_address_class.php");

$uspsRequest = new usps(); //class instantiation
$uspsRequest->address1 = $_POST['address2'];
$uspsRequest->address2 = $_POST['address1'];
$uspsRequest->city = $_POST['city'];
$uspsRequest->state = $_POST['state'];
$uspsRequest->zip = $_POST['zip'];


$result = $uspsRequest->submit_request();

if (!empty($result)){
		$xml = new SimpleXMLElement($result);
	}else{
		die;
	}


$error = $xml->Address[0]->Error->Description;
$add1 = $xml->Address[0]->Address1;
$add2 = $xml->Address[0]->Address2;
$city = $xml->Address[0]->City;
$state = $xml->Address[0]->State;
$zip = $xml->Address[0]->Zip5;

$returnData = array('error'=>$error,'add1'=>$add1,'add2'=>$add2,'city'=>$city,'state'=>$state,'zip'=>$zip);
echo json_encode($returnData)

?>
