<?php
	session_start();
	if(isset($_SESSION["username"])){
		//Already logged in, go to the application
		header("Location: main.php");
		exit();
	}
	require("../common/header.php");
?>

<div id="content">
	<h1> Sign In </h1>
    <form action="signin.php" method="post">
      User Name:</br>
    <input type="text" name="username"><br>
      Password:</br>
    <input type="password" name="password"></br>
    <input type="submit" value="Sign In">
  </form>
  <a href="registration.php">Register</a>
</div>

<?php require("../common/footer.php"); ?>
