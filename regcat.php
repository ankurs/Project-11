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
            if (isset($_POST['reg'])) 
            // if delegate number has been posted
            {
                // we display delegate info and the avaliable events
                $r= new Registeration();
                $c = new Catagory();
                $delInfo = $r->getDelInfo($_POST['delno']);
                if ($delInfo)
                {
                    // if we have info of the selected delegate number
                    echo "<form method='POST'><center><table>";
                    echo "<tr><td>Del no</td><td> {$delInfo['delno']}</td></tr><tr><td>Name</td><td> {$delInfo['name']}</td></tr><tr><td>College</td><td> {$delInfo['cllg']}</td></tr><tr><td>Phone</td><td> {$delInfo['phone']}</td></tr><tr><td>Select Event</td></tr><tr><td><input type='hidden' name='delno' value='{$delInfo['delno']}' />";
                    $c->setId($_GET['id']);
                    $count =0;
                    $events = $c->getEvents();
                    foreach ($events as $event) 
                    {
                        echo "<input type='radio' name='event' value='{$event['eventid']}' \> </td><td>{$event['name']}</td></tr><tr><td>";
                    }
                    echo '</td></tr></table>'; // closing the table
                    if ($events)
                    // if any event is assigned we allow it to registered
                    {
                     echo "<input type='submit' name='eventreg' value='Register' /><input type='submit' value='Cancel' /></form></center>";
                    }
                    else
                    // if there was no event assigned to catagory
                    {
                       echo '<br> No Event Assigned</form></center>'; 
                    }
                }
                else
                {
                    // if we dont have info of delegate number
                    echo "Sorry Wrong Delegate Number<br>".$goBack;
                }
            }
            else if (isset($_POST['eventreg'])) // if we have selected event to be registered
            {
                // register the delegate against the selected event
                $e= new Event();
                if (isset($_POST['event']) and isset($_POST['delno']))
                {
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
                {
                    // we say wrong event because we, delegate info has to be there if we reach this step
                    echo "Wrong Event Please Check your entries<br>".$goBack;
                }
            }
            else if (isset($_POST['team']))
            // if we want the team info
            {
                $c = new Catagory();
                $c->setId($_GET['id']);
                echo '<form method="POST">';
                // TODO CHECK -- class Team not complete
                foreach ($c->getEventsWithTeam() as $event)
                {
                    echo 'a';
                }
            }
            else
            // kind of a default case
            {
                $catInfo = $c->getInfo($_GET['id']);
                if ($catInfo)
                {
                    echo 'Welcome to <b>',ucwords($catInfo['name']),'</b> Registeration<br><br>';
                    echo "<form method='POST'>Enter the Deligate Number<br><input type='text' name='delno' /><br><input type='submit' name='reg' value='Register' /><input type='submit' name='team' value='Team' /></form>";
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
