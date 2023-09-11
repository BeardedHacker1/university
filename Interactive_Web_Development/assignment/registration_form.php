<!DOCTYPE html>
<?php 
require 'db_connect.php';
?>
<html>
  <head>
    <title>Registration Form</title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="CyberCon Registration Form" />
    <link rel="stylesheet" type="text/css" href="login_stylesheet.css" />
  </head>
  <script>
      // This function is used to validate the form
      // It is called when the form is submitted, and returns false if an error is found
      function validate_reg_form() {

        // Create a variable to refer to the form
        var form = document.registration_form;


        // Confirms if a email was entered
        if (form.email.value == '') {
          alert('Please provide an email.');
          return false;
        }

        // Confirms if a password was entered
        if (form.pword.value == '') {
          alert('Please enter a password.');
          return false;
        }

        // Confirms password is greater than 5 characters
        if (form.pword.value.length < 5) {
          alert('Password must be at least 5 characters long.');
          return false;
        }

        // Confirms if password confirmation was entered
        if (form.conf_pword.value == '') {
          alert('Please confirm your password.');
          return false;
        }

        // Confirms if pword and pword_conf values match
        if (form.pword.value != form.conf_pword.value) {
          alert('Passwords do not match.');
          return false;
        }

        // Confirms if first name was entered
        if (form.fname.value == '') {
          alert('Please enter your first name.');
          return false;
        }

        // Confirms if last name was entered
        if (form.lname.value == '') {
          alert('Please enter your last name.');
          return false;
        }

        // Confirms if a phone number was entered
        if (form.pnum.value == '') {
          alert('Please enter a phone number.');
          return false;
        }

        // Confirms postcode is a 4 digit number
        if (!/^\d{4}$/.test(form.pcode.value)) {
          alert('Postcode must be a 4 digit number.');
          return false;
        }

      // If we get this far without returning false, validation has succeeded!
      }
  </script>
  <body>
    <h1>Please enter your details to register</h1>
    <br>
    <br>
    <!-- using tables to align the elements for aesthetic purposes -->

      <form name="registration_form" method="post" action="registration_processing.php" onsubmit="return validate_reg_form()">

        <fieldset>
          <table>

          <tr><td>
          <label><span>Email<sup>*</sup>:</span></td><td><input type="text" name="email" autofocus /></label>
          </td></tr>

          <tr><td>
          <label><span>Password<sup>*</sup>:</span></td><td><input type="password" name="pword" /></label>
          </td></tr>

          <tr><td>
          <label><span>Confirm Password<sup>*</sup>:</span></td><td><input type="password" name="conf_pword" /></label>
          </td></tr>

          <tr><td>
          <label><span>First Name<sup>*</sup>:</span></td><td><input type="text" name="fname" /></label>
          </td></tr>

          <tr><td>
          <label><span>Last Name<sup>*</sup>:</span></td><td><input type="text" name="lname" /></label>
          </td></tr>

          <tr><td>
          <label><span>Phone Number<sup>*</sup>:</span></td><td><input type="text" name="pnum" /></label>
          </td></tr>

          <tr><td>
          <label><span>Postcode<sup>*</sup>:</span></td><td><input type="text" name="pcode" /></label>
          </td></tr>

          <tr><td colspan="2">
          <input type="submit" name="register" value="Register" class="middle" />
          </td></tr>

          </table>
        
        </fieldset>

      </form>
    </body>
</html>
