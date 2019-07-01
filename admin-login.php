<?php
if (isset($_SESSION['session_username']))
{
	echo "Έχεις κάνει ήδη login <b>".$_SESSION['session_username']."</b>!";
}
elseif (isset($_POST['Username']) && isset($_POST['Password']))
{
	$user = $_POST['Username'];
	$pass = $_POST['Password'];

	if ( ($user=="root") && ($pass==""))
	{
		header("Location: admin-control.php");
	}
	else
	{
		header("Location: index.php");
	}
}
?>
