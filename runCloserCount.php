<?php

$date = $_POST['date'];


$con = mysqli_connect("localhost","cron","1234","FORMS");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
    $error++;
}

//GET Distint Agent IDs
$sql = "SELECT DISTINCT agent_id FROM webform0";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_all($result);

echo "<table class='table table-bordered table-striped'>";
echo "<th>REP ID</th><th>Total Customers</th><th>ID Max</th><th>Great Fun</th><th>Shoppers Adv</th><th>Adv Plus</th><th>Total Packages</th>";
/*
<th> </th>
<th> </th>
*/
foreach($rows as $value){
	$sql = "SELECT count(*) FROM webform0 WHERE DATE(signup_date) = '$date' AND agent_id = '$value[0]' AND (idmax = 'Y' OR greatfun = 'Y' OR shoppersadv = 'Y' OR advplus = 'Y')";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	$customerCount = $row[0];

	$sql = "SELECT count(*) FROM webform0 WHERE idmax = 'Y' AND agent_id = '$value[0]' AND DATE(signup_date) = '$date'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	$idmaxCount = $row[0];

	$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND greatfun = 'Y' AND agent_id = '$value[0]'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	$greatfunCount = $row[0];


	$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND shoppersadv = 'Y' AND agent_id = '$value[0]'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	$shoppersadvCount = $row[0];

	$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND advplus = 'Y' AND agent_id = '$value[0]'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	$advplusCount = $row[0];

	$packageCount = $idmaxCount + $greatfunCount + $shoppersadvCount + $advplusCount;

	echo "<tr><td>".$value[0]."</td><td>".$customerCount."</td><td>".$idmaxCount."</td><td>".$greatfunCount."</td><td>".$shoppersadvCount."</td><td>".$advplusCount."</td><td>".$packageCount."</td></tr>";

}
echo "</table>";
?>
