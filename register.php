<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
</head>
<script type="text/javascript">
<!--
function checkRegInput()
{
	if (document.getElementsByName("phone")[0].value.length<10)
	{
		alert("Please Enter Phone Number of atleast 10 numbers\n for landline numbers prefix the are code");
		document.getElementsByName("phone")[0].focus();
	}
	else
	{	
		document.getElementsByName("register")[0].value="true";
		document.getElementsByName("regform")[0].submit();
	}

}
function showReg()
{
	document.getElementById("regText").innerHTML='Reg Number';
	document.getElementsByName("regno")[0].type='text';
	document.getElementsByName("name")[0].focus();

}
function checkOutInput()
{
	if (document.getElementsByName("name")[0].value=='')
	{
		alert("Please Enter Name");
		document.getElementsByName("name")[0].focus();
	}
	else if (document.getElementsByName("sem")[0].value=='')
	{
		alert("Please Enter Sem");
		document.getElementsByName("sem")[0].focus();
	}
	else if (document.getElementsByName("cllg")[0].value=='')
	{
		alert("Please Enter College Name");
		document.getElementsByName("cllg")[0].focus();
	}
	else if (document.getElementsByName("phone")[0].value.length<10)
	{
		alert("Please Enter Phone Number of atleast 10 numbers\n for landline numbers prefix the are code");
		document.getElementsByName("phone")[0].focus();
	}
	else
	{
		document.getElementsByName("regout")[0].value="true";
		document.getElementsByName("outform")[0].submit();
	}
}
//-->
</script>
<?php
if (isset($_POST['reg']) and $_POST['regno'] !='' )//For setting the focus
	$element = "phone"; 
else if (isset($_POST['out']))
	$element="name";
else
	$element = "regno";
echo "<body onload='document.getElementsByName(\"{$element}\")[0].focus()'>";
include "header.php";
include "sidebar.php"; ?>
<div id="center">
<center>
<?php
$r = new Registeration();
$goBack = "<a href='{$SERVER['PHP_SELF']}'>Back</a>";

if (True)// TODO check everything here
{
	$level = $r->checkAuth($_COOKIE['user'],$_COOKIE['key']);
	if ($level=="admin" or $level=="reg")
	{
		if (isset($_POST['reg']) and $_POST['regno'] !='')
		{
			$info=$r->getInfo($_POST['regno']);
			if ($info)
			{
				$name= ucwords(strtolower($info['name']));
				echo "<form method='POST' name='regform'><table width='50%'><tr><td>Reg No. </td><td>{$info['reg']}</td></tr><tr><td>Name </td><td>{$name}</td></tr><tr><td>Sem </td><td>{$info['sem']}</td></tr><tr><td>Phone </td><td><input type='text' name='phone'></td></tr><tr><td><center><input type='button' value='Register' onClick='checkRegInput()'></td><td><input type='submit' name='cancel' value='Cancel' ></center></td></tr></table><input type='hidden' name='regno' value='{$info['reg']}' /><input type='hidden' name='register' value='false'></form>";
			}
			else
			{
				echo "Registeration Number Not Found!!!<br>".$goBack;
			}
		}
		else if (isset($_POST['out']))
		{
			echo "<form name='outform' method='POST'><table width='50%'><tr><td>Name</td><td><input type='text' name='name'></td></tr><tr><td>Sem</td><td><input type='text' name='sem'></td></tr><tr><td>College</td><td><input type='text' name='cllg'></td></tr><tr><td>Phone </td><td><input type='text' name='phone'></td></tr><tr><td><div id='regText' /></div></td><td><input type='hidden' name='regno' /></td></tr><tr><td><center><input type='button' name='regbutton' value='Register' onClick='checkOutInput()'><input type='submit' name='cancel' value='Cancel' /><input type='hidden' name='regout' value='false'/><input type='button' onClick='showReg()' value='Not in DB'/></center></td></tr></table></form>";
		}
		else if ($_POST['register']=='true')
		{
			$delno = $r->reg($_POST['regno'],$_POST['phone']);
			if ($delno[0] == "error")
				echo "Error Occured, Please Try again<br>".$goBack;
			else if ($delno[0] == "reg")
				echo "Already Registered with delegate number <b>{$delno[1]}</b><br>".$goBack;
			else
				echo "Registered<br><b> Deligate Number - {$delno[0]}</b><br><br>".$goBack;
		}
		else if ($_POST['regout']=="true")
		{
			if ($_POST['regno']!='0' and isset($_POST['regno']))
			{
				$result = $r->regOut($_POST['name'],$_POST['sem'],$_POST['cllg'],$_POST['phone'],$_POST['regno']);
			}
			else
			{
				$result = $r->regOut($_POST['name'],$_POST['sem'],$_POST['cllg'],$_POST['phone']);
			}
			if ($result[0]=="reg")
			{
				echo "Already Registered with delegate number <b>{$result[1]}</b><br>".$goBack;
			}
			else if ($result[0]=="error")
			{
				echo "Error Occured, Please Try again<br>".$goBack;
			}
			else
			{
				echo "Registered<br><b> Deligate Number - {$result[0]}</b><br><br>".$goBack;
			}

		}
		else
		{
			echo "<form method='POST'>Enter the Registeration Number<br><input type='text' name='regno' /><br><input type='submit' name='reg' value='Register' /> <input type='submit' name='out' value='Out Station'></form>";
		}
	}
	else
	{
		echo "<br>You do not have Privlage to access this resource<br>";
	}
}

?>
</center>
</div>
<?php include "footer.php"; ?>
</body>
</html>
