<?php

include_once '../class.inc.php';
$c=new Catagory();
echo '<div id="sidebar"><center>';
$main = new Project11();
if (isset($_GET['logout']))
{
	setcookie('user','Deleted',time()-3600);
	setcookie('key','Deleted',time()-3600);
}
echo '</center><a href="../index.php">Main</a><br>';
echo '<br></div>'; // for sidebar
?>
