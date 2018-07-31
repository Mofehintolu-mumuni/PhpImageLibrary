<?php


 namespace library\Image;

 class ImageUpload{
    
    private $NewImageName;      //integer variable
    private $NewImageWidth;     //integer variable
    private $NewImageHeight;        //integer variable
    private $SaveImageToFolderPath;     //string variable
    private $ImagePathFromDb;       //string variable
    private $Filename;       //resource
    
    private $width_from_image;
    private $height_from_image;
    
    
    
    function setImageImagePathFromDB($imagepathfromdb)
    {
        $this->ImagePathFromDb = $imagepathfromdb;
    } 
    
    
    
          
    function setImageImagePath($imagepath)
    {
        $this->SaveImageToFolderPath = $imagepath;
    } 
    
    
    
    function setImageWidth($new_width)
    {
        $this->NewImageWidth = $new_width;
    }
    
    
    
    function setImageHeight($new_height)
    {
        $this->NewImageHeight = $new_height;
    }
    
    
    
    function setImageName($newImageName)
    {
        $this->NewImageName = $newImageName;
    }
    
    
    
    
    function __construct($filename)
    {
        
        $this->Filename = $filename;
        
        //get image width and height
        list($this->width_from_image, $this->height_from_image) = $this->ImageSize($this->Filename);
        
    }
    
    
    function ImageSize($image_filename){
    $image_size = getimagesize($image_filename);
    return $image_size;
    }
    
    
    function imageType()
    {
        $size_array = $this->ImageSize($this->Filename);
        
        $type = $size_array[2];
        
        return $type;
        
    }
    
    //SUCCESS STATUS IS 1 AND FAILURE IS 0
    
    function isImage()
    {
        $size_array = $this->ImageSize($this->Filename);
        
        $width = $size_array[0];
        
        if(is_integer($width) != 1)
        {
            $status = 0;
            
            return $status;
        }
        else
        {
            $status = 1;
            
            return $status;
        }
        
       
    }
    
    
    
    
    
        function create_image_from_jpeg($image_filename){
        $imagejpg = imagecreatefromjpeg($image_filename);
        return $imagejpg;
    }
    



    
     function create_image_from_png($image_filename){
        $imagepng = imagecreatefrompng($image_filename);
        return $imagepng;
    }
    



    
    function create_true_color_image($new_width, $new_height){
        $true_color_image = imagecreatetruecolor($new_width, $new_height);
        return $true_color_image;
    }




    function copy_resampled_image($createtruecolor, $create_from_jpg_or_png, $zero_val_1, $zero_val_2, $zero_val_3, $zero_val_4, $new_width, $new_height, $width_from_image, $height_from_image){
        
        $resampled_image = imagecopyresampled($createtruecolor, $create_from_jpg_or_png, $zero_val_1, $zero_val_2, $zero_val_3, $zero_val_4, $new_width, $new_height, $width_from_image, $height_from_image);
	     return $resampled_image;
        
        
    }
    

    
    function UploadImage($imageType)
    {
        if(!defined('IMAGE_DESTINATION'))
        {
            define('IMAGE_DESTINATION',$this->SaveImageToFolderPath);
        }
         
  
   	switch($imageType){
	   
	case IMAGETYPE_JPEG:
        
        //create image from jpeg
         $create_jpeg_image = $this->create_image_from_jpeg($this->Filename);
       
  
        //create true color image  with new width and height specified
        $true_color_jpeg = $this->create_true_color_image($this->NewImageWidth, $this->NewImageHeight);
        
        //copy resampled image with true color image and image created from jpeg as arguemnts
        $resampled = $this->copy_resampled_image($true_color_jpeg, $create_jpeg_image, 0, 0, 0, 0, $this->NewImageWidth, $this->NewImageHeight, $this->width_from_image, $this->height_from_image);

        //check if file exists since image path is not null
                if($this->ImagePathFromDb != "null"){
                    $check = file_exists(IMAGE_DESTINATION.$this->ImagePathFromDb);
                    if($check){
                        
                        //use unlink to delete old image file if it exists
                        
                        unlink(IMAGE_DESTINATION.$this->ImagePathFromDb);
                        
                        //save image to specified folder using imagejpeg
                        
                        imagejpeg($true_color_jpeg,IMAGE_DESTINATION.$this->NewImageName.'.jpg',100);
                        
                        //destroy image to free up memory
                        imagedestroy($true_color_jpeg);
                    
                    
        //specify image path for saving in database table
      $new_image_name = $this->NewImageName.".jpg";
      
      $responeStatus = 1;
      
      $results = [$responeStatus,$new_image_name];
      
       return $results;
      
      
                        
      }
      else{
        
      $responeStatus = 0;
      
      $results = [$responeStatus,'null'];
      
       return $results;
        
      }
                    
                    
                    
                    
      }
                
      if($this->ImagePathFromDb == "null"){
      imagejpeg($true_color_jpeg,IMAGE_DESTINATION.$this->NewImageName.'.jpg',100);
                        
      //destroy image to free up memory
      imagedestroy($true_color_jpeg);
                    
       //specify image path for saving in database table
      $new_image_name = $this->NewImageName.".jpg";
      
      $responeStatus = 1;
      
      $results = [$responeStatus,$new_image_name];
      
       return $results;

      }
                
	break;

    
	case IMAGETYPE_PNG:
    
    
      //create image from jpeg
         $create_png_image = $this->create_image_from_png($this->Filename);
       
  
        //create true color image  with new width and height specified
        $true_color_png = $this->create_true_color_image($this->NewImageWidth, $this->NewImageHeight);
        
        //copy resampled image with true color image and image created from jpeg as arguemnts
        $resampled = $this->copy_resampled_image($true_color_png, $create_png_image, 0, 0, 0, 0, $this->NewImageWidth, $this->NewImageHeight, $this->width_from_image, $this->height_from_image);

        //check if file exists since image path is not null
                if($this->ImagePathFromDb != "null"){
                    $check = file_exists(IMAGE_DESTINATION.$this->ImagePathFromDb);
                    if($check){
                        
                        //use unlink to delete old image file if it exists
                        
                        unlink(IMAGE_DESTINATION.$this->ImagePathFromDb);
                        
                        //header("Content-Type: image/png");
                        
                        //save image to specified folder using imagejpeg
                        
                        ImageJPEG($true_color_png,IMAGE_DESTINATION.$this->NewImageName.'.png',100);
                        
                        //destroy image to free up memory
                        imagedestroy($true_color_png);
                    
                    
        //specify image path for saving in database table
      $new_image_name = $this->NewImageName.".png";
      
      $responeStatus = 1;
      
      $results = [$responeStatus,$new_image_name];
      
       return $results;
      
      
                        
      }
      else{
        
      $responeStatus = 0;
      
      $results = [$responeStatus,'null'];
      
       return $results;
        
      }
                    
                    
                    
                    
      }
                
      if($this->ImagePathFromDb == "null"){
        
      //header("Content-Type: image/png");
          
      ImageJPEG($true_color_png,IMAGE_DESTINATION.$this->NewImageName.'.png',100);
                        
      //destroy image to free up memory
      imagedestroy($true_color_png);
                    
       //specify image path for saving in database table
      $new_image_name = $this->NewImageName.".png";
      
      $responeStatus = 1;
      
      $results = [$responeStatus,$new_image_name];
      
      return $results;

      }
                
	break;

    
	default: 
    echo"Images must be of JPG, JPEG or PNG formats only";
    
	break;
    
    
    
	}
        
        
        
        
        
        
        
        
    }
    
    
    
    
    
    
    

  }

    



?>