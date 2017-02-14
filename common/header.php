<?php
  session_start();
?>
<!DOCUMENT html>
<html>
<head>
    <link href="style.css" rel="stylesheet">
</head>
    <body>
      <div id="header">
        <a href="/" style="color:white;text-decoration:none"> Stock Tracker  </a>
      <?php if (isset($_SESSION["username"])): ?>
        <a href="logout.php" style="color:white;text-decoration:none;float:right;margin-right:75px;"> Logout </a>
      <?php endif; ?>
      </div>
