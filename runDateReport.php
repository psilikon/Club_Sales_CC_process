<?php

$date = $_POST['date'];


$con = mysqli_connect("localhost","cron","1234","FORMS");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
    $error++;
}


$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND (idmax = 'Y' OR greatfun = 'Y' OR shoppersadv = 'Y' OR advplus = 'Y')";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_row($result);
$total = $row[0];

$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND idmax = 'Y'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_row($result);
$idmaxTotal = $row[0];



$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND greatfun = 'Y'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_row($result);
$greatfunTotal = $row[0];


$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND shoppersadv = 'Y'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_row($result);
$shoppersadvTotal = $row[0];

$sql = "SELECT count(id) FROM webform0 WHERE DATE(signup_date) = '$date' AND advplus = 'Y'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_row($result);
$advplusTotal = $row[0];


echo "Unique Customers : ".$total."<br>";
echo "Total IDMAX : ".$idmaxTotal."<br>";
echo " Total Great Fun ".$greatfunTotal."<br>";
echo " Total Shoppers Adv ".$shoppersadvTotal."<br>";
echo " Total Adv Plus ".$advplusTotal."<br>";
$totalTotal = $idmaxTotal + $greatfunTotal + $shoppersadvTotal + $advplusTotal;
echo "<br></br>";
echo "	Total : ".$totalTotal;

?>
