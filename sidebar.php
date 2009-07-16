<?php

include_once 'class.inc.php';
$c=new Catagory();
echo '<div id="sidebar"><center>';
$main = new Project11();
if (isset($_GET['logout']))
{
	setcookie('user','Deleted',time()-3600);
	setcookie('key','Deleted',time()-3600);
}
$loginText = '</b><br><form method="POST">Username<br><input type="text" name="username"><br>Password<br><input type="password" name="password"><br><input type="submit" name="login" value="Login"></form>';
$level=''; // we want to use level for level check
if (!isset($_POST['login']))
{
	if (True)//TODO check everything here
	{
        if (isset($_COOKIE['user']) and isset($_COOKIE['key']))
        {
    		$userlevel = $main->checkAuth($_COOKIE['user'],$_COOKIE['key']);
        }
        else
        {
            $userlevel ='error';
        }
		if ($userlevel!='error' and !isset($_GET['logout']))
		{
			echo 'Hello <b>',$_COOKIE['user'],'</b><br><a href="index.php?logout=1">log out</a><br><br>';
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
    $level = $userlevel; // for check outside sidebar
}
else
{
	$auth=$main->login($_POST['username'],$_POST['password']);
	if ($auth[0]=="error")
    {
		echo '<br>Wrong Username/Password<br>',$loginText;
        $level = 'error';
    }
	else
	{
        $level = $auth[0];
		echo 'Welcome <b>',$_POST['username'],'</b><br><a href="index.php?logout=1">log out</a><br><br>';
		setcookie("user",$_POST['username'],time()+3600);
		setcookie("key",$auth[1],time()+3600);
	} 
}
echo '</center><a href="index.php">Home</a><br>';
echo '<a href="register.php">Main Registeration</a><br>';
echo '<a href="#" onclick="toggleCat()">Registeration</a><br><div id="sidebar-catagory"><br>';
$catagories = $c->getList();
foreach ($catagories as $cat)
{
	echo '<a href="regcat.php?id=',$cat['catid'],'">',ucwords($cat['name']),'</a><br>';
}
echo '<br></div><a href="#" onclick="toggleCatInfo()">Information</a><br><div id="sidebar-catagoryinfo"><br>';
foreach ($catagories as $cat)
{
	echo '<a href="catagory.php?id=',$cat['catid'],'">',ucwords($cat['name']),'</a><br>';
}
echo '<br></div><a href="./cbt/">CBT</a><br><a href="details.php">Details</a><br><a href="#" onclick="toggleAdmin()">Admin</a><br><div id="sidebar-admin"><br>';
if ($level== 'admin')
{
    echo '<a href="#" onclick="toggleAssign()">Do Assignment</a><br>';
    echo '<div id ="sidebar-assign"><br>';
    echo '<a href="admin.php?do=cathead">Catagory Head</a><br>';
    echo '<a href="admin.php?do=eventhead">Event Head</a><br>';
    echo '<a href="admin.php?do=eventorg">Organiser</a><br>';
    echo '<a href="admin.php?do=eventvol">Volunteer</a><br>';
    echo '<a href="admin.php?do=eventcat">Event To Catagory</a><br>';
    echo '<br></div>';

    echo '<a href="#" onclick="toggleAssignrm()">Remove Assignment</a><br>';
    echo '<div id ="sidebar-rmassign"><br>';
    echo '<a href="admin.php?do=cathead">Catagory Head</a><br>';
    echo '<a href="admin.php?do=eventhead">Event Head</a><br>';
    echo '<a href="admin.php?do=eventorg">Organiser</a><br>';
    echo '<a href="admin.php?do=eventvol">Volunteer</a><br>';
    echo '<a href="admin.php?do=eventcat">Event To Catagory</a><br>';
    echo '<br></div>';

    echo '<a href="admin.php?do=resetpass">Reset Passowrd</a><br>';
    echo '<a href="admin.php?do=editcat">Catagory Info</a><br>';
    echo '<a href="admin.php?do=addhead">Add Head</a><br>';
    echo '<a href="admin.php?do=addevent">Add Event</a><br>';
    echo '<a href="admin.php?do=addcat">Add Catagory</a><br>';
    echo '<a href="admin.php?do=rmhead">Remove Head</a><br>';
    echo '<a href="admin.php?do=rmevent">Remove Event</a><br>';
    echo '<a href="admin.php?do=rmcat">Remove Catagory</a><br>';
}
else
{
    echo '<a href="#" onclick="alert(\'No Admin Access for you!!!\')">No Admin Access</a><br>';
}
echo '<br></div>';

echo '<br></div>'; // for sidebar
?>
