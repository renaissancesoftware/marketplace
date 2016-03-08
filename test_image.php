<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$upload_image = $_FILES["image"][ "name" ];
	$image_name = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
	
	$folder = "images/";

	move_uploaded_file($_FILES["image"]["tmp_name"], $folder.$_FILES["image"]["name"]);
	
	$file = 'images/'.$_FILES["image"]["name"];
	$uploadimage = $folder.$_FILES["image"]["name"];
	$newname  = preg_replace('/\\.[^.\\s]{3,4}$/', '', $_FILES["image"]["name"]);
	
	$info = getimagesize($file);
	
	if ($info['mime'] == 'image/jpeg')
	{
		$filename = $folder.$newname.".jpg";
		$image = imagecreatefromjpeg($filename);
		imagejpeg($image,"images/$image_name.jpg"); 
	}
	elseif ($info['mime'] == 'image/gif') 
	{
		$filename = $folder.$newname.".gif";
		$image = imagecreatefromgif($filename); 
		imagegif($image,"images/$image_name.gif");
	}
	elseif ($info['mime'] == 'image/png')
	{
		$filename = $folder.$newname.".png";
		$image = imagecreatefrompng($filename);
		$black = imagecolorallocate($image, 0, 0, 0);
		imagecolortransparent($image, $black);
		imagepng($image,"images/$image_name.png",5);
	}  
	
	$folder = "images";
	$results = scandir('images');
	foreach ($results as $result) 
	{
		if ($result === '.' or $result === '..') continue;
			if (is_file($folder . '/' . $result)) 
			{
				echo '<div id="image_box">
						<img src="'.$folder . '/' . $result.'" alt="...">   
					</div>';
			}
	}	
	imagedestroy($image);
}
?>
<html>
     <body>	
	 <style>
	  img{
			float: left;
		}
	 #my_form{
			padding: 2%;
			float: left;
			width: 100%;	
		}
	#image_box{
			float:left;
			padding: 2%;
		}	
	 </style>
	 <div id= my_form>
		 <form method="POST" action="" enctype="multipart/form-data">
			<input type="file" name="image">
			<input type="submit" name="upload_image" value="Upload">
		 </form>
	 </div>
	 <div id="image_uploaded">
	 </div>

     </body>
</html>