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
    if (confirm("Are you sure you want to remove this Head?")) 
    {
        document.getElementsByName("rmheadform")[0].submit();    
    }
}
function rmEvent()
{
    if (confirm("Are you sure you want to remove this Event?")) 
    {
        document.getElementsByName("rmeventform")[0].submit();    
    }
}
function rmCat()
{
    if (confirm("Are you sure you want to remove this Catagory?")) 
    {
        document.getElementsByName("rmcatform")[0].submit();    
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
                            $result = $h->add($_POST['username'],$_POST['password1'],$_POST['name'],$_POST['phone'],$_POST['level']);
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
                        echo 'Head <b>',$_POST['name'],'</b> removed';
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

        case 'rmevent':
        // case rmevent
            if (isset($_POST['rmevent']))
            {
                if (isset($_POST['name']))
                {
                    $e = new Event();
                    $result = $e->rem($_POST['name']);
                    if ($result =="done")
                    {
                        echo 'Event <b>',$_POST['name'],'</b> removed';
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
                $e = new Event();
                echo '<form method="POST" name="rmeventform">Select an Event To Remove<br><select name="name">';
                foreach($e->getList() as $event)
                {
                    echo '<option>',$event['name'],'</option><br><br>';
                }
                echo '</select><br><input type="hidden" name="rmevent" value="rmevent"/><input type="button" value="Remove" onclick="rmEvent()" /></form>';
            }
        break;

        case 'rmcat':
        // case remove catagory
            if (isset($_POST['rmcat'])) // if a catagory is submited
            {
                if (isset($_POST['name'])) //if the name of catagory is set
                {
                    $c = new Catagory();
                    $c->select($_POST['name']); // select the catagory to be removed
                    $result = $c->rem($c->getId()); // delete the catagory
                    if ($result =="done")
                    {
                        // everything ok
                        echo 'Catagory <b>',$_POST['name'],'</b> removed';
                    }
                    else
                    {
                        // some error
                        echo 'an error occured while trying to remove';
                    }
                }
                else
                {
                    // if catagory name was not set
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all catagories
                $c = new Catagory();
                echo '<form method="POST" name="rmcatform">Select a Catagory To Remove<br><select name="name">';
                foreach($c->getList() as $cat)
                {
                    // name of all catagories in from the DB
                    echo '<option>',$cat['name'],'</option><br><br>';
                }
                // we set a hidden input rmcat to rmcat, so that we know we want to remove a catagory
                echo '</select><br><input type="hidden" name="rmcat" value="rmcat"/><input type="button" value="Remove" onclick="rmCat()" /></form>';
            }
        break;

        case 'cathead':
        // case -> assign catagory head 
            if (isset($_POST['cathead'])) // if catagory and head is selected
            {
                if (isset($_POST['catname']) and isset($_POST['headname'])) //checking if catagory and head names are set
                {
                    $c= new Catagory();
                    $h= new Head();
                    if ($c->select($_POST['catname'])) // we try to select the catagory
                    {
                        if($h->select($_POST['headname'])) // we try to select the head
                        {
                            echo $c->addHead($h->getId()); // assigning the catagory to head
                        }
                        else // if we can not select the head
                        {
                            echo 'Head Username Does Not Exist';
                        }
                    }
                    else // if we cannot select the catagory
                    {
                        echo 'Catagory Does Not Exist';
                    }
                }
                else // if names are not set
                {   
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all catagories and heads
                $c = new Catagory();
                $h = new Head();
                echo '<form method="POST" name="rmcatform">Select a Catagory and Head<br><select name="catname">';
                foreach($c->getList() as $cat)
                {
                    // name of all catagories from the DB
                    echo '<option>',$cat['name'],'</option>';
                }
                echo '</select><br><select name="headname">';
                foreach($h->getHeads('chead') as $head)
                {
                    // name of all catagory heads from the DB
                    echo '<option>',$head['username'],'</option>';
                }

                // we set a hidden input cathead to rcathead, so that we know we want to assign a catagory to head
                echo '</select><br><input type="hidden" name="cathead" value="cathead"/><input type="submit" value="Assign" /></form>';
            }
        break;

        case 'eventhead':
        // case -> assign event head 
            if (isset($_POST['eventhead'])) // if event and head is selected
            {
                if (isset($_POST['eventname']) and isset($_POST['headname'])) //checking if event and head names are set
                {
                    $e= new Event();
                    $h= new Head();
                    if ($e->select($_POST['eventname'])) // we try to select the event
                    {
                        if($h->select($_POST['headname'])) // we try to select the head
                        {
                            echo $e->addHead($h->getId(),'head'); // assigning the event to head
                        }
                        else // if we can not select the head
                        {
                            echo 'Head Username Does Not Exist';
                        }
                    }
                    else // if we cannot select the event
                    {
                        echo 'Event Does Not Exist';
                    }
                }
                else // if names are not set
                {   
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all events and heads
                $e = new Event();
                $h = new Head();
                echo '<form method="POST">Select an Event and Head<br><select name="eventname">';
                foreach($e->getList() as $event)
                {
                    // name of all events from the DB
                    echo '<option>',$event['name'],'</option>';
                }
                echo '</select><br><select name="headname">';
                foreach($h->getHeads('ehead') as $head)
                {
                    // name of all event heads from the DB
                    echo '<option>',$head['username'],'</option>';
                }

                // we set a hidden input eventhead to eventhead, so that we know we want to assign an event to head
                echo '</select><br><input type="hidden" name="eventhead" value="eventhead"/><input type="submit" value="Assign" /></form>';
            }
        break;

        case 'eventorg':
        // case -> assign event organiser
            if (isset($_POST['eventorg'])) // if event and head is selected
            {
                if (isset($_POST['eventname']) and isset($_POST['headname'])) //checking if event and head names are set
                {
                    $e= new Event();
                    $h= new Head();
                    if ($e->select($_POST['eventname'])) // we try to select the event
                    {
                        if($h->select($_POST['headname'])) // we try to select the head
                        {
                            echo $e->addHead($h->getId(),'org'); // assigning the event to head
                        }
                        else // if we can not select the head
                        {
                            echo 'Username Does Not Exist';
                        }
                    }
                    else // if we cannot select the event
                    {
                        echo 'Event Does Not Exist';
                    }
                }
                else // if names are not set
                {   
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all events and heads
                $e = new Event();
                $h = new Head();
                echo '<form method="POST">Select an Event and Head<br><select name="eventname">';
                foreach($e->getList() as $event)
                {
                    // name of all events from the DB
                    echo '<option>',$event['name'],'</option>';
                }
                echo '</select><br><select name="headname">';
                foreach($h->getHeads('org') as $head)
                {
                    // name of all event organisers from the DB
                    echo '<option>',$head['username'],'</option>';
                }

                // we set a hidden input eventorg to eventorg, so that we know we want to assign an event to organiser
                echo '</select><br><input type="hidden" name="eventorg" value="eventorg"/><input type="submit" value="Assign" /></form>';
            }
        break;

        case 'eventvol':
        // case -> assign event volunteer
            if (isset($_POST['eventvol'])) // if event and head is selected
            {
                if (isset($_POST['eventname']) and isset($_POST['headname'])) //checking if event and head names are set
                {
                    $e= new Event();
                    $h= new Head();
                    if ($e->select($_POST['eventname'])) // we try to select the event
                    {
                        if($h->select($_POST['headname'])) // we try to select the head
                        {
                            echo $e->addHead($h->getId(),'vol'); // assigning the event to head
                        }
                        else // if we can not select the head
                        {
                            echo 'Username Does Not Exist';
                        }
                    }
                    else // if we cannot select the event
                    {
                        echo 'Event Does Not Exist';
                    }
                }
                else // if names are not set
                {   
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all events and heads
                $e = new Event();
                $h = new Head();
                echo '<form method="POST">Select an Event and Head<br><select name="eventname">';
                foreach($e->getList() as $event)
                {
                    // name of all events from the DB
                    echo '<option>',$event['name'],'</option>';
                }
                echo '</select><br><select name="headname">';
                foreach($h->getHeads('vol') as $head)
                {
                    // name of all event volunteers from the DB
                    echo '<option>',$head['username'],'</option>';
                }

                // we set a hidden input eventvol to eventvol, so that we know we want to assign an event to volunteer
                echo '</select><br><input type="hidden" name="eventvol" value="eventvol"/><input type="submit" value="Assign" /></form>';
            }
        break;

        case 'eventcat':
        // case -> assign event to catagory
            if (isset($_POST['eventcat'])) // if event and head is selected
            {
                if (isset($_POST['eventname']) and isset($_POST['catname'])) //checking if event and catagory names are set
                {
                    $e= new Event();
                    $c= new Catagory();
                    if ($e->select($_POST['eventname'])) // we try to select the event
                    {
                        if($c->select($_POST['catname'])) // we try to select the catagory
                        {
                            echo $c->addEvent($e->getId()); // assigning the event to catagory
                        }
                        else // if we can not select the catagory
                        {
                            echo 'Catagory Does Not Exist';
                        }
                    }
                    else // if we cannot select the event
                    {
                        echo 'Event Does Not Exist';
                    }
                }
                else // if names are not set
                {   
                    echo 'Please check your entries';
                }
            }
            else
            {
                // displaying the list of all events and heads
                $e = new Event();
                $c = new Catagory();
                echo '<form method="POST">Select an Event and Head<br><select name="eventname">';
                foreach($e->getList() as $event)
                {
                    // name of all events from the DB
                    echo '<option>',$event['name'],'</option>';
                }
                echo '</select><br><select name="catname">';
                foreach($c->getList() as $cat)
                {
                    // name of all event catagories from the DB
                    echo '<option>',$cat['name'],'</option>';
                }

                // we set a hidden input eventcat to eventcat, so that we know we want to assign an event to Catagory
                echo '</select><br><input type="hidden" name="eventcat" value="eventcat"/><input type="submit" value="Assign" /></form>';
            }
        break;


        default:
            // if none of the above we simply ask to select something
            echo "Sorry you selected something that does not exist";
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
