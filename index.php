<?php
include_once 'db_connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html>
<body>


<?php
echo "<h1>PHP is Fun!</h1>";
echo "Hello world!<br>";
echo "I'm about to learn PHP!<br>";
echo "This ", "string ", "was ", "made ", "with multiple parameters.";
?> 

</body>
</html>