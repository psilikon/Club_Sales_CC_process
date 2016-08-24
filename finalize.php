<!DOCTYPE html>
<html lang="en">
    <title>Web Form</title>
        <head>
            <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
            <script type="text/javascript" src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="loading.css">
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        </head>
<style type="text/css">
body { font-size: 1.1em; }
.label {
    margin-left: 35px;
    margin-right: 5px;
}

.dob {
    font-size: 11px;
    font-weight: bold;
}

.cc {
    font-size: 11px;
    font-weight: bold;
}

</style>
<html>
<body>
<div ="container">
<?php

$agentid = $_POST['agentid'];
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
    address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', zip = '$zip', ccnum = '$ccnum',
    cvv = '$cvv', ccexpmonth = '$ccexpmonth', ccexpyear = '$ccexpyear', dob = '$dob', gender = '$gender' WHERE uniqueid = '$uniqueid'";
mysql_query($query);

$con = mysql_connect("localhost","cron","1234");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "SELECT id, phone, agent_id, idmax, greatfun, shoppersadv, advplus, healthwell FROM webform0 WHERE agent_id = '$agentid' AND 
	DATE(signup_date) = DATE(now()) AND (idmax = 'Y' OR greatfun = 'Y' OR shoppersadv = 'Y' OR advplus = 'Y') order by id desc";

$result = mysql_query($query);

echo "<table class='table table-bordered table-striped'>";
echo "<tr><th>SALE ID</th><th>Phone</th><th>AGENT ID</th><th>ID MAX</th><th>GREAT FUN</th><th>SHOPPERS ADV.</th><th>ADV. PLUS</th><th>HEALTH WELL</th></tr>";

while($row = mysql_fetch_array($result)) {
	echo "<tr><td>".$row['id']."</td><td>".$row['phone']."</td><td>".$row['agent_id']."</td><td>".$row['idmax']."</td><td>".$row['greatfun']."</td><td>".$row['shoppersadv']."</td><td>".$row['advplus']."</td><td>".$row['advplus']."</td></tr>";
}
echo "</table>";
?>
</div>
</body>
</html>
