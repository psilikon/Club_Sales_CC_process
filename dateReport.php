<!DOCTYPE html>
<html lang="en">
	<title>DATE REPORT</title>
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
</style>
<script type="application/javascript">

function runReport() {
    var date = $("#datepicker").val();
    var dataString = 'date='+date;
    $.ajax({
        type: "POST",
        url: "runDateReport.php",
        data: dataString,
        success: function(data) {
			console.log(date);
			$("#returnData").html(data);
        }
     });
}


$(document).ready(function() {
	console.log("Ready");
	$("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });

	$("#submit").click(function() {
		runReport();
	});
});

</script>
<body>
<div class="navbar navbar-default" role="navigation">
	<div class="container">
		<input id="datepicker" type="text" value="">
		<button id="submit" type="button" value="submit">Submit</button>
	</div>
</div>
<div class="container">
<div id="returnData">
</div>
<div id="loading-background">
    <div id="loading" class="ui-corner-all" >
      <img style="height:80px;margin:30px;" src="loading.gif" alt="Loading.."/>
      <h2 style="color:gray;font-weight:normal;">Please wait....</h2>
     </div>
</div>

</body>
</html>

