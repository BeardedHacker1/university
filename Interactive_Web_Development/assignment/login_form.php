<!DOCTYPE html>
<?php 
require 'db_connect.php';
?>
<html>
  <head>
    <title>Login Form</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Login Form" />
    <link rel="stylesheet" type="text/css" href="login_stylesheet.css" />
    <script>
    
      function validate_vol_form() {
        
        //form reference variable
        var form1 = document.vol_login;
        
        //check if email or username field is populated
        if (form1.email.value == '') {
          alert("Please enter the email you registered with. If you haven't registered yet, please click on the 'register here' link");
          return false;
        }
        
        
        //check if password field is populated with the minimum password length
          if (form1.pword.value.length < 5 ) {
            alert('Please check your details and try again.');
            return false;
          }
        
      }

      function validate_org_form() {
        
        //form reference variable
        var form2=document.org_login;
        
        //check if email or username field is populated
        if (form2.username.value == '') {
          alert("Please enter the username you registered with. If you haven't registered yet, please click on the 'register here' link");
          return false;
        }
        
        
        //check if password field is populated with the minimum password length
          if (form2.password.value.length < 5 ) {
            alert('Please check your details and try again.');
            return false;
          }
        
      }
    </script>
  </head>
  
  <body>
    <h1>Please login or register</h1>
    <br>
    <br>
  
    <!-- using tables to align the elements for aesthetic purposes -->
    <table>
    <tr><td>
      <form name="vol_login" method="post" action="volunteer_login_validation.php" onsubmit="return validate_vol_form()">

        <fieldset ><legend>Volunteer Login</legend>
          <table> 
          <tr><td>
          <label><span>Email<sup>*</sup>:</span></td><td><input type="text" name="email" autofocus /></label>
          </td></tr>
          <tr><td>
          <label><span>Password<sup>*</sup>:</span></td><td><input type="password" name="pword" /></label>
          </td></tr>
        
          <tr><td>
          <a href="registration_form.php" name="register" ><p>Click here to register</a> </p><br> </td></tr>
       
          <tr><td colspan="2">
          <input type="submit" name="submit_vol" value="Submit" class="middle" /> </td></tr>
          </table>
        </fieldset>
      </form>
      </td>
      <td>

      <form name="org_login" method="post" action="organiser_login_validation.php" onsubmit="return validate_org_form()">

        <fieldset><legend>Organiser Login</legend>
        <table>
        <tr><td>
          <label><span>Username<sup>*</sup>:</span></td><td><input type="text" name="uname" autofocus /></label>
          </td></tr>
          
          <tr><td>
          <label><span>Password<sup>*</sup>:</span></td><td><input type="password" name="password" /></label>
          </td></tr>
          <tr><td>
          <p></p><br> </td></tr>
      
          <tr><td colspan ="2">
          <input type="submit" name="submit_org" value="Submit" class="middle" />
          </td></tr>
          </table>
        </fieldset>
      </form>
      </td></tr>
    
    </div>

    </body>
    </html>