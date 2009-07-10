<html>
<head>
<title><?php include_once "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php
$goBack = "<a href='index.php'>Back</a>";
include_once "class.inc.php";
if (isset($_GET['id']))
{
	$h = new Head();
	$hinfo = $h->getInfo($_GET['id']);
	echo "<center>User Info<br><table><tr><td><b>Name </b></td><td> {$hinfo['name']}</td></tr><tr><td><b>Phone </b></td><td> {$hinfo['phone']}</td></tr><tr><td><b>Level </b></td><td> {$hinfo['level']}</td></tr></table></center>";
}
else
{
	echo "Please select a User<br>".$goBack;
}
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
