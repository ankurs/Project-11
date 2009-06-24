<html>
<head>
<title><?php include "config.php"; echo $Name; ?></title>
<link rel="stylesheet" href="main.css" type="text/css" />
<script src='js/jq.js' type='text/javascript'></script>
<script src='js/function.js' type='text/javascript' ></script>
<script type='text/javascript'>
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
