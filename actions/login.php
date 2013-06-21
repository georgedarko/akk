<?php
//include lib files
include_once "../functions/housekeeping.php";

    $link=mysqli_open();
    $email=sql_safe($link,$_REQUEST['email']);
    $password=sha1($_REQUEST['password']);
    $result=query("SELECT * FROM akk_user WHERE email='{$email}' AND `password` ='{$password}' AND date_deleted IS NULL ",false,$link);
    if ($result=="125a"&&$result=="125b"){
        $return=str_replace("12","",$result);
        mysqli_close($link);
        header("Location: ../?p=login&loc=forms&err=5");
        exit();
    }
    
    if (is_array($result)){
        session_start();
        $row=$result[0];
        //if the user has been disabled, return to the login page with that error message
        if ($row['is_active']==0){
            header("Location: ../?p=login&loc=forms&err=3");
            mysqli_close($link);
            exit();
        }
        $_SESSION[entity.'_user']=$row;
        //record_event($row['user_id'],"1","{$row['first_name']} {$row['last_name']} logged in");
        if ($_REQUEST['frm_remember']=="1"){
            foreach ($row as $key=>$value){
                $cookie_string.="<;>".$key."<;;>".$value;
            }
            setcookie("remember", substr($cookie_string,3), time()+1209600, '/');
        }

        header("Location: ../?p=query_icnirp&loc=forms");
        mysqli_close($link);
        exit();
    }
    else{
        header("Location: ../?p=login&loc=forms&err=6");
        mysqli_close($link);
        exit();
    }

?>