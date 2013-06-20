<?php

//*Function Name: record_event
//*Description: This function records an event in the database and in a file.
//*Input Param 1: user_id - the id of the user who triggered the event
//*Input Param 2: event_type - the type of event e.g. add, modify, delete, login etc
//*Input Param 3: description - some text giving details abt the event
//*Return Param 1: an error code indicating whether the recording of the event was successful
function record_event($user_id,$event_type,$description){
	
	//form the string to write to the file
	$msg=date("Y-m-d",time()).",".date("H:i:s",time()).",".$user_id.",".$_SERVER['REMOTE_ADDR'].",".$event_type.",".$description."\r\n";

	//write to the file
	$file=fopen(dirname(__FILE__)."/../event_log.txt","a+");
	fwrite($file,$msg);
	fclose($file);


	$con=mysqli_open();
	$fields=array('user_id','remote_ip','event_type_code','description','date_added');
	$values=array($user_id,$_SERVER['REMOTE_ADDR'],$event_type,addslashes($description),time());
	$result=add(entity.'_event',$fields,$values);
	if ($result==75){
		$err=record_error(75,"Error while recording event.\n{$query}\nMySql Error:".mysqli_error($con));
		if ($err==117||$err==114){
			$return="105a";		
		}
		elseif($err==115||$err==116){
			$return="105b";
		}
	}
	elseif ($result==77){
		$return=107;
	}
	mysqli_close($con);
	return $return;
}



?>