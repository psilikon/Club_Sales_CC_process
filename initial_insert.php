<?php

function getMicrotime()
{
    if (version_compare(PHP_VERSION, '5.0.0', '<'))
    {
        return array_sum(explode(' ', microtime()));
    }

    return microtime(true);
}

$agentid = $_POST['agentid'];
$recid = $_POST['recid'];
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
$gender = $_POST['gender'];

$uniqueid = getMicrotime();

$con = mysql_connect("localhost","cron","1234");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "INSERT INTO webform0 (agent_id,recid,email,signup_date,phone,fname,lname,address1,address2,city,state,zip,ccnum,cvv,ccexpmonth,ccexpyear,dob,uniqueid,gender) VALUES
	('$agentid','$recid','$email',now(),'$phone','$fname','$lname','$address1','$address2','$city','$state','$zip','$ccnum','$cvv','$ccexpmonth','$ccexpyear','$dob','$uniqueid','$gender')";
$result = mysql_query($query);
echo $uniqueid;
?>
