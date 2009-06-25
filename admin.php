<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
<script type='text/javascript'>
function checkInput(formname)
{
	if (document.getElementsByName("name")[0].value=='')
	{
		alert("Please Enter Name");
		document.getElementsByName("name")[0].focus();
	}
	else if (document.getElementsByName("username")[0].value=='')
	{
		alert("Please Enter username");
		document.getElementsByName("username")[0].focus();
	}
	else if (document.getElementsByName("phone")[0].value.length<10)
	{
		alert("Please Enter Phone Number of atleast 10 numbers\n for landline numbers prefix the are code");
		document.getElementsByName("phone")[0].focus();
	}
	else
	{
        checkPassword(formname);
	}
}
function rmHead()
{
    if (confirm("Are you sure you want to remove this user?")) 
    {
        document.getElementsByName("rmheadform")[0].submit();    
    }
}
function checkAddEventInput()
{
    if (document.getElementsByName("name")[0].value=='')
    {
        alert("Please Enter a Name");
    }
    else if (document.getElementsByName("info")[0].value=='')
    {
        alert("Please Enter Information about the Event");
    }
    else
    {    
        document.getElementsByName("addeventform")[0].submit();
    }
}

function checkPassword(formname)
{
    var pass1 = document.getElementsByName("password1")[0];
    var pass2 = document.getElementsByName("password2")[0];
    if (pass1.value.length>5  && pass1.value==pass2.value)
    {
        document.getElementsByName(formname)[0].submit();
    }
    else
    {
        alert("minimum length is 6 and both passwords should match");
    }
}
</script>
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div id="center">
<?php
// $level from sidebar after user check
if (isset($_GET['do']) and $level == 'admin')
{
    echo '<center>';
    switch ($_GET['do'])
    {
        case 'resetpass':
        // case resetpass
            $h = new Head();
            if (isset($_POST['resetpass']))
            {
                if ($_POST['password1'] == $_POST['password2'])
                {
                    if ($h->resetPass($_POST['user'], $_POST['password1']) == "done")
                    {
                        echo 'Password for ',$_POST['user'], ' changed';
                    }
                    else
                    {
                        echo 'some error occured';
                    }
                }
                else
                {
                    echo "Passwords dont match";
                }
            }
            else
            {
                echo '<form method ="POST" name="resetform" >Reset Password for<br><select name="user" >';
                foreach ( $h->getList() as $head)
                {
                    echo '<option>',$head['username'],'</option>';
                }
                echo '</select><br>Password<br><input type="password" name="password1" /><br>Confirm<br><input type="password" name="password2" /><br><input type="button"  name ="reset" value="Reset" onclick="checkPassword(\'resetform\')"/><input type="hidden" name="resetpass" value="resetpass" /></form>';
            }
        break;

        case 'editcat':
        //case editcat
            $c = new Catagory();
            if (isset($_GET['catid']))
            {
                if (isset($_POST['editcat']) and isset($_POST['catinfo']))
                {
                    if ($c->setInfo($_GET['catid'],$_POST['catinfo']) == 'done')
                    {
                        echo 'Done';
                    }
                    else
                    {
                        echo "Sorry an error ocurred";
                    }
                }
                else
                {
                    $catinfo = $c->getInfo($_GET['catid']);
                    echo '<form method="POST" name="catinfoform"><table width="40%"><tr><td>Name</td><td>',$catinfo['name'],'</td></tr><tr><td>Info</td><td><textarea rows="10" cols="50" name="catinfo" >',$catinfo['info'],'</textarea></td></tr></table><input type="submit" value="Change" name="editcat"/></form>';
                }
            }
            else
            {
                echo 'Select a Catgory<br>';
                foreach ($c->getList() as $cat)
                {
                    echo '<a href="admin.php?do=editcat&catid=',$cat['catid'],'">',$cat['name'],'</a><br>';
                }
            }
        break;

        case 'addhead':
        // case addhead
            $h = new Head();
            if (isset($_POST['addhead']))
            {
                if (($_POST['password1'] == $_POST['password2']) and ($_POST['password1'] != ''))
                {
                    if ($_POST['username'] and $_POST['name'] and $_POST['level'] and $_POST['phone'])
                    {
                        $username = split('[^a-zA-Z0-9_.]',$_POST['username']);//testing username for invalid characters
                        if ($username[0] == $_POST['username'])
                        {
                            $result = $h->add($_POST['username'],$_POST['password'],$_POST['name'],$_POST['phone'],$_POST['level']);
                            echo $result;
                        }
                        else
                        {
                            echo 'Username -> <b>',$_POST['username'],'</b> not supported';
                        }
                    }
                    else
                    {
                        echo 'Please fill all the information';
                    }
                }
                else
                {
                    echo "Passwords dont match";
                }
            }
            else
            {
                echo '<form method ="POST" name="addheadform" >Add a new Head<br><table><tr><td>Name</td><td><input type="text" name="name" /></td></tr><tr><td>Username </td><td><input type="text" name="username" ></td></tr><tr><td>Password<td><input type="password" name="password1" /></td></tr><tr><td>Confirm Password</td><td><input type="password" name="password2" /></td></tr><tr><td>Phone</td><td><input type="text" name="phone" /></td></tr><tr><td>Level</td><td>';
                echo '<select name="level"><option>reg</option><option>chead</option><option>ehead</option><option>org</option><option>vol</option><option>admin</option></select>';
                echo '</table>     <input type="button"   value="Add" onclick="checkInput(\'addheadform\')"/><input type="hidden" name="addhead" value="addhead" /></form>';
            }
        break;

        case 'addevent':
        // case addevent
            if (isset($_POST['addevent']))
            {
                if (isset($_POST['name']) and isset($_POST['info']) and isset($_POST['team']))
                {
                    $e = new Event();
                    $result = $e->add($_POST['name'],$_POST['team'],$_POST['info']);
                    echo $result;
                }
                else
                {
                    echo 'Please check your entries';
                }
            }
            else
            {
                echo '<form method ="POST" name="addeventform" >Add a new Event<br><table><tr><td>Name</td><td><input type="text" name="name" /></td></tr><tr><td>Info</td><td><textarea name="info" rows="10" cols="50"></textarea></td></tr><tr><td>Team Event</td><td><select name="team"><option>no</option><option>yes</option></select></td></tr></table><input type="button" value="Add" onclick="checkAddEventInput()"/><input type="hidden" name="addevent" value="addevent" /></form>';
            }
        break;

        case 'addcat':
        // case addevent
            if (isset($_POST['addcat']))
            {
                if (isset($_POST['name']) and isset($_POST['info']))
                {
                    $c = new Catagory();
                    $result = $c->add($_POST['name'],$_POST['info']);
                    echo $result;
                }
                else
                {
                    echo 'Please check your entries';
                }
            }
            else
            {
                echo '<form method ="POST" name="addeventform" >Add a new Catagory<br><table><tr><td>Name</td><td><input type="text" name="name" /></td></tr><tr><td>Info</td><td><textarea name="info" rows="10" cols="50"></textarea></td></tr></table><input type="button" value="Add" onclick="checkAddEventInput()"/><input type="hidden" name="addcat" value="addcat" /></form>'; // checkAddEventInput will also work for this
            }
        break;

        case 'rmhead':
        // case rmhead
            if (isset($_POST['rmhead']))
            {
                if (isset($_POST['name']))
                {
                    $h = new Head();
                    $result = $h->rem($_POST['name']);
                    if ($result =="done")
                    {
                        echo 'user <b>',$_POST['name'],'</b> removed';
                    }
                    else
                    {
                        echo 'an error occured while trying to remove';
                    }
                }
                else
                {
                    echo 'Please check your entries';
                }
            }
            else
            {
                $h = new Head();
                echo '<form method="POST" name="rmheadform">Select a User To Remove<br><select name="name">';
                foreach($h->getList() as $head)
                {
                    echo '<option>',$head['username'],'</option><br><br>';
                }
                echo '</select><br><input type="hidden" name="rmhead" value="rmhead"/><input type="button" value="Remove" onclick="rmHead()" /></form>';
            }
        break;

    }
    echo '</center>';
}
else
{
    echo "Please Select Something from Admin";
}
?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
