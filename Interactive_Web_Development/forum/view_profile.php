<?php
  require 'db_connect.php';
  
  if (!isset($_GET['username']))
  { // If there is no "username" URL data
    header("Location: list_threads.php");
    exit;
  }

  $stmt = $db->prepare("SELECT u.username, u.real_name, YEAR(u.dob) AS birth_year, COALESCE(COUNT(t.thread_id), 0) AS thread_count
                        FROM user u
                        LEFT OUTER JOIN thread t ON u.username = t.username
                        WHERE u.username = ?
                        GROUP BY u.username, u.real_name, birth_year
                        ORDER BY u.real_name");
  $stmt->execute( [$_GET['username']] );
  $users = $stmt->fetch();

  if (!$users)
  { // If profile with that usrename exists in database
    header("Location: list_threads.php");
    exit;  
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlentities($users['real_name']); ?></title>
    <meta name="author" content="Joshua Dankers" />
    <meta name="description" content="View user profile page" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>
  <body>
  <h3>Viewing Profile of "<?php echo htmlentities($users['username']); ?>"</h3>
  <a href="#" id="backLink">Back</a>
    <script>
        document.getElementById("backLink").addEventListener("click", function() {
        window.location.href = "list_threads.php";
        });
    </script>
    <?php
      // Display profile details
      // This will check if username is disclosed
      echo '<p><small><strong>Real Name:</strong> '.(empty($users['real_name']) ? '<i>Not Disclosed</i>' : htmlentities($users['real_name'])).'</small></br>';
      
      echo '<small><br><strong>Born In:</strong> '.htmlentities($users['birth_year']).'</small></br>';
      
      echo '<small><br><strong>Post Count:</strong> '.htmlentities($users['thread_count']).'</small></p>';
    ?>
  </body>
</html>