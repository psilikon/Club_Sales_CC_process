<?php
$id = $_POST['id'];
$con = mysqli_connect("localhost","cron","1234","FORMS");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
    $error++;
}

$sql = "SELECT * FROM webform0 WHERE id = '$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$dateOfBirth = substr($row['dob'],0,4);

?>
<!DOCTYPE html> <html lang="en">
	<title>Web Form</title>
		<head>
	        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    	    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
			<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="loading.css">
			<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
			<script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	    </head>
<style type="text/css">
body { font-size: 1.1em; }

</style>
<script type="application/javascript">

function authorizenetTran(price, program, uniqueid) {
    var returnCode;
    var firstName = $("#customerFname").val();
    var lastName = $("#customerLname").val();
    var address1 = $("#customerAddress1").val();
    var city = $("#customerCity").val();
    var state = $("#customerState").val();
    var postalCode = $("#customerZip").val();
    var cardNumber = $("#ccnum").val();
    var cardSecurityCode = $("#cvv").val();
    var cardYear = $("#ccexpyear").val();
    var cardMonth = $("#ccexpmonth").val();
    var dataString = 'ccnum='+cardNumber+'&ccexpmonth='+cardMonth+'&ccexpyear='+cardYear+'&cvv='+cardSecurityCode+'&fname='+firstName+'&lname='+lastName+'&address1='+address1+
            '&city='+city+'&state='+state+'&zip='+postalCode+'&price='+price+'&program='+program+'&uniqueid='+uniqueid;
    $("#loading-background").show();
    $.ajax({
            type: "POST",
            dataType: 'JSON',
            async: false,
            data: dataString,
            url: "authorize_net.php",
            success: function(data) {
                returnCode = data.responseCode;
                alert(data.responseCode+" "+data.responseReason+" Transaction ID: "+data.transactionId);
                $("#loading-background").hide();
            }
         });
    return returnCode;
}

function authorizenetVoidTran(program, uniqueid) {
    var returnCode;
    var dataString = 'program='+program+'&uniqueid='+uniqueid;
    $("#loading-background").show();
    $.ajax({
            type: "POST",
            dataType: 'JSON',
            async: false,
            data: dataString,
            url: "authorize_net_void.php",
            success: function(data) {
                returnCode = data.responseCode;
                $("#loading-background").hide();
            }
         });
    return returnCode;
}

function updateProgram(program, status, uniqueid) {
    var agentid = $("#agentID").val();
    var recid = $("#recID").val();
    var program = program;
    var dataString = 'program='+program+'&status='+status+'&agentid='+agentid+'&recid='+recid+'&uniqueid='+uniqueid;
    console.log("Updating DB for "+program+" to "+status+" with uid of: "+uniqueid);
    $.ajax({
        type: "POST",
        url: "program_update.php",
        data: dataString,
        success: function(data) {
            $("#loading-background").hide();
        }
     });
}



$(document).ready(function() {
	$("#gender").val("<?php echo $row['gender']; ?>");
	var uniqueid = "<?php echo $row['uniqueid']; ?>";
	console.log(uniqueid);
	var idmaxStatus =  "<?php echo $row['idmax']; ?>";
	var shopadvStatus =  "<?php echo $row['shoppersadv']; ?>";
	var advplusStatus =  "<?php echo $row['advplus']; ?>";
	var greatfunStatus =  "<?php echo $row['greatfun']; ?>";

	var ushopEnroll;
	var idmaxEnroll;
	var greatfunEnroll;
	var shopadvEnroll;
	var healthwellEnroll;

	console.log("<?php echo $id; ?>");
	if(idmaxStatus == 'Y') {
        idmaxEnroll = 'ENROLLED';
		$("#programs").append("<li id='idmaxli' >ID MAX - PRE-AUTH APPROVED</li>");
		$("#idmaxon").removeClass('btn-danger');
		$("#idmaxon").addClass('btn-success');
		$("#idmaxoff").removeClass('btn-success');
		$("#idmaxoff").addClass('btn-danger');
	}
	if(shopadvStatus == 'Y'){
		$("#programs").append("<li id='shopadvli'>SHOPPERS ADV</li");
		$("#shopadvon").removeClass('btn-danger');
		$("#shopadvon").addClass('btn-success');
		$("#shopadvoff").removeClass('btn-success');
		$("#shopadvoff").addClass('btn-danger');

	}
	if(advplusStatus == 'Y'){
		$("#programs").append("<li id='advplusli'>ADVANTAGE PLUS</li");
		$("#advpluson").removeClass('btn-danger');
		$("#advpluson").addClass('btn-success');
		$("#advplusoff").removeClass('btn-success');
		$("#advplusoff").addClass('btn-danger');
	}
	if(greatfunStatus == 'Y'){
		$("#programs").append("<li id='greatfunli' >GREAT FUN</li>");
		$("#greatfunon").removeClass('btn-danger');
		$("#greatfunon").addClass('btn-success');
		$("#greatfunoff").removeClass('btn-success');
		$("#greatfunoff").addClass('btn-danger');
	}


	$("#finalize").click(function() {
		var emailAddress = $("#customerEmail").val();
		var phoneNumber = $("#customerPhone").val();
		var firstName = $("#customerFname").val();
		var lastName = $("#customerLname").val();
		var address1 = $("#customerAddress1").val();
		var address2 = $("#customerAddress2").val();
		var city = $("#customerCity").val();
		var state = $("#customerState").val();
		var postalCode = $("#customerZip").val();
		var cardNumber = $("#ccnum").val();
		var cardSecurityCode = $("#cvv").val();
		var cardYear = $("#ccexpyear").val();
		var cardMonth = $("#ccexpmonth").val();
		var dob = $("#dob").val();
		var gender = $("#gender").val();

		var dataString = 'phone='+phoneNumber+'&email='+emailAddress+'&gender='+gender+
			'&fname='+firstName+'&lname='+lastName+'&address1='+address1+'&address2='+address2+'&city='+city+'&state='+state+
			'&zip='+postalCode+'&ccnum='+cardNumber+'&ccexpmonth='+cardMonth+'&ccexpyear='+cardYear+'&cvv='+cardSecurityCode+'&dob='+dob+'&uniqueid='+uniqueid;

			console.log("FINALIZING");
			$.ajax({
				type: "POST",
				data: dataString,
				async: false,
				url: "finalize.php",
				success: function(data) {
					document.write(data);
	   	    	}
	    	 });
	});

   $("#idmaxon").click(function() {
        if(document.getElementById("idmaxli")){
            alert("ID MAX already selected");
        }else{
            var state = $("#customerState").val().toUpperCase();
            console.log(state);
            if(state.match("ND|NY")){
                alert("Not enabled due to state omit : "+state);
            } else {
                if (idmaxEnroll != 'ENROLLED') {
                    var authResponse = authorizenetTran('3.95','idmax', uniqueid);
					updateProgram('idmax','Y',uniqueid);
                    console.log(authResponse);
                    if(authResponse == "APPROVED"){
                        idmaxEnroll = 'ENROLLED';
                        $("#programs").append("<li id='idmaxli' >ID MAX - PRE-AUTH APPROVED</li>");
                        $("#idmaxon").removeClass('btn-danger');
                        $("#idmaxon").addClass('btn-success');
                        $("#idmaxoff").removeClass('btn-success');
                        $("#idmaxoff").addClass('btn-danger');
                    } else {
                        alert(authResponse);
                    }
                } else {
                    alert("Error: customer info incorrect/un-verified or already enrolled.");
                }
            }
        }
    });

    $("#idmaxoff").click(function() {
        if(idmaxEnroll == 'ENROLLED'){
            var voidResponse = authorizenetVoidTran('idmax', uniqueid);
            if(voidResponse == "APPROVED"){
                alert("Transaction successfully VOIDED.");
				updateProgram('idmax','N',uniqueid);
                idmaxEnroll = 'false';
                $("#idmaxli").remove();
                $("#idmaxon").removeClass('btn-success');
                $("#idmaxon").addClass('btn-danger');
                $("#idmaxoff").removeClass('btn-danger');
                $("#idmaxoff").addClass('btn-success');
            } else {
                alert("There was an ERROR voiding transaction.");
            }
        }
    });

	$("#greatfunon").click(function() {
        if(document.getElementById("greatfunli")){
            alert("GREAT FUN already selected");
        } else {
            var state = $("#customerState").val().toUpperCase();
            console.log(state);
            if(state.match("IA|ID|VT")){
                alert("Not enabled due to state omit : "+state);
            } else {
 	            greatfunEnroll = 'ENROLLED';
				updateProgram('greatfun','Y',uniqueid);
                $("#programs").append("<li id='greatfunli' >GREAT FUN</li>");
 	            $("#greatfunon").removeClass('btn-danger');
                $("#greatfunon").addClass('btn-success');
                $("#greatfunoff").removeClass('btn-success');
                $("#greatfunoff").addClass('btn-danger');
            }
        }
    });

    $("#greatfunoff").click(function() {
        idmaxEnroll = false;
		updateProgram('greatfun','N',uniqueid);
        $("#greatfunli").remove();
        $("#greatfunon").removeClass('btn-success');
        $("#greatfunon").addClass('btn-danger');
        $("#greatfunoff").removeClass('btn-danger');
        $("#greatfunoff").addClass('btn-success');
    });

    $("#shopadvon").click(function() {
        if(document.getElementById("shopadvli")){
            alert("SHOPPERS ADVANTAGE already selected");
        } else {
            var state = $("#customerState").val().toUpperCase();
            console.log(state);
            if(state.match("AK|HI|IA|ID|VT")){
                alert("Not enabled due to state omit : "+state);
            } else {
                shoppersadvEnroll = 'ENROLLED';
				updateProgram('shoppersadv','Y',uniqueid);
	            $("#programs").append("<li id='shopadvli'>SHOPPERS ADV</li");
                $("#shopadvon").removeClass('btn-danger');
                $("#shopadvon").addClass('btn-success');
                $("#shopadvoff").removeClass('btn-success');
                $("#shopadvoff").addClass('btn-danger');
            }
        }
    });

	$("#shopadvoff").click(function() {
        shoppersadvEnroll = false;
		updateProgram('shoppersadv','N',uniqueid);
        $("#shopadvli").remove();
        $("#shopadvon").removeClass('btn-success');
        $("#shopadvon").addClass('btn-danger');
        $("#shopadvoff").removeClass('btn-danger');
        $("#shopadvoff").addClass('btn-success');
    });

	$("#advpluson").click(function() {
        if(document.getElementById("advplusli")){
            alert("ADVANTAGE PLUS already selected");
        } else {
			advplusEnroll = 'ENROLLED';
			updateProgram('advplus','Y',uniqueid);
	        $("#programs").append("<li id='advplusli'>ADVANTAGE PLUS</li");
            $("#advpluson").removeClass('btn-danger');
            $("#advpluson").addClass('btn-success');
            $("#advplusoff").removeClass('btn-success');
            $("#advplusoff").addClass('btn-danger');
        }
    });

   $("#advplusoff").click(function() {
		advplusEnroll = 'false';
		updateProgram('advplus','N',uniqueid);
        $("#advplusli").remove();
        $("#advpluson").removeClass('btn-success');
        $("#advpluson").addClass('btn-danger');
        $("#advplusoff").removeClass('btn-danger');
        $("#advplusoff").addClass('btn-success');
    });



});
</script>
<body>
<div class="navbar navbar-default" role="navigation">
	<div class="container">
		<div id="verifyStatus"><ul></ul></div>
		<div id="ccStatus"><ul></ul></div>
		<div id="programs"><ul></ul></div>
	</div>
</div>
<div class="container">
	<div class="well">
	<div class="row">
		<ul class="list-inline">
			<li>
				<label for="idmax">ID MAX</label>
				<div class="btn-group btn-toggle" id="idmax">
				    <button id="idmaxon" class="btn btn-sm btn-danger">ON</button>
				    <button id="idmaxoff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
			<li>
				<label for="greatfun">GREAT FUN</label>
				<div class="btn-group btn-toggle" id="greatfun">
				    <button id="greatfunon" class="btn btn-sm btn-danger">ON</button>
				    <button id="greatfunoff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
			<li>
				<label for="shopadv">SHOPPERS ADV.</label>
				<div class="btn-group btn-toggle" id="shopadv">
				    <button id="shopadvon" class="btn btn-sm btn-danger">ON</button>
				    <button id="shopadvoff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
			<li>
				<label for="advplus">ADV. PLUS</label>
				<div class="btn-group btn-toggle" id="advplus">
				    <button id="advpluson" class="btn btn-sm btn-danger">ON</button>
				    <button id="advplusoff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
			<li>
				<label for="healthwell">HEALTH WELLNESS</label>
				<div class="btn-group btn-toggle" id="healthwell">
				    <button id="healthwellon" class="btn btn-sm btn-danger">ON</button>
				    <button id="healthwelloff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
		</ul>
		</div> <!--row-->
	</div> <!--well-->

	<form class="form-horizontal" role="form">
	<div class="row">																<!--ROW1-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerPhone">Customer Phone</label>
				<input type="text" class="form-control" id="customerPhone" placeholder="" value="<? echo $row['phone']; ?>">
			</div>
		</div> <!--col-sm-3-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerFname">Customer First Name</label>
				<input type="text" class="form-control" id="customerFname" placeholder="" value="<? echo $row['fname']; ?>">
			</div>
		</div>  <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerLname">Customer Last Name</label>
				<input type="text" class="form-control" id="customerLname" placeholder="" value="<? echo $row['lname']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerEmail">Customer Email</label>
				<input type="text" class="form-control" id="customerEmail" placeholder="" value="<? echo $row['email']; ?>">
			</div>
		</div> <!--col-->

	</div> <!--row-->

	<div class="row">																 <!--ROW2-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="add1div">
				<label for="customerAddress1">Customer Address1</label>
				<input type="text" class="form-control" id="customerAddress1" placeholder="" value="<? echo $row['address1']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="add2div">
				<label for="customerAddress2">Customer Address2</label>
				<input type="text" class="form-control" id="customerAddress2" placeholder="" value="<? echo $row['address2']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="citydiv">
				<label for="customerCity">Customer City</label>
				<input type="text" class="form-control" id="customerCity" placeholder="" value="<? echo $row['city']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="statediv">
				<label for="customerState">Customer State</label>
				<input type="text" class="form-control" id="customerState" value="<? echo $row['state']; ?>">
			</div>
		</div> <!--col-->
	</div> <!--row-->

	<div class="row">																													<!--ROW3-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="zipdiv">
				<label for="customerZip">Customer ZIP</label>
				<input type="text" class="form-control" id="customerZip" placeholder="" value="<? echo $row['zip']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="dob">DOB</label>
				<input type="text" class="form-control dob" id="dob" placeholder="" value="<? echo $dateOfBirth; ?>"">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="gender">Gender</label>
				<select class="form-control" id="gender">
					<option selected="------" value="------" >------</option>
					<option value="M">MALE</option>
					<option value="F">FEMALE</option>
				</select>
			</div>
		</div> <!--col-->
	</div> <!--row-->


	<div class="row">
		<div class="col-sm-3">
			<div id="ccnumdiv" class="form-group has-feedback">
				<label for="ccnum">CC Number</label>
				<input type="text" class="form-control" id="ccnum" placeholder="" value="<? echo $row['ccnum']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="ccexpmonthdiv" class="form-group has-feedback">
				<label for="ccexpmonth">Exp. Month</label>
				<input type="text" class="form-control" id="ccexpmonth" value="<? echo $row['ccexpmonth']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="ccexpyeardiv" class="form-group has-feedback">
				<label for="ccexpyear">Exp. Year</label>
				<input type="text" class="form-control" id="ccexpyear" placeholder="" value="<? echo $row['ccexpyear']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="cvvdiv" class="form-group">
				<label for="cvv">CVV</label>
				<input type="text" class="form-control" id="cvv" placeholder="" value="<? echo $row['cvv']; ?>">
			</div>
		</div> <!--col-->
	</div> <!--row-->

	<div class="row">
		<div class="col-sm-3">
			<div id="agentiddiv" class="form-group">
				<label for="ccnum">Rep ID</label>
				<input type="text" class="form-control" id="agentid" placeholder="" value="<? echo $row['agent_id']; ?>" readonly>
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="reciddiv" class="form-group has-feedback">
				<label for="recid">Recording ID</label>
				<input type="text" class="form-control" id="recid" value="<? echo $row['recid']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="signupdatediv" class="form-group">
				<label for="signupdate">Enroll Date</label>
				<input type="text" class="form-control" id="signupdate" placeholder="" value="<? echo $row['signup_date']; ?>" readonly>
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="iddiv" class="form-group">
				<label for="id">ID</label>
				<input type="text" class="form-control" id="id" placeholder="" value="<? echo $row['id']; ?>" readonly>
			</div>
		</div> <!--col-->
	</div> <!--row-->
	<div class="row">
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4">
		</div>
	</div> <!--row-->


	<div class="row">
		<div class="col-sm-6">
		</div> <!--col-6-->
		<div class="col-sm-3">
			<button type="button" class="btn btn-danger" id="finalize">UPDATE</button>
		</div> <!--col-->
	</div> <!--row-->
	</form>
</div> <!--container-->

<div id="loading-background">
    <div id="loading" class="ui-corner-all" >
      <img style="height:80px;margin:30px;" src="loading.gif" alt="Loading.."/>
      <h2 style="color:gray;font-weight:normal;">Please wait....</h2>
     </div>
</div>
<input type="hidden" id="agentID" value="<? echo $row['RepId']; ?>">
<input type="hidden" id="recID" placeholder="" value="<? echo $row['RecId']; ?>">



</body>
</html>

