<?php
$ccstring = explode("/", $_GET['comments']);
?>
<!DOCTYPE html>
<html lang="en">
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
<script type="application/javascript">
var addressVerificationStatus;
var ccVerificationStatus;
var ushopEnroll;
var idmaxEnroll;
var greatfunEnroll;
var shopadvEnroll;
var healthwellEnroll;
var uniqueid;

function justValidate(){
	if(empty(document.getElementById('customerFname'),"Customer First Name is required")){
	if(empty(document.getElementById('customerLname'),"Customer Last Name is required")){
	if(gender(document.getElementById('gender'),"Must Select Gender")){
	if(empty(document.getElementById('customerPhone'),"Customer Phone is required")){
	if(empty(document.getElementById('customerAddress1'),"Customer Address is required")){
	if(empty(document.getElementById('customerCity'),"Customer City is required")){
	if(empty(document.getElementById('customerState'),"Customer State is required")){
	if(empty(document.getElementById('customerZip'),"Customer ZIP Code is required")){
	if(empty(document.getElementById('ccnum'),"CC Number is required", 11)){
	if(reqLength(document.getElementById('ccexpmonth'),"2-Digit Expiration Month is required", 2)){
	if(reqLength(document.getElementById('ccexpyear'),"2-Digit Expiration Year is required", 2)){
	if(empty(document.getElementById('cvv'),"CVV must be at least 3-digits", 3)){
	if(checkCCExp(document.getElementById('ccexpmonth'),document.getElementById('ccexpyear'),"CC is expired")){
	if(empty(document.getElementById('dob'),"DOB is required")){
		return true;
	}}}}}}}}}}}}}}
	return false;

}

function formValidator(){
	if(empty(document.getElementById('customerFname'),"Customer First Name is required")){
	if(empty(document.getElementById('customerLname'),"Customer Last Name is required")){
	if(gender(document.getElementById('gender'),"Must Select Gender")){
	if(empty(document.getElementById('customerPhone'),"Customer Phone is required")){
	if(empty(document.getElementById('customerAddress1'),"Customer Address is required")){
	if(empty(document.getElementById('customerCity'),"Customer City is required")){
	if(empty(document.getElementById('customerState'),"Customer State is required")){
	if(empty(document.getElementById('customerZip'),"Customer ZIP Code is required")){
	if(empty(document.getElementById('ccnum'),"CC Number is required", 11)){
	if(reqLength(document.getElementById('ccexpmonth'),"2-Digit Expiration Month is required", 2)){
	if(reqLength(document.getElementById('ccexpyear'),"2-Digit Expiration Year is required", 2)){
	if(empty(document.getElementById('cvv'),"CVV must be at least 3-digits", 3)){
	if(checkCCExp(document.getElementById('ccexpmonth'),document.getElementById('ccexpyear'),"CC is expired")){
	if(reqLength(document.getElementById('dob'),"DOB is required",4)){
		console.log("Starting address and cc verification functions");
		addVerify();
		ccCheck();
		initialInsert();
		return true;
	}}}}}}}}}}}}}}
	return false;
}

function checkCCExp(expmonth, expyear, msg){
	var d = new Date();
	var currMonth = (d.getMonth() + 1);
	var currYear = (d.getFullYear().toString()).substr(2,4);
	var expmonth = expmonth.value;
	var expyear = expyear.value;
	console.log(currMonth+" "+currYear+"|"+expmonth+" "+expyear);
	if(parseInt(expmonth) <= parseInt(currMonth) && parseInt(expyear) <= parseInt(currYear)) {
		alert("Credit Card is expired");
		return false;
	}
	return true;
}

function reqLength(elem, msg, length){
	if(elem.value.length != length){
		alert(msg);
		elem.focus();
		return false;
	}
	return true;
}


function empty(elem, msg){
	if(elem.value.length < 1){
		alert(msg, elem);
		elem.focus();
		return false;
	}
	return true;
}

function gender(elem,msg){
	if(elem.value == '------'){
		alert(msg, elem);
		elem.focus();
		return false;
	}
	return true;
}

function updateData() {
	console.log("updateDataButton processed");
	addVerify();
	ccCheck();;

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
		'&fname='+firstName+'&lname='+lastName+'&address1='+address1+'&address2='+address2+'&city='+city+'&state='+state+'&zip='+postalCode+'&ccnum='+cardNumber+'&ccexpmonth='+cardMonth+'&ccexpyear='+cardYear+'&cvv='+cardSecurityCode+'&dob='+dob+'&uniqueid='+uniqueid;

	console.log(ccVerificationStatus+' '+uniqueid);
	if(uniqueid == null) {
		alert("No record exists yet. Please use 'Verify' button instead.");
	}
	if(addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED' && uniqueid != null) {
		console.log("DOING DB UPDATE ON RECORD "+uniqueid);
		$.ajax({
			type: "POST",
			data: dataString,
			async: false,
			url: "record_update.php",
			success: function(data) {
				$("#loading-background").hide();
	   	    }
    	 });
	} else {
		alert("Check card or address information");
	}
}


function initialInsert() {
	var agentid = $("#agentID").val();
	var recid = $("#recID").val();
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

	var dataString = 'agentid='+agentid+'&recid='+recid+'&phone='+phoneNumber+'&email='+emailAddress+
		'&fname='+firstName+'&lname='+lastName+'&address1='+address1+'&address2='+address2+'&city='+city+
		'&state='+state+'&zip='+postalCode+'&ccnum='+cardNumber+'&ccexpmonth='+cardMonth+'&ccexpyear='+cardYear+'&cvv='+cardSecurityCode+'&dob='+dob+'&gender='+gender;

	console.log("CC VER STATUS: "+ccVerificationStatus+"  UNIQUEID: "+uniqueid);
	if(addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED' && uniqueid == null) {
		console.log("DOING INITIAL DB INSERT");
		$.ajax({
			type: "POST",
			data: dataString,
			async: false,
			url: "initial_insert.php",
			success: function(data) {
				uniqueid = data;
				console.log(uniqueid);
				$("#loading-background").hide();
	   	    }
    	 });
	}
}

function updateProgram(program, status) {
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

function authorizenetTran(price, program) {
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

function authorizenetVoidTran(program) {
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

function addVerify(){
	console.log("Running addverify function");
	var address1 = $("#customerAddress1").val();
	var address2 = $("#customerAddress2").val();
	var city = $("#customerCity").val();
	var state = $("#customerState").val();
	var zip = $("#customerZip").val();
	var dataString = 'address1='+address1+'&address2='+address2+'&city='+city+'&state='+state+'&zip='+zip;
			$("#loading-background").show();
            $.ajax({
	            type: "POST",
                url: "verify_address.php",
                data: dataString,
	 			dataType: 'JSON',
				async: false,
                success: function(data) {
					if(data.error == null){
						$('#customerAddress1').val(data.add2[0]);
						$('#customerAddress2').val(data.add1[0]);
						$('#customerCity').val(data.city[0]);
						$('#customerState').val(data.state[0]);
						$('#customerZip').val(data.zip[0]);
						addressVerificationStatus = 'VERIFIED';
						$('#verifyStatus').html("<li>ADDRESS "+addressVerificationStatus+" </li>");
						$('#add1div').removeClass("has-error");
						$('#add2div').removeClass("has-error");
						$('#citydiv').removeClass("has-error");
						$('#statediv').removeClass("has-error");
						$('#zipdiv').removeClass("has-error");
						$('#add1div').addClass("has-success");
						$('#add2div').addClass("has-success");
						$('#citydiv').addClass("has-success");
						$('#statediv').addClass("has-success");
						$('#zipdiv').addClass("has-success");
					}else{
						alert("Invalid Address, Please check and re-enter");
						addressVerificationStatus = 'UNVERIFIED';
						$('#verifyStatus').html("<li>ADDRESS UN-VERIFIED</li>");
						$('#add1div').removeClass("has-success");
						$('#add2div').removeClass("has-success");
						$('#citydiv').removeClass("has-success");
						$('#statediv').removeClass("has-success");
						$('#zipdiv').removeClass("has-success");
						$('#add1div').addClass("has-error");
						$('#add2div').addClass("has-error");
						$('#citydiv').addClass("has-error");
						$('#statediv').addClass("has-error");
						$('#zipdiv').addClass("has-error");
					}
					console.log(data.city[0]);
					$("#loading-background").hide();
               }
          });
}

function ccCheck() {
		console.log("CC Check function");
               var ccnum = $("#ccnum").val();
		        var dataString = 'ccnum='+ccnum;
				if (ccnum.length < 11 || ccnum.length > 19){
					alert("A CC number is required");
					return false;
				}
				if  (ccexpmonth.length < 2){
					alert("CC Exp. Month is required");
					return false;
				}
				if  (ccexpmonth.length < 2){
					alert("CC Exp. Month is required");
					return false;
				}
				if  (cvv.length < 3){
					alert("CVV is required");
					return false;
				}
				$("#loading-background").show();
                $.ajax({
                        type: "POST",
                        url: "luhncheck.php",
                        data: dataString,
						async: false,
						dataType: "json",
                        success: function(data) {
							$('#ccStatus').html("<li>Card Category: "+data.card_category+"</li><li>Type: "+data.card_type+"</li><li>Mod Pass: "+data.modcheck+"</li>");
							$("#loading-background").hide();
							if (data.modcheck == "TRUE") {
								console.log("mod check true");
								$("#ccnumdiv").removeClass("has-error");
								$("#ccexpmonthdiv").removeClass("has-error");
								$("#ccexpyeardiv").removeClass("has-error");
								$("#cvvdiv").removeClass("has-error");
								$("#ccnumdiv").addClass("has-success");
								$("#ccexpmonthdiv").addClass("has-success");
								$("#ccexpyeardiv").addClass("has-success");
								$("#cvvdiv").addClass("has-success");
								ccVerificationStatus = 'VERIFIED';
							}
							if (data.modcheck == "FALSE") {
								console.log("mod check false");
								ccVerificationStatus = 'UNVERIFIED';
								$("#ccnumdiv").removeClass("has-success");
								$("#ccexpmonthdiv").removeClass("has-success");
								$("#ccexpyeardiv").removeClass("has-success");
								$("#cvvdiv").removeClass("has-success");
								$("#ccnumdiv").addClass("has-error");
								$("#ccexpmonthdiv").addClass("has-error");
								$("#ccexpyeardiv").addClass("has-error");
								$("#cvvdiv").addClass("has-error");
							}
                        }
                });
}


$(document).ready(function() {
	$("#loading-background").css({ opacity: 0.8 });
    $("#authorizenet").click(function() {
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
			'&city='+city+'&state='+state+'&zip='+postalCode;
		$("#loading-background").show();
    	    $.ajax({
        	    type: "POST",
				dataType: 'JSON',
				async: false,
				data: dataString,
                url: "authorize_net.php",
                success: function(data) {
				alert(data.responseCode+' '+data.responseReason+data.transactionId)
					$("#loading-background").hide();
                }
            });
    });

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

		if(addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED' && uniqueid != null) {
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
		}
	});


	$("#ushopon").click(function() {
		if(document.getElementById("ushopli")){
			alert("U Shop already selected");
		}else{
			var state = $("#customerState").val().toUpperCase();
			console.log(state);
			if(state.match("XX|XY")){
				alert("Not enabled due to state omit : "+state);
			} else {
				if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED' && ushopEnroll != 'ENROLLED') {
					var authResponse = ushopAuthorize();
					console.log(authResponse['result']+" "+authResponse['oid']);
					if(authResponse['result'] == "SUCCESS"){
						alert("Successfully enrolled in USHOP. Transaction ID: "+authResponse['oid']);
						ushopEnroll = 'ENROLLED';
						updateProgram('ushop', 'Y');
						$("#programs").append("<li id='ushopli'> USHOP - PRE-AUTH APPROVED</li>");
						$("#ushopon").removeClass('btn-danger');
						$("#ushopon").addClass('btn-success');
						$("#ushopoff").removeClass('btn-success');
						$("#ushopoff").addClass('btn-danger');
					} else {
						console.log("ELSE");
					}
				} else {
					alert("Error: customer info incorrect/un-verified or already enrolled.");
				}
			}
		}
	});

	$("#ushopoff").click(function() {
		if(ushopEnroll == 'ENROLLED'){
			alert("Transaction successfully VOIDED.");
			idmaxEnroll = 'false';
			updateProgram('ushop', 'N');
			$("#ushopli").remove();
			$("#ushopon").removeClass('btn-success');
			$("#ushopon").addClass('btn-danger');
			$("#ushopoff").removeClass('btn-danger');
			$("#ushopoff").addClass('btn-success');
		}
	});



	$("#idmaxon").click(function() {
		idmaxEnroll = true;
		if(document.getElementById("idmaxli")){
			alert("ID MAX already selected");
		}else{
			var state = $("#customerState").val().toUpperCase();
			console.log(state);
			if(state.match("ND|NY")){
				alert("Not enabled due to state omit : "+state);
			} else {
				if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED' && idmaxEnroll != 'ENROLLED') {
					var authResponse = authorizenetTran('3.95','idmax');
					console.log(authResponse);
					if(authResponse == "APPROVED"){
						idmaxEnroll = 'ENROLLED';
						updateProgram('idmax', 'Y');
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
			var voidResponse = authorizenetVoidTran('idmax');
			if(voidResponse == "APPROVED"){
				alert("Transaction successfully VOIDED.");
				idmaxEnroll = 'false';
				updateProgram('idmax', 'N');
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
		idmaxEnroll = true;
		if(document.getElementById("greatfunli")){
			alert("GREAT FUN already selected");
		} else {
			var state = $("#customerState").val().toUpperCase();
			console.log(state);
			if(state.match("IA|ID|VT")){
				alert("Not enabled due to state omit : "+state);
			} else {
	            if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED') {
					updateProgram('greatfun', 'Y');
					$("#programs").append("<li id='greatfunli' >GREAT FUN</li>");
					$("#greatfunon").removeClass('btn-danger');
					$("#greatfunon").addClass('btn-success');
					$("#greatfunoff").removeClass('btn-success');
					$("#greatfunoff").addClass('btn-danger');
				} else {
					alert("Address and Credit Card must be verified before adding programs.");
				}
			}
		}
	});

	$("#greatfunoff").click(function() {
		idmaxEnroll = false;
		updateProgram('greatfun', 'N');
		$("#greatfunli").remove();
		$("#greatfunon").removeClass('btn-success');
		$("#greatfunon").addClass('btn-danger');
		$("#greatfunoff").removeClass('btn-danger');
		$("#greatfunoff").addClass('btn-success');
	});

	$("#shopadvon").click(function() {
		idmaxEnroll = true;
		if(document.getElementById("shopadvli")){
			alert("SHOPPERS ADVANTAGE already selected");
		} else {
			var state = $("#customerState").val().toUpperCase();
			console.log(state);
			if(state.match("AK|HI|IA|ID|VT")){
				alert("Not enabled due to state omit : "+state);
			} else {
		        if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED') {
					updateProgram('shoppersadv', 'Y');
					$("#programs").append("<li id='shopadvli'>SHOPPERS ADV</li");
					$("#shopadvon").removeClass('btn-danger');
					$("#shopadvon").addClass('btn-success');
					$("#shopadvoff").removeClass('btn-success');
					$("#shopadvoff").addClass('btn-danger');
				} else {
					alert("Address and Credit card must be verified before adding programs.");
				}
			}
		}
	});

	$("#shopadvoff").click(function() {
		idmaxEnroll = false;
		updateProgram('shoppersadv', 'N');
		$("#shopadvli").remove();
		$("#shopadvon").removeClass('btn-success');
		$("#shopadvon").addClass('btn-danger');
		$("#shopadvoff").removeClass('btn-danger');
		$("#shopadvoff").addClass('btn-success');
	});

	$("#advpluson").click(function() {
		idmaxEnroll = true;
		if(document.getElementById("advplusli")){
			alert("ADVANTAGE PLUS already selected");
		} else {
	        if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED') {
				updateProgram('advplus', 'Y');
				$("#programs").append("<li id='advplusli'>ADVANTAGE PLUS</li");
				$("#advpluson").removeClass('btn-danger');
				$("#advpluson").addClass('btn-success');
				$("#advplusoff").removeClass('btn-success');
				$("#advplusoff").addClass('btn-danger');
			} else {
				alert("Address and Credit Card number must be verified before adding programs.");
			}
		}
	});

	$("#advplusoff").click(function() {
		idmaxEnroll = false;
		updateProgram('advplus', 'N');
		$("#advplusli").remove();
		$("#advpluson").removeClass('btn-success');
		$("#advpluson").addClass('btn-danger');
		$("#advplusoff").removeClass('btn-danger');
		$("#advplusoff").addClass('btn-success');
	});

	$("#healthwellon").click(function() {
		idmaxEnroll = true;
		if(document.getElementById("healthwellli")){
			alert("HEALTH AND WELLNESS already selected");
		} else {
	        if (addressVerificationStatus == 'VERIFIED' && ccVerificationStatus == 'VERIFIED') {
				updateProgram('healthwell', 'Y');
				var authResponse = authorizenetTran('9.95','healthwell');
				console.log(authResponse);
				if(authResponse == "APPROVED"){
					healthwellEnroll = 'ENROLLED';
					$("#programs").append("<li id='healthwellli' >HEALTH AND WELLNESS - PRE-AUTH APPROVED</li>");
					$("#healthwellon").removeClass('btn-danger');
					$("#healthwellon").addClass('btn-success');
					$("#healthwelloff").removeClass('btn-success');
					$("#healthwelloff").addClass('btn-danger');
					} else {
						alert(authResponse);
					}
			} else {
				alert("Address and Credit Card number must be verified before adding programs.");
			}
		}
	});

	$("#healthwelloff").click(function() {
		console.log(healthwellEnroll);
		if(healthwellEnroll == 'ENROLLED'){
			var voidResponse = authorizenetVoidTran('healthwell');
			if(voidResponse == "APPROVED"){
				alert("Transaction successfully VOIDED.");
				healthwellEnroll = 'false';
				updateProgram('healthwell', 'N');
				$("#healthwellli").remove();
				$("#healthwellon").removeClass('btn-success');
				$("#healthwellon").addClass('btn-danger');
				$("#healthwelloff").removeClass('btn-danger');
				$("#healthwelloff").addClass('btn-success');
			} else {
				alert("There was an ERROR voiding transaction.");
			}
		}
	});


function ushopAuthorize() {
	var returnResult;
	var returnId;
		console.log("SENDING TO USHOP API");
		var emailAddress = $("#customerEmail").val();
		var phoneNumber = $("#customerPhone").val();
		var firstName = $("#customerFname").val();
		var lastName = $("#customerLname").val();
		var address1 = $("#customerAddress1").val();
		var address2 = $("#customerAddress2").val();
		var city = $("#customerCity").val();
		var state = $("#customerState").val();
		var country = "US";
		var postalCode = $("#customerZip").val();
		var shipFirstName = $("#customerFname").val();
		var shipLastName = $("#customerLname").val();
		var shipAddress1 = $("#customerAddress1").val();
		var shipAddress2 = $("#customerAddress2").val();
		var shipCity = $("#customerCity").val();
		var shipState = $("#customerState").val();
		var shipCountry = "US";
		var shipPostalCode = $("#customerZip").val();
		var couponCode = "";
		var paySource = "CREDITCARD";
		var cardNumber = $("#ccnum").val();
		var cardSecurityCode = $("#cvv").val();
		var cardYear = $("#ccexpyear").val();
		var cardMonth = $("#ccexpmonth").val();
		var campaignId = "13";
		var product1_id = "59";
		var product1_qty = "1";
		var dataString = '&emailAddress='+emailAddress+'&phoneNumber='+phoneNumber+'&firstName='+firstName+'&lastName='+lastName+'&address1='+address1+'&address2='+address2
			+'&city='+city+'&state='+state+'&country='+country+'&postalCode='+postalCode+'&shipFirstName='+shipFirstName+'&shipLastName='+shipLastName+'&shipAddress1='+shipAddress1
			+'&shipAddress2='+shipAddress2+'&shipCity='+shipCity+'&shipState='+shipState+'&shipCountry='+shipCountry+'&shipPostalCode='+shipPostalCode+'&couponCode='+couponCode
			+'&paySource='+paySource+'&cardNumber='+cardNumber+'&cardSecurityCode='+cardSecurityCode+'&cardYear='+cardYear+'&cardMonth='+cardMonth+'&campaignId='+campaignId
			+'&product1_id='+product1_id+'&product1_qty='+product1_qty;

		$("#loading-background").show();
        $.ajax({
			type: "POST",
			url: "ushop_authorize.php",
			dataType: "json",
			data: dataString,
			async: false,
			success: function(data) {
				returnResult = data.result;
				returnId = data.message['orderId'];
				$("#loading-background").hide();
				}
		});
	return {result: returnResult, oid: returnId}
	}

    $("#updateDataButton").click(function() {
		console.log("updateDataButton clicked");
		updateData();
    });

    $("#submit").click(function() {
		return formValidator();
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
				<label for="ushop">U Shop</label>
				<div class="btn-group btn-toggle" id="ushop">
				    <button id="ushopon" class="btn btn-sm btn-danger">ON</button>
				    <button id="ushopoff" class="btn btn-sm btn-success">OFF</button>
				</div>
			</li>
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
				<input type="text" class="form-control" id="customerPhone" placeholder="" value="<? echo $_GET['phone_number']; ?>">
			</div>
		</div> <!--col-sm-3-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerFname">Customer First Name</label>
				<input type="text" class="form-control" id="customerFname" placeholder="" value="<? echo $_GET['First']; ?>">
			</div>
		</div>  <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerLname">Customer Last Name</label>
				<input type="text" class="form-control" id="customerLname" placeholder="" value="<? echo $_GET['Last']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="customerEmail">Customer Email</label>
				<input type="text" class="form-control" id="customerEmail" placeholder="" value="<? echo $_GET['Email']; ?>">
			</div>
		</div> <!--col-->

	</div> <!--row-->

	<div class="row">																 <!--ROW2-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="add1div">
				<label for="customerAddress1">Customer Address1</label>
				<input type="text" class="form-control" id="customerAddress1" placeholder="" value="<? echo $_GET['Address']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="add2div">
				<label for="customerAddress2">Customer Address2</label>
				<input type="text" class="form-control" id="customerAddress2" placeholder="" value="<? echo $_GET['Address2']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="citydiv">
				<label for="customerCity">Customer City</label>
				<input type="text" class="form-control" id="customerCity" placeholder="" value="<? echo $_GET['city']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="statediv">
				<label for="customerState">Customer State</label>
				<input type="text" class="form-control" id="customerState" value="<? echo $_GET['State']; ?>">
			</div>
		</div> <!--col-->
	</div> <!--row-->

	<div class="row">																													<!--ROW3-->
		<div class="col-sm-3">
			<div class="form-group has-feedback" id="zipdiv">
				<label for="customerZip">Customer ZIP</label>
				<input type="text" class="form-control" id="customerZip" placeholder="" value="<? echo $_GET['Zip']; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="dob">DOB</label>
				<input type="text" class="form-control dob" id="dob" placeholder="" value="">
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
				<input type="text" class="form-control" id="ccnum" placeholder="" value="<? echo $ccstring[0]; ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="ccexpmonthdiv" class="form-group has-feedback">
				<label for="ccexpmonth">Exp. Month</label>
				<input type="text" class="form-control" id="ccexpmonth" value="<? echo substr($ccstring[1], 0,2); ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="ccexpyeardiv" class="form-group has-feedback">
				<label for="ccexpyear">Exp. Year</label>
				<input type="text" class="form-control" id="ccexpyear" placeholder="" value="<? echo substr($ccstring[1], 2,4); ?>">
			</div>
		</div> <!--col-->
		<div class="col-sm-3">
			<div id="cvvdiv" class="form-group">
				<label for="cvv">CVV</label>
				<input type="text" class="form-control" id="cvv" placeholder="" value="<? echo $ccstring[2]; ?>">
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
			 <ul class="list-inline">
					<button type="button" class="btn btn-success" id="submit">Verify Information</button>
			</ul>
		</div> <!--col-6-->
		<div class="col-sm-3">
			<button type="button" class="btn btn-danger" id="finalize">FINALIZE ENROLLMENT</button>
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
<input type="hidden" id="agentID" value="<? echo $_GET['RepId']; ?>">
<input type="hidden" id="recID" placeholder="" value="<? echo $_GET['RecId']; ?>">

</body>
</html>

