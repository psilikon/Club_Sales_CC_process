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
</script>
<body>
<div class="navbar navbar-default" role="navigation">
	<div class="container">
		<form action="runUpdateDupe.php" method="post">
			Enter Account ID
			<input type="text" id="id" name="id" value="">
			<input id="submit" type="submit" value="Submit">
		</form>
	</div>
</div>
<div class="container">
<div id="returnData">
</div>
</body>
</html>

