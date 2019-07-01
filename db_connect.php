<?php
$con=mysqli_connect("localhost","root", "", "project_2018");
if(!$con){
    die("Connect failed: ".mysqli_error($con));
}

if (mysqli_connect_errno()) {
    die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
}
return $con;

?>