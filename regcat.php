<html>
<head>
<title>TechTatva 09</title>
<link rel="stylesheet" href="main.css" type="text/css" />
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php

$c = new Catagory();
$e = new Event();
$goBack = "<a href='reg.php'>Back</a>";
$r = new Registeration();
if (True)//TODO check everything here
{
	$level = $r->checkAuth($_COOKIE['user'],$_COOKIE['key']);
	if ($level=="admin" or $level=="reg")
	{
	}
	$c = new Catagory();
	$c->setId($_GET['id']);
	if ($c->hasPermission($_COOKIE['user']))
	{
		echo "Welcome";
	}
	else
	{
		echo "You do not have Privlage to access this resource<br>".$goBack;
	}
}

?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
