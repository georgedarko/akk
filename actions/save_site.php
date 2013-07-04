<?php

session_start();
//include lib files
include_once "../functions/housekeeping.php";

//get the id for the update
$isite_id = $_POST['isite_id'];

//upload the images and issues first
$result = delete('akk_isite_issue', "isite_id='{$isite_id}'");
if ($result == 97) {
    foreach ($_POST as $pf => $pv) {
        if (stripos($pf, 'issue_') !== false) {
            $is_fields = array('isite_id', 'issue_id', 'response', 'image_url');
            //upload the image
            if ($_FILES['image_' . substr($pf, 6)]['name'] != "") {
                if (copy($_FILES['image_' . substr($pf, 6)]['tmp_name'], '../uploads/' . $_FILES['image_' . substr($pf, 6)]['name']) != 1) {
                    header("Location: ../index.php?p=edit_site&err=12&loc=forms");
                    exit();
                }
                $is_values = array($isite_id, substr($pf, 6), addslashes($pv), $_FILES['image_' . substr($pf, 6)]['name']);
                $result = add('akk_isite_issue', $is_fields, $is_values);
            } else {
                $is_fields = array('isite_id', 'issue_id', 'response');
                $is_values = array($isite_id, substr($pf, 6), addslashes($pv));
                $result = add('akk_isite_issue', $is_fields, $is_values);
            }
        }
    }
}

//if successful add the operator values
if ($result == 77) {
    $result = delete('akk_isite_operator', "isite_id='{$isite_id}'");
    if ($result == 97) {
        $operator_id = $_REQUEST['operator_id'];
        foreach ($operator_id as $key => $value) {
            $op_fields = array('isite_id', 'operator_id');
            $op_values = array($isite_id, $value);
            $result = add('akk_isite_operator', $op_fields, $op_values);
        }
    }
    if ($result == 77) {
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
        $result = update('akk_isite', $fields, $values, "isite_id='{$isite_id}'");
    }
}

$result = "1" . $result;
header("Location: ../index.php?p=edit_site&err={$result}&loc=forms&isite_id={$isite_id}");
exit();
?>
