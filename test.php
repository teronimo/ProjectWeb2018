<?php
   if(isset($_FILES['kml'])){
      $errors= array();
      $file_name = $_FILES['kml']['name'];
      $file_size =$_FILES['kml']['size'];
      $file_tmp =$_FILES['kml']['tmp_name'];
      $file_type=$_FILES['kml']['type'];
	  $tmp = explode('.',$_FILES['kml']['name']);
	  $file_ext = strtolower(end($tmp));
      
      $expensions= array("kml","xml","jpg");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
           
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"kml-upload/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="kml" />
         <input type="submit"/>
      </form>
      
   </body>
</html>