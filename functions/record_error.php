<?php

//*Function Name: record_error
//*Description: This function records an error event in the database and in a file and sends an email to the developer team.
//*Input Param 1: error_type_code - a error code to help the developer team figure out what went wrong
//*Input Param 2: error_message - a descriptive message to help the developer team figure out what went wrong
//*Return Param 1: an error code indicating whether the recording and emailing of the error was successful
function record_error($error_type_code,$error_message){
	//get a stack trace of the pages visited
	$db=debug_backtrace();
	
	// append some data to the error message
	$error_message.="\n\n";
	foreach ($db as $item){
		$error_message.="\n\nFile Name:".$item['file']."\n";
		$error_message.="Function Name:".$item['function']."\n";
		$error_message.="Line Number:".$item['line']."\n";
		$error_message.="Parameters:";
		foreach ($item['args'] as $param_id=>$param){
			//$error_message.=$param_id.":".$param.", ";
		}
		$error_message.="\n";
	}
	$msg="\n\nDatabase Info\n--------------------------\nError Type Code: {$error_type_code}\nPage Name: {$db[0]['file']}\nLine Number: {$db[0]['line']}";
	$msg.="\n\nMessage\n------------\n{$error_message}";
	//get the contents of the session, post and get variables
	$vars="\n\nSession Variables?\n---------------------\n".(is_array($_SESSION)?list_elements('[SESSION]',$_SESSION):""); 
	$vars.="\n\nGet Variables?\n---------------------\n".(is_array($_GET)?list_elements('[GET]',$_GET):"");
	$vars.="\n\nPost Variables?\n---------------------\n".(is_array($_POST)?list_elements('[POST]',$_POST):"");
	$msg.=$vars."----------------------------------------------------------------------------------------------\n";
	
	
	//mail the error
	$mail_result=mail_error($msg);
	
	
	//write to the file
	$file=fopen(dirname(__FILE__)."/../error_log.txt","a+");
	fwrite($file,date("Y-m-d H:i:s",time()).$msg);
	fclose($file);
	
	$con=mysqli_open();
	//store to the database
	$query="INSERT INTO ".entity."_error(error_type_code,page,line_no,description,variables,date_added) VALUES ('{$error_type_code}','".addslashes($db[0]['file'])."','".addslashes($db[0]['line'])."','".addslashes($error_message)."','".addslashes($vars)."',".time().")";
	$result=mysqli_query($con,$query);
	if (!$result){
		if ($mail_result){
			$return=114;
		}
		else{
			$return=115;
		}
	}
	else{
		if ($mail_result){
			$return=117;
		}
		else{
			$return=116;
		}
	}
	mysqli_close($con);
	return $return;
}

//*Function Name: mail_error
//*Description: This is a helper function that sends the email
//*Input Param 1: text - the message to be sent in the email
//*Return Param 1: an error code indicating whether emailing was successful
function mail_error($text){
	global $developer_team_email;
	global $sender_email;
	$subject = 'Creative Hub Bug Stack Trace'; 			
	$emailadd = $developer_team_email;				
	$headers = "From: {$sender_email}";
	$mail_result = mail($emailadd, $subject, $text, $headers);
	
	return $mail_result;
}

//*Function Name: list_elements
//*Description: This is a helper function that lists the items in an array in a string
//*Input Param 1: array_name - the name of the array
//*Input Param 2: array - the array whose elements are being listed
//*Return Param 1: a string listing of the array's elements
function list_elements($array_name,$array){
	foreach($array as $key=>$value){
		if (is_array($value)){
			$return.=list_elements("{$array_name}[".$key."]",$value);
		}
		else{
			$return.="{$array_name}[{$key}]:{$value}\n";
		}
	}
	return $return;
}

?>