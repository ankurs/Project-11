<?php

include_once "class.inc.php";
$c=new Catagory();
echo '<div id="sidebar"><b>Menu</b><br><br>';
$main = new Project11();
if (isset($_GET['logout']))
{
	setcookie("user","Deleted",time()-3600);
	setcookie("key","Deleted",time()-3600);
}
$loginText = "</b><br><form method='POST'>Username<br><input type='text' name='username'><br>Password<br><input type='password' name='password'><br><input type='submit' name='login' value='Login'></form>";
if (!isset($_POST['login']))
{
	if (True)//TODO check everything here
	{
		$level = $main->checkAuth($_COOKIE['user'],$_COOKIE['key']);
		if ($level!="error" and !isset($_GET['logout']))
		{
			echo "Hello <b>{$_COOKIE['user']}</b><br><a href='index.php?logout=1'>log out</a><br><br>";
		}
		else
		{
			echo $loginText;
		}
	}
	else
	{
		echo $loginText;
	}
}
else
{
	$auth=$main->login($_POST['username'],$_POST['password']);
	if ($auth[0]=="error")
		echo "<br>Wrong Username/Password<br>".$loginText;
	else
	{
		echo "Welcome <b>{$_POST['username']}</b><br><a href='index.php?logout=1'>log out</a><br><br>";
		setcookie("user",$_POST['username'],time()+3600);
		setcookie("key",$auth[1],time()+3600);
	} 
}
echo '<a href="index.php">Home</a><br>';
echo '<a href="reg.php">Registeration</a><br>';
$catagories = $c->getList();
foreach ($catagories as $cat)
{
	echo "<a href='catagory.php?id={$cat['catid']}'>{$cat['name']}</a><br>";
}
echo '<br></div>';
?>
