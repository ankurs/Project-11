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
<div id="center">
<?php
if(!isset($_GET['id']))
// if there is no id select in the url we set id to -1, so that we generate an error
{
    $_GET['id'] = -1;
}
$goBack = "<a href='regcat.php?id={$_GET['id']}'>Back</a>";
$r = new Registeration();
if (True)//TODO check everything here
{
    //$level from sidebar.php
    if ($level != "error")
    {   // for anything except error, i.e all logged in users
        $c = new Catagory();
        if (isset($_GET['id']))
        {
            $c->setId($_GET['id']);
        }
        if (isset($_COOKIE['user'])) // for undefined $_COOKIE['user'] warnings
        {
            $cookieUser = $_COOKIE['user'];
        }
        else
        {
            $cookieUser='';
        }
        if (($c->hasPermission($cookieUser)) or ($level=="admin"))
        // if the particular user has permission or if its the admin
        {
            if (isset($_POST['go']) and isset($_POST['event']))
            {
                // when the event has been selected
                $e = new Event();
                $eventInfo = $e->getInfo($_POST['event']);
                // display the event info
                echo '<h3>',ucwords($eventInfo['name']),' Regestration</h3>';
                if ($e->isTeamEvent($_POST['event']))
                {
                    // if the event is a team event we ask user to enter the team number
                    echo 'Team Event<br />';
                    echo 'Enter Team number<form method="POST">';
                    echo '<input type="input" name="teamno" /><br>';
                    echo '<input type="hidden" name="event" value="',$_POST['event'],'"/>';
                    echo '<input type="submit" name="regteam" value="Register"/><input type="submit" value="Cancel" />';
                    echo '</form>';
                }
                else
                {
                    // if the event is not a team event
                    echo 'Individual Event<br>';
                    echo 'Enter Delegate number<form method="POST">';
                    echo '<input type="input" name="delno" /><br>';
                    echo '<input type="hidden" name="event" value="',$_POST['event'],'"/>';
                    echo '<input type="submit" name="regind" value="Register"/><input type="submit" value="Cancel" />';
                    echo '</form>';

                }
            }
            // team reg portion
            else if (isset($_POST['regteam']) and isset($_POST['teamno']))
            {
                // when team number is posted
                $e = new Event();
                $eventInfo = $e->getInfo($_POST['event']);
                //display event name
                echo '<h3>',ucwords($eventInfo['name']),' Regestration</h3>';
                $t = new Team();
                // get list of members in the team
                $members = $t->getMembers($_POST['teamno']);
                if ($members)
                {
                    // if there are members in the team
                    echo '<center><table><tr><td>Team No.</td><td>Del No.</td><td>Reg No.</td><td>Name</td><td>Sem</td><td>College</td><td>Phone</td></tr>';
                    $num =1;
                    foreach($members as $mem)
                    {
                        // to change the color
                        if ($num%2 ==1)
                        {
                            $class ='odd';
                        }
                        else
                        {
                            $class = 'even';
                        }
                        echo "<tr id ='{$class}'><td> {$_POST['teamno']} </td><td> {$mem['delno']} </td><td> {$mem['regno']} </td><td> {$mem['name']} </td><td> {$mem['sem']} </td><td> {$mem['cllg']} </td><td> {$mem['phone']} </td></tr>";
                        $num+=1;
                    }
                    // asking user to confirm
                    echo '</table></center><br>';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="event" value="',$_POST['event'],'" />';
                    echo '<input type="hidden" name="teamno" value="',$_POST['teamno'],'" />';
                    echo '<input type="submit" name="confirm" value="Confirm" /><input type="submit" name="cancel" value="Cancel" />';
                    echo '</form>';
                }
                else
                {
                    // if there is some error with team
                    echo 'Please check the entered team number<br>'.$goBack;
                }
            }
            else if (isset($_POST['confirm']) and isset($_POST['teamno']) and isset($_POST['event']))
            {
                // when team is confirmed
                $t = new Team();
                $action = $t->addToEvent($_POST['event'],$_POST['teamno']);
                if ($action == 'exists')
                {
                    echo 'Team already assigned to Event<br>',$goBack;
                }
                else if ($action == 'done')
                {
                    echo 'Done<br>',$goBack;
                }
                else
                {
                    echo 'Sorry some error occured<br>',$goBack;
                }

            }
            // individual reg portion
            else if (isset($_POST['regind']) and isset($_POST['delno']))
            {
                $e = new Event();
                $eventInfo = $e->getInfo($_POST['event']);
                //display event name
                echo '<h3>',ucwords($eventInfo['name']),' Regestration</h3>';
                $r= new Registeration();
                $delInfo = $r->getDelInfo($_POST['delno']);
                if ($delInfo)
                {
                    // if we have info of the selected delegate number
                    echo "<form method='POST'><center><table>";
                    echo "<tr><td>Del no</td><td> {$delInfo['delno']}</td></tr><tr><td>Reg No.</td><td>{$delInfo['regno']}</td></tr><tr><td>Name</td><td> {$delInfo['name']}</td></tr><tr><td>College</td><td> {$delInfo['cllg']}</td></tr><tr><td>Phone</td><td> {$delInfo['phone']}</td></tr></table><input type='hidden' name='delno' value='{$delInfo['delno']}' /><input type='hidden' name='event' value='{$_POST['event']}' />";
                    echo '<br>Confirm Registeration<br><input type="submit" name="confirm" value="Confirm"/><input type="submit" name="cancel" value="Cancel" />';
                    echo '</center></form>';
                }
                else
                {
                    echo 'Sorry the Delegate Number does not exists';
                }
            }   
            else if (isset($_POST['event']) and isset($_POST['delno']) and isset($_POST['confirm']))
            {
                $e = new Event();
                $e->setId($_POST['event']);
                $result = $e->addUser($_POST['delno']);
                if ($result)
                {
                    // if we have a result
                    if ($result == "regDone")
                    {
                        echo "Already Registered<br>".$goBack;
                    }
                    else
                    {
                        echo "Done<br>".$goBack;
                    }
                }
            } 
            else
            // kind of a default case
            {
                $c = new Catagory();
                //get the catagory info
                $catInfo = $c->getInfo($_GET['id']);
                if ($catInfo)
                {
                    // if catagoty present display welcome message
                    echo 'Welcome to <b>',ucwords($catInfo['name']),'</b> Registeration<br><br>';
                    $c->setId($_GET['id']);
                    //get all events in catagory
                    $events = $c->getEvents();
                    if ($events)
                    {
                        // if there are events display them
                        echo "<form method='POST'><center><table>";
                        foreach ($events as $event) 
                        {
                            echo "<tr><td><input type='radio' name='event' value='{$event['eventid']}' \></td><td>{$event['name']}</td></tr>";
                        }
                        echo '</table><input type="submit" name="go" value="Go" /></center></form>';
                    }
                    else
                    {
                        // if no events present display error
                        echo 'Sorry no Events assigned';
                    }
                }
                else
                {
                    echo 'No Such Catagory';
                }
            }
        }    
        else
        {
            // if the user does not have permission for this catagory
            echo "You do not have Privlage to access this resource<br>";
        }
    }
    else
    {
        echo "You do not have Privlage to access this resource<br>";
    }

}

?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
