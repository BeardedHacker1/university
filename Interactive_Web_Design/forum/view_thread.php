<?php
  require 'db_connect.php';
  
  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    header("Location: list_threads.php");
    exit;
  }

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT * FROM thread WHERE thread_id = ?");
  $stmt->execute( [$_GET['id']] );
  $thread = $stmt->fetch();
  
  if (!$thread)
  { // If no data (no thread with that ID in the database)
    header("Location: list_threads.php");
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($thread['title']); ?></title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>View Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
		<?php
      // Display the thread's details
      echo '<h4>'.$thread['title'].'</h4>';
      
      $formattedDateTime = date('F j, Y h:i A', strtotime($thread['post_date']));
      echo '<small>Posted by <a href="view_profile.php?username='.$thread['username'].'">'.$thread['username'].'</a> on '.$formattedDateTime.'</small></p>';
      
      if ($_SESSION['uname'] == $thread['username'])
      {
        echo '<small>[<a href="edit_thread_form.php?id='.$thread['thread_id'].'">Edit</a>]</small>';
      }
      if ($_SESSION['uname'] == $thread['username'] || $_SESSION['level'] == 'admin')
      {
        echo '<small>[<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id=' .$_GET['id']. '">Delete</a>]</small>';
      }
	  
      echo '<p>'.nl2br(htmlentities($thread['content'])).'</p>';
    ?>
  </body>
</html>
