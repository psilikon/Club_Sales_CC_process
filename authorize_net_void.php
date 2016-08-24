<?PHP
// By default, this sample code is designed to post to our test server for
// developer accounts: https://test.authorize.net/gateway/transact.dll
// for real accounts (even in test mode), please make sure that you are
// posting to: https://secure.authorize.net/gateway/transact.dll

//$post_url = "https://test.authorize.net/gateway/transact.dll";
$post_url = "https://secure.authorize.net/gateway/transact.dll";

//GET PROGRAM TID FOR UINQIUE ID
$program = $_POST['program'];
$program_tid = $_POST['program']."_tid";
$uniqueid = $_POST['uniqueid'];

$con = mysql_connect("localhost","cron","1234");
if (!$con){
	die('Could not connect: ' . mysql_error());
	$error++;
}

mysql_select_db("FORMS", $con);

$query = "SELECT $program_tid FROM webform0 WHERE uniqueid = '$uniqueid'";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$transactionId = $row[0];
//echo $transactionId;



if($program == 'idmax'){
    $xlogin = '6R4cn8HTy';
    $xkey = '6ngX94w7pYALM79X';
}
if($program == 'healthwell'){
    $xlogin = '44yNcdB8L';
    $xkey = '37K2pJLb8a67c6ng';
}

$post_values = array(
	"x_login"			=> $xlogin,
	"x_tran_key"		=> $xkey,
	"x_version"			=> "3.1",
	"x_delim_data"		=> "TRUE",
	"x_delim_char"		=> "|",
	"x_relay_response"	=> "FALSE",
	"x_type"			=> "VOID",
	"x_trans_id"        => $transactionId
);


$post_string = "";

foreach( $post_values as $key => $value )
	{ $post_string .= "$key=" . urlencode( $value ) . "&"; }

$post_string = rtrim( $post_string, "& " );


$request = curl_init($post_url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
	$post_response = curl_exec($request); // execute curl post and store results in $post_response

curl_close ($request); // close curl object

$ra = explode($post_values["x_delim_char"],$post_response);

switch ($ra[0]) {
    case '1':
        $rc = 'APPROVED';
        break;
    case '2':
        $rc = 'DECLINED';
        break;
    case '3':
        $rc = 'ERROR';
        break;
    case '4':
        $rc = 'HELD FOR REVIEW';
        break;
}


$compactArray = array('responseCode' => $rc, 'responseReason' => $ra[3], 'transactionId' => $transactionId);
echo json_encode($compactArray);
?>
