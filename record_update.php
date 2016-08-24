<?php


$email = $_POST['email'];
$phone = $_POST['phone'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$ccnum = $_POST['ccnum'];
$cvv = $_POST['cvv'];
$ccexpyear = $_POST['ccexpyear'];
$ccexpmonth = $_POST['ccexpmonth'];
$dob = $_POST['dob'].'-00-00';
$uniqueid = $_POST['uniqueid'];
$gender = $_POST['gender'];

$con = mysql_connect("localhost","cron","1234");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "UPDATE webform0 SET email = '$email', signup_date = NOW(), phone = '$phone', fname = '$fname', lname = '$lname',
	address1 = '$address1', address2 = '$address2',	city = '$city', state = '$state', zip = '$zip', ccnum = '$ccnum',
	cvv = '$cvv', ccexpmonth = '$ccexpmonth', ccexpyear = '$ccexpyear', dob = '$dob', gender = '$gender' WHERE uniqueid = '$uniqueid'";
echo $query;
mysql_query($query);
?>
