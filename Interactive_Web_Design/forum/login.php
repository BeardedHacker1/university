<?php 
require 'db_connect.php'; 

if (isset($_POST['submit'])) // If form us submitted
{   // Try selecting users details
    $stmt = $db->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->execute( [$_POST['uname'], $_POST['pword']] );
    $user = $stmt->fetch();

    if ($user)
    {   // Set session variables and redirect to menu page
        $_SESSION['uname'] = $user['username'];
        $_SESSION['level'] = $user['access_level'];
        header('Location: list_threads.php');
        exit;
    }
    else // If no matching user was found...
    {
        echo 'Invalid login attempt, try again.';
    }
}

// If user is logged in redirect to list_threads
if (isset($_SESSION['uname']))
{
  header('Location: list_threads.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login_Form</title>
        <meta name="author" content="Joshua Dankers" />
        <meta name="description" content="Login Form" />
        <title>login</title>
        <script>
            function validateForm() {
                var form = document.login_form;
                
                //Tests if username has been entered.
                if (form.uname.value == '') {
                    alert('Invalid login attempt, try again.');
                    return false;
                }

                //Tests if content was added.
                if (form.pword.value == '') {
                    alert('Invalid login attempt, try again.');
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <h3>Login Form</h3>
        
        <form name="login_form" method="post" action="login.php" onsubmit="return validateForm()">
            
          <label><span>Username: </span><input type="text" name="uname" autofocus></label><br>
          
          <br><label><span>Password: </span><input type="password" name="pword" autofocus></label><br>

          <br><input type="submit" name="submit" value="Submit" />

        </form>
    </body>
</html>