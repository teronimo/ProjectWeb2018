<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
	
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/loginform.css" >
		
  	</head>
  	

	
	<body id="LoginForm">
	<div class="container">
	<div class="login-form">
	<div class="main-div">
	    <div class="panel">
	   
	   <h2>Admin Login</h2>
	   <p>Please enter your username and password</p>
	   </div>
	    <form id="Login" method="POST" action="admin-login.php">

	        <div class="form-group">

	        	<h2>Username</h2>
	            <input type="text" class="form-control" name="Username" placeholder="Enter Username">

	        </div>

	        <div class="form-group">
	        	<h2>Password</h2>
	            <input type="password" class="form-control" name="Password" placeholder="Enter Password">

	        </div>
	       
	        <button type="submit" class="btn btn-primary">Login</button>

	    </form>
	    </div>
	    <div>
	    	<form id="LoginAsGuest" method="POST" action="guest-control.php">
	        	<button type="submit" class="btn btn-primary">Login As Guest</button>
			</form>
	    </div>
	</div></div></div>


</body>