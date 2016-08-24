<html lang="en">
<head>
</head>
<script>
</script>
<?php

$agent_id = $_POST['agentID'];
$recid = $_POST['recID'];
$gender = $_POST['gender'];
$phone = $_POST['customerPhone'];
$email = $_POST['customerEmail'];
$fname = $_POST['customerFname'];
$lname = $_POST['customerLname'];
$address1 = $_POST['customerAddress1'];
$address2 = $_POST['customerAddress2'];
$city = $_POST['customerCity'];
$state =  $_POST['customerState'];
$zip = $_POST['customerZip'];
$ccnum = $_POST['ccnum'];
$ccexp = $_POST['ccexpmonth'].'-'.$_POST['ccexpyear'];
$dob = $_POST['dob'];
$epoch = time();
$ushop = $_POST['ushop'];
$idmaxguard = $_POST['idmax'];
$greatfun = $_POST['greatfun'];
$shopperadv = $_POST['shopadv'];
$advplus = $_POST['advplus'];
$healthwell = $_POST['healthwell'];
$magsaver = $_POST['magsav'];

$con = mysql_connect("localhost","cron","1234");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "INSERT INTO webform0 (agent_id,recid,gender,phone,email,signup_date,fname,lname,address1,address2,city,state,zip,ccnum,ccexp,dob,epoch,ushop,idmaxguard,greatfun,shoppersadv,advplus,healthwell,magsaver) 
	VALUES	('$agent_id','$recid','$gender','$phone','$email','$fname','$lname','$address1','$address2','$city','$state','$zip','$ccnum','$dob','$epoch','$ushop','$idmaxguard','$greatfun','$shopperadv','$advplus','$healthwell','$magsaver');
$result = mysql_query($query);
?>

