<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<?php
include_once "class.inc.php";
if (isset($_GET['id']))
{
	echo "<div id='center'><center><table width='60%'>";
	$c = new Catagory();
	$c->setId($_GET['id']);
	$cinfo = $c->getInfo($_GET['id']);
	$events = $c->getEvents();
	$e = new Event();
	echo "<tr><td>Catagory </td><td><b>".ucwords($cinfo['name'])."</b></td></tr><tr><td>Info</td><td>{$cinfo['info']}</td></tr><tr><td>Catagory Head(s) </td><td>";
	$count=0;
	$cheads = $c->getHeads();
	foreach ($cheads as $chead)
	{
		if ($count)
			echo ", ";
		echo "<a href='head.php?id={$chead['userid']}'>{$chead['name']}</a>";
		$count++;

	}
	echo "</td></tr><tr><td><br><br></td></tr";
	foreach ($events as $event)
	{
		$e->setId($event['eventid']);
		echo "<tr><td>Event</td><td><b>".$event['name']."</b></td></tr><tr><td>Info</td><td>".$event['info']."</td></tr><tr><td>Event Head(s) </td><td>";
		$heads= $e->getHeads("head"); //event heads
		$count =0;
		foreach($heads as $head)
		{
			if ($count)
				echo ", ";
			echo "<a href='head.php?id={$head['userid']}'>{$head['name']}</a>";
			$count++;
		}
		if ($count ==0)
			echo " None Assigned";

		echo "</td></tr><tr><td>Organiser(s)</td><td>";
		$heads= $e->getHeads("org");//organisers
		$count =0;
		foreach($heads as $head)
		{
			if ($count)
				echo ", ";
			echo "<a href='head.php?id={$head['userid']}'>{$head['name']}</a>";
			$count++;
		}
		if ($count ==0)
			echo " None Assigned";

		echo "</td></tr><tr><td>Volunter(s) </td><td> ";
		$heads= $e->getHeads("vol");//volentures
		$count =0;
		foreach($heads as $head)
		{
			if ($count)
				echo ", ";
			echo "<a href='head.php?id={$head['userid']}'>{$head['name']}</a>";
			$count++;
		}
		if ($count ==0)
			echo " None Assigned";

		echo "</td></tr><tr><td><br><br></td></tr>";
	}

	echo "</table><br><br></center></div>";
}
else
{
	echo "<div id='center'><b>Please Select A Catagory</b></div>";
}

?>

<?php include "footer.php"; ?>
</body>
</html>
