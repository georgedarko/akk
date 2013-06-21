<?php
//include lib files
include_once "../functions/housekeeping.php";

	session_start();
        //record_event($_SESSION[entity_'_user']['user_id'],"3","{$_SESSION['chub_user']['first_name']} {$_SESSION['chub_user']['last_name']} logged out");
	setcookie("remember","",-100, '/');
	session_destroy();
        header ("Location: ../index.php");
?>
