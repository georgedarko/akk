<?php
//*Function Name: validate_user.php
//*Description:#This function checks if a user has the right to access a particular page. It checks the current user against an array of
//valid users � passed as a parameter 
//*Input Param 1: valid_users[],�  array of valid users that can access the current  page
function validate_user($valid_users){
    
    $return = 166; //variable to indicate if user is valid, by default, set to invalid
    //if a cookie is set, load the contents into the session array
    if (!isset($_SESSION[entity."_user"]) || (isset($_SESSION[entity."_user"]["user_id"]) && $_SESSION[entity."_user"]["user_id"] == '')) {
       if (isset($_COOKIE["remember"])&&$_COOKIE["remember"]!="") {
	  $cookie_array=split("<;>", $_COOKIE["remember"]);
	  foreach($cookie_array as $ca){
	    $ca_array=split("<;;>",$ca);
	    $_SESSION[entity."_user"][$ca_array[0]]=$ca_array[1];
	  }
	  //$_SESSION["member"] = array("id"=>$cookie_array[0], "firstname"=>$cookie_array[1], "lastname"=>$cookie_array[2], "phone"=>$cookie_array[3], "email"=>$cookie_array[4]);
       }
    }    
	if (!$_SESSION[entity."_user"]){
		//if the session has expired return teh approriate code
		return 165;
	}
    
    //loop through array and compare users to the current user
   for($i=0; $i<sizeof($valid_users); $i++){
        
        //if user is found, change valid variable
        if($valid_users[$i]==$_SESSION[entity."_user"]['user_type_id']){
            $return = 167;
            break;
        }    
   }
   //if valid variable is not set to 1 -valid user, redirect
   return $return;
}
?>