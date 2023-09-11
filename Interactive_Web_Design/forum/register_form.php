<!DOCTYPE html>
<?php 

require 'db_connect.php'; 

// If user is logged in redirect to list_threads
if (isset($_SESSION['uname']))
{
  header('Location: list_threads.php');
}

?>
<html>
    <head>
        <title>Register_Form</title>
        <meta name="author" content="Joshua Dankers" />
        <meta name="description" content="Register Form" />
        <link rel="stylesheet" href="style_page.css">
        <script>
            function validateForm() {
                var form = document.register_form;
                
                //Tests if username has been entered.
                if (form.uname.value == '') {
                    alert('Username is required');
                    return false;
                }

                //Tests if password is 6 characters in length.
                if (form.pword.value.length < 6) {
                    alert('Password must be at least 6 characters long.');
                    return false;
                }
                    
                // Tests if passwords match.  
                if (form.confirmpword.value != form.pword.value) {                    
                    alert('Passwords do not match.');
                    return false;
                }

                //Test if DOB was entered.
                if (form.dob.value == '') {
                    alert('Date of birth is required.');
                    return false;
                }

                //Test if agreed button was selected.
                if (!form.agree.checked) {
                    alert('Please agree to the terms and conditions.');
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <h3>CREATE ACCOUNT</h3>

        <p>Already have an account, log in <a href="login.php">here</a>.</p>
        
        <form name="register_form" method="post" action="register.php" onsubmit="return validateForm()">
            
        <div class="fieldset-container">
            <fieldset>
                <legend>User Credentials</legend>
                <label><span>Username<sup>*</sup>: </span><input type="text" name="uname" autofocus ></label>
                <label><span>Password<sup>*</sup>: </span><input type="password" name="pword"></label>
                <label><span>Confirm Password<sup>*</sup>: </span><input type="password" name="confirmpword"></label>
            </fieldset>
        </div>
        
        <div class="fieldset-container">
            <fieldset>
                <legend>Other Details</legend>
                <label><span>Real Name: </span><input type="text" name="name"></label>
                <label><span>Date of Birth<sup>*</sup>: </span><input type="date" name="dob"></label>
                <label class="middle"><input type="checkbox" name="agree" /> I agree to all terms and conditions <br>
                <br><input type="submit" name="submit" value="Submit" class="middle" />
            </fieldset>
        <div>

        </form>
    </body>
</html>