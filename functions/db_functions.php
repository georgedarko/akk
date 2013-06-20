<?php
//* Function Name: mysqli_open
//* Description: This function opens a new mysqli connection and returns the connection.
//* Output Param 1: a mysqli connection
function mysqli_open($debug=false){
	
	global $db_name;
	global $db_pass;
	global $db_user;
	global $db_server_name;
	
	//connect to  db
	$con=mysqli_connect($db_server_name,$db_user,$db_pass,$db_name);
	
	
	if (!$con){
		$con=-1;
		if ($debug)	echo 'Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error();
	}
	return $con;
}


//* Function Name: add
//* Description:This function takes input parameters and inserts a record into a table.
//* Input Param 1: table_name � the name of the table the record is to be added to
//* Input Param 2: field_names � an array of the names
//* Input Param 3: values � the values to be inserted into the table
//* Input Param 4: debug - a boolean variable that determines whether debugging variables should be printed out
//* Input Param 5: con - a connection the function can use to connect to the database
//* Return Param 1: code that can be used to determine what message to display to the user
function add($table_name,$field_names,$values,$debug=false,$con=false){
	
	//create the query string
	if (is_array($values[0])){
		//check if the $values variable is multidimensional. if so, create a batch insert string
		$query="INSERT INTO `{$table_name}` (`".implode("`,`",$field_names)."`) VALUES";
		foreach($values as $row){
			$batch.=",('".implode("','",$row)."')";
		}
		$query.=substr($batch,1);
	}
	else{
		//else, create a normal insert string
		$query="INSERT INTO `{$table_name}` (`".implode("`,`",$field_names)."`) VALUES('".implode("','",$values)."')";		
	}
	//remove any quotes around keywords passed as variables
	$query=str_replace("'*-"," ",$query);
        $query=str_replace("-*'"," ",$query);

        if ($debug) echo $query;
	
	$link=$con?$con:mysqli_open();
	$result=mysqli_query($link,$query);
	if (!$result){ 
		$err=record_error(75,"Error trying to add to {$table_name}\n{$query}\n".mysqli_error($link));
		if ($err==117||$err==114){
			$return="75a";		
		}
		elseif($err==115||$err==116){
			$return="75b";
		}
		/*$return=75;*/
		if ($debug) echo mysqli_error($link);
	}
	else{
		$return= 77;
	}
	
	$con?$con:mysqli_close($link);
	return $return;
}

//* Function Name: update
//* Description:This function takes input parameters and updates a record(s) in a table.
//* Input Param 1: table_name � the name of the table the record is to be added to
//* Input Param 2: field_names � an array of the names
//* Input Param 3: values � the values to be inserted into the table
//* Input Param 4: where_criteria � an sql statement indicating which records should be updated
//* Input Param 5: debug - a boolean variable that determines whether debugging variables should be printed out
//* Input Param 6: con - a connection the function can use to connect to the database
//* Return Param 1: code that can be used to determine what message to display to the user
function update($table_name,$field_names,$values,$where_criteria,$debug=false,$con=false){
	
	//create the query string
	$query="UPDATE `{$table_name}` SET ";
	
	//loop through the array and set the values
	for($i=0; $i<count($field_names);$i++){
		if ($values[$i]==="null"){
			$str.=",`{$field_names[$i]}`=null";
		}
		else{
			$str.=",`{$field_names[$i]}`='{$values[$i]}'";
		}
	}
	
	$query.=substr($str,1)." WHERE ".$where_criteria;

        //remove any quotes around keywords passed as variables
	$query=str_replace("'*-"," ",$query);
        $query=str_replace("-*'"," ",$query);

        if ($debug) echo $query;

	$link=$con?$con:mysqli_open();
	$result=mysqli_query($link,$query);
	if (!$result){ 
		$err=record_error(85,"Error trying to update {$table_name}\n{$query}\n".mysqli_error($link));
		if ($err==117||$err==114){
			$return="85a";		
		}
		elseif($err==115||$err==116){
			$return="85b";
		}
		/*$return=85;*/
		if ($debug) echo mysqli_error($link);
	}
	else{
		$return= 87;
	}
	
	$con?$con:mysqli_close($link);
	return $return;
}

//* Function Name: delete
//* Description:This function takes a table and deletes a record(s) in a table according to the criteria.
//* Input Param 1: table_name � the name of the table from which the record is being deleted
//* Input Param 2: where_criteria � an sql statement indicating which records should be deleted
//* Input Param 3: debug - a boolean variable that determines whether debugging variables should be printed out
//* Input Param 4: con - a connection the function can use to connect to the database
//* Return Param 1: code that can be used to determine what message to display to the user
function delete($table_name,$where_criteria,$debug=false,$con=false){
	
	//create the query string
	$query="DELETE FROM `{$table_name}`  WHERE ".$where_criteria;
	if ($debug) echo $query;


	$link=$con?$con:mysqli_open();
	$result=mysqli_query($link,$query);
	if (!$result){ 
		$err=record_error(95,"Error trying to delete {$table_name}\n{$query}\n".mysqli_error($link));
		if ($err==117||$err==114){
			$return="95a";		
		}
		elseif($err==115||$err==116){
			$return="95b";
		}
		/*$return=95;*/
		if ($debug) echo mysqli_error($link);
	}
	else{
		$return= 97;
	}

	$con?$con:mysqli_close($link);
	return $return;
}


//* Function Name: read
//* Description:This function takes a table and primary key returns the record that matches the primary key
//* Input Param 1: table_name � the name of the table the record is being taken from
//* Input Param 2: field_name � the name of the primary key of that table
//* Input Param 3: field_value � the value of the primary key of that record
//* Input Param 4: debug - a boolean variable that determines whether debugging variables should be printed out
//* Input Param 5: con - a connection the function can use to connect to the database
//* Return Param 1: an array containing the record, or a code that can be used to determine what message to display to the user
function read($table_name,$field_name, $field_value,$debug=false,$con=false){
	
	//create the query string
	$query="SELECT * FROM `{$table_name}` WHERE `{$field_name}`='{$field_value}'";
	if ($debug) echo $query;

	$link=$con?$con:mysqli_open();
	$result=mysqli_query($link,$query);
	if (!$result){ 
		$err=record_error(125,"Error trying to read record from {$table_name}\n{$query}\n".mysqli_error($link));
		if ($err==117||$err==114){
			$return="125a";		
		}
		elseif($err==115||$err==116){
			$return="125b";
		}
		/*$return=125;*/
		if ($debug) echo mysqli_error($link);
	} 
	else{
		$row=mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result)>0){
			//if results are returned, remove any potential slashes
			foreach ($row as  $key=>$value){
				$return[$key]=stripslashes($value);
			}
		}
		else{
			$return="120";
		}
	}
	$con?$con:mysqli_close($link);
	return $return;
}

//* Function Name: query
//* Description:This function takes an SQL statement and runs it. any errors are recorded. code is returned indicating the sucess or otherwise of query. if it is a select query and the query runs successfully, the results are returned.
//* Input Param 1: query � the SQL statement
//* Input Param 2: debug - a boolean variable that determines whether debugging variables should be printed out
//* Input Param 3: con - a connection the function can use to connect to the database
//* Return Param 1: an array containing the result, or a code that can be used to determine what message to display to the user
function query($query,$debug=false,$con=false){
	
	if ($debug) echo $query;
	$link=$con?$con:mysqli_open();
	$result=mysqli_query($link,$query);
	if (!$result){ 
		$err=record_error(125,"Error trying to execute query: \n{$query}\n".mysqli_error($link));
		if ($err==117||$err==114){
			$return="125a";		
		}
		elseif($err==115||$err==116){
			$return="125b";
		}
		/*$return=125;*/
		if ($debug) echo mysqli_error($link);
	} 
	else{
		if ($result===true){
			//if the result is boolean, then it was not a select query.
			$return= 127;
			
		}
		elseif (mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				//if results are returned, remove any potential slashes
				foreach ($row as  $key=>$value){
					$new_row[$key]=stripslashes($value);
				}
				$return[]=$new_row;
			}
		}
		else{
			$return="120";
		}
	}
	$con?$con:mysqli_close($link);
	return $return;	
}

function sql_safe ($link, $var ) { 
	if(get_magic_quotes_gpc()) {
		$var = stripslashes($var);
	}
	return mysqli_real_escape_string($link,$var);
}

?>