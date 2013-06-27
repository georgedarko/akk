<?php

session_start();
//include lib files
include_once "../functions/housekeeping.php";

//get the new_id
$isite_id = get_new_id('akk_isite', 'isite_id');

$fields = array('isite_id',);
$values = array($isite_id,);
foreach ($_POST as $pf => $pv) {
    if (stripos($pf, 'frm_') !== false) {
        $fields[] = substr($pf, 4);
        if (stripos($pf, 'date') !== false) {
            $pv = mktime(12, 0, 0, substr($pv, 5, 2), substr($pv, 8, 2), substr($pv, 0, 4));
        }
        $values[] = addslashes($pv);
    }
}
$result = add('akk_isite', $fields, $values);


if ($result == 77) {
    //if save is successful save the operators
    $operator_id = $_REQUEST['operator_id'];
    foreach ($operator_id as $key => $value) {
        $op_fields = array('isite_id', 'operator_id');
        $op_values = array($isite_id, $value);
        $result = add('akk_isite_operator', $op_fields, $op_values);
    }
    if ($result == 77) {
        $is_fields = array('isite_id', 'issue_id', 'response', 'image_url');
        foreach ($_POST as $pf => $pv) {
            if (stripos($pf, 'issue_') !== false) {
                //upload the image
                $_POST['image_'.substr($pf, 6)] = "../uploads/images/" . time() . substr($_FILES['image_'.substr($pf, 6)]["name"], strripos($_FILES['image_'.substr($pf, 6)]["name"], "."));
                if (move_uploaded_file($_FILES['image_'.substr($pf, 6)]["tmp_name"], $_POST['image_'.substr($pf, 6)]) != 1) {
                    header("Location: ../index.php?p=new_site&err=12&loc=forms");
                    exit();
                }
                $is_values = array($isite_id, substr($pf, 6), addslashes($pv), $_FILES['image_'.substr($pf, 6)]['name']);
                $result = add('akk_isite_issue', $is_fields, $is_values);
            }
        }
    }
}
$result = "1" . $result;
header("Location: ../index.php?p=new_site&err={$result}&loc=forms");
exit();
?>
