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
<p class="center">
<a href="register.php">Main Registeration</a><br>
<?php
$catagories = $c->getList();
foreach ($catagories as $cat)
{
	echo "<a href='regcat.php?id={$cat['catid']}'>{$cat['name']}</a><br>";
}
?>
</p>
<?php include "footer.php"; ?>
</body>
</html>
