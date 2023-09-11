<!DOCTYPE html>
<?php

require 'db_connect.php'; 

// Is user is logged in redirect to login page
if (!isset($_SESSION['uname']))
{
  header('Location: login.php');
}
?>
<html>
    <head>
        <title>New_Thread_Form</title>
        <meta name="author" content="Joshua Dankers" />
        <meta name="description" content="New Thread Form" />
        <title>new_thread</title>
        <link rel="stylesheet" href="thread_form_style_page.css">
        <script>
            function validateForm() {
                var form = document.new_thread_form;
                
                //Tests if username has been entered.
                if (form.title.value == '') {
                    alert('Title must be added.');
                    return false;
                }

                //Tests if content was added.
                if (form.content.value == '') {
                    alert('Content must must be added.');
                    return false;
                }
                    
                // Tests if forum was selected.  
                if (form.forum_id.value == '') {                    
                    alert('Please select a forum.');
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <h3>NEW THREAD</h3>

        <p><a href="list_threads.php">List Posted Threads</a> | <a href="search_threads.php">Search Posted Threads</a></p>
        
        <form name="new_thread_form" method="post" action="new_thread.php" onsubmit="return validateForm()">
            
          <label><span>Title: </span><br><input type="text" name="title" autofocus></label><br>
          
          <br><label><span>Content: </span><br><textarea name="content" ></textarea></label><br>

          <br><span>Select Forum: </span></span><select name="forum_id">
            <option value="" selected disabled>Select a forum</option>
            <?php  
              // Select details of all forums
              $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
        
              // Loop through each forum to generate an option of the drop-down list
              foreach($result as $row)
              {
                echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
          
                // If there is a forum_id in the URL data, assign the current forum's name to a variable to display later
                // (this simply saves us having to use a separate query to get the name of the selected forum)
                if (isset($_GET['forum_id']) && $_GET['forum_id'] == $row['forum_id'])
                {
                  $current_forum_name = $row['forum_name'];
                }
              }
            ?>
          </select><br>

          <br><input type="submit" name="submit" value="Submit" />

        </form>
    </body>
</html>