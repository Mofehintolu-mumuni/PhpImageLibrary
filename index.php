<?php

require_once("ImageClass.php");

?>

<html>
<head>
<title>
IMAGE CLASS EXAMPLE
</title>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">

<input type="file" name="image"/>

<input type="submit" value="UPLOAD" name="send"/>

</form>


    <?php
    
    if(isset($_POST['send']))
    {
        $filename =  $_FILES['image']['tmp_name'];;
        
       if(is_uploaded_file($filename)){
        
        $image = new \library\Image\ImageUpload($filename); //USE THIS SAME LINE OF CODE WITH THE FILENAME VARIABLE AS ARGUMENT
        
        $imagepathfromdb = 'null'; //SET NULL IF THERE IS NOT IMAGE TO BE REPLACED 
        
        $imagepath = 'C:/wamp64/www/PHP/ImageLibrary/Images/'; //SET YOUR LOCATION
        
        $new_width = 500; //SET YOUR NEW IMAGE WIDTH
        
        $new_height = 600; //SET YOUR NEW IMAGE HEIGHT
        
        $toHash = rand(31000000,40000000); //CREATE A RANDOM NUMBER
        
        $newImageName = md5($toHash); //USE MD5 HASHING ALGORITHM TO GET IMAGE NEW NAME
         
    $image->setImageImagePathFromDB($imagepathfromdb);
       
    $image->setImageImagePath($imagepath);
  
    $image->setImageWidth($new_width);
  

    $image->setImageHeight($new_height);
   

    $image->setImageName($newImageName);
  

    $check = $image->isImage();

   $type = $image->imageType();


 if(($check == 0)){
			echo '<i style="color: red;">This file is not an image, upload an image</i>';
		}
        else{
            
          $upload = $image->UploadImage($type);
          
          if($upload[0] == 1)
          {
            echo'fantastic';
            echo('</br>');
            echo $upload[1];
            echo('</br>');
          }
          else{
             echo'error!!';
               echo('</br>');
            echo $upload[1];
          }
          
          
          
          //run again

    $toHash = rand(31000000,40000000); 
        
    
    $newName = md5($toHash);

    $new_width1 = 1000;
    
    $new_height1 = 1100;


    $image->setImageWidth($new_width1);
  

    $image->setImageHeight($new_height1);
   

    $image->setImageName($newName);
          
    
    $upload1 = $image->UploadImage($type);
          
      
          if($upload1[0] == 1)
          {
            echo'fantastic';
            echo('</br>');
            echo $upload1[1];
          }
          else{
             echo'error!!';
               echo('</br>');
            echo $upload1[1];
          }
          
          
          
        }
    

  
        
        }
    
        
    }
    
    
    ?>


</body>
</html>