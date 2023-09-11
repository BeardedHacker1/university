<?php
  require 'db_connect.php';
  
  // If user is not logged in redirect to login page
  if (!isset($_SESSION['uname']))
  {
    header('Location: login.php');
  }
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo 'Invalid thread ID.';
    exit;
  }

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT * FROM thread WHERE thread_id = ? AND username = ?");
  $stmt->execute( [$_GET['id'], $_SESSION['uname']] );
  $thread = $stmt->fetch();
  
  if (!$thread)
  { // If no data (no thread with that ID in the database)
    echo 'Invalid thread ID.';
    exit;  
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit_Thread_Form</title>
        <meta name="author" content="Joshua Dankers" />
        <meta name="description" content="Edit Thread Form" />
        <title>edit_thread</title>
        <link rel="stylesheet" href="thread_form_style_page.css">
        <script>
            function validateForm() {
                var form = document.edit_thread_form;
                
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
        <h3>EDIT THREAD</h3>

        <p><a href="list_threads.php">List Posted Threads</a> | <a href="search_threads.php">Search Posted Threads</a></p>
        
        <form name="edit_thread_form" method="post" action="edit_thread.php" onsubmit="return validateForm()">

            <input type="hidden" name="thread_id" value="<?= $_GET['id'] ?>" />
                
            <label><span>Title: </span><br><input type="text" name="title" value="<?= $thread['title'] ?>." autofocus></label><br>
            
            <br><label><span>Content: </span><br><textarea name="content"><?= $thread['content'] ?></textarea></label><br>

            <br><span>Select Forum: </span></span><select name="forum_id">
            <option value="" disabled>Select a forum</option>
            <?php  
                // Select details of all forums
                $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
        
                // Loop through each forum to generate an option of the drop-down list
                foreach($result as $row)
                {
                    $text = $thread['forum_id'] == $row['forum_id'] ? 'selected' : '';
                    echo '<option value="'.$row['forum_id'].'" '.text.'>'.$row['forum_name'].'</option>';
                }
            ?>
            </select><br>

            <br><input type="submit" name="submit" value="Submit" />

        </form>
    </body>
</html>