<?php
//* Function Name: get_new_id
//* Description: This function takes a table name, a  field and returns the next new id for that field in the table
//* Input Param 1: table – the name of the table
//* Input Param 2: field_name - the name of the autoincrement primary key field
//* Input Param 2: where_criteria - an sql where criteria to limit the result set
//* Return Param 1: the new id
function get_new_id($table, $field_name, $where_criteria=""){
	$link=mysqli_open();
	$query="SELECT max({$field_name}) AS max_id FROM {$table}";
	if ($where_criteria!=""){
		$query.=" WHERE ".$where_criteria;
	}
	$result=mysqli_query($link,$query);
	if (!$result){
	    return false;
	}
	$row=mysqli_fetch_assoc($result);
	$new_id=$row['max_id']+1;
        return $new_id;
    
}

//* Function Name: create_zip
//* Description: This function creates zipped files  
//* Input Param 1: files –  array of files to be zipped
//* Input Param 1: destination –  file path where zipped file should be saved
//* Input Param 2: overwrite -  if the zipped file should overwrite an existing one
//* Return Param: true/false - returns true if the zipped file creation was successful, else false
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			//get the file name only, without the path
			//$pos=strripos($file,"/")+1;
			//$new_file=substr($file,$pos);
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

//* Function Name: create_thumb
//* Description: This function is creates a thumbnail of a given image file
//* Input Param 1: name – the original filename
//* Input Param 2: filename – the filename of the resized image
//* Input Param 3: new_w – width of the resized image
//* Input Param 4: new_h – height of the resized image
function create_thumb($name,$filename,$new_w,$new_h)
{
	$system_ext=substr($name,strlen($name)-5);
	$system=explode('.',$system_ext);
	if (preg_match("/jpg|jpeg/i",$system[1])){$src_img=imagecreatefromjpeg($name);}
	if (preg_match("/png/i",$system[1])){$src_img=imagecreatefrompng($name);}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	/*if ($old_x > $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) 
	{
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
	}
	if ($old_x == $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}*/
	$percentage_w = ($new_w / $old_x); 
	$percentage_h = ($new_h / $old_y); 
	
	if ($percentage_h>$percentage_w)
	    $percentage=$percentage_w;
	else
	    $percentage=$percentage_h;
	    
	$thumb_w=$old_x * $percentage;
	$thumb_h=$old_y * $percentage;
		
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/png/i",$system[1]))
	{
		imagepng($dst_img,$filename); 
	} else {
		imagejpeg($dst_img,$filename); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}
?>