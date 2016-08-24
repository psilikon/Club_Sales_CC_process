<?php

$agentid = $_POST['agentid'];
$recid = $_POST['recid'];
$status = $_POST['status'];
$program = $_POST['program'];
$uniqueid = $_POST['uniqueid'];

echo $agentid.$recid.$status.$program;

$con = mysql_connect("localhost","cron","1234");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "UPDATE webform0 SET $program = '$status' WHERE agent_id = '$agentid' AND recid = '$recid' AND uniqueid = '$uniqueid'";
$result = mysql_query($query);
echo $result;
?>
