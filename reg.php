<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
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
