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
	<h1> Register </h1>
    <form action="register.php" method="post">
      User Name:</br>
    <input type="text" name="username"><br>
      Password:</br>
    <input type="password" name="password"></br>
      Retype Password:</br>
    <input type="password" name="password_retype"></br>
    <input type="submit" value="Register">
  </form>
</div>



<?php require("../common/footer.php"); ?>