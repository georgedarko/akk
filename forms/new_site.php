<?php
require_once "functions/housekeeping.php";
?>
<div class="">
    <?php echo notify(get_message_text($_REQUEST['err']), $_REQUEST['err']); ?>
    <h4>New Site</h4>
    <hr>
    <form class="form-horizontal" name="new_site" method="post" action="actions/add_site.php" onsubmit="return validate_form()" enctype="multipart/form-data">
        <div class="control-group">
            <label class="control-label" for="site_id">Id</label>
            <div class="controls">
                <input type="text" name="frm_cell_site_id" id="site_id" placeholder="Id">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="site_name">Name</label>
            <div class="controls">
                <input type="text" name="frm_isite_name" id="site_name" placeholder="Name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="region_id">Region</label>
            <div class="controls">
                <select id="region_id" name="region_id" onchange="reload_options(this.value,this.form.frm_district_id,district_array);">
                    <option value="0">Select a Region</option>
                    <?php drop_downs('akk_region', 'region_id', 'region_name', 'region_name', ' date_deleted IS NULL') ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="district_id">District</label>
            <div class="controls">
                <select id="district_id" name="frm_district_id">
                    <option value="0">Select a District</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php
                $opts = query("SELECT * FROM akk_operator WHERE date_deleted IS NULL");
                if (is_array($opts)) {
                    foreach ($opts as $o) {
                        echo "
                <label class='checkbox inline'>
                    <input type='checkbox' checked name='operator_id[]' value='" . $o['operator_id'] . "'> {$o['operator_name']}
                </label>
                             ";
                    }
                }
                ?>
            </div>
        </div>
        <h4>Issues</h4>
        <hr>
        <div>
            <?php
            $radio_array = array();
            $cats = query("SELECT * FROM akk_category WHERE date_deleted IS NULL");
            if (is_array($cats)) {
                foreach ($cats as $c) {
                    echo "
                        <div class='well'>
                            <h5>{$c['category_name']}</h5>";
                    $issues = query("SELECT * FROM akk_issue WHERE category_id='{$c['category_id']}' and date_deleted IS NULL");
                    if (is_array($issues)) {
                        foreach ($issues as $i) {
                            $str_temp = $i['issue_id'];
                            array_push($radio_array, $str_temp);
                            //var_dump($radio_array);
                            echo "
                                <div class='control-group'>
                                <label class='control-label'>{$i['issue_id']}. {$i['issue_text']}</label>
                                <input type='hidden' name='compliant_" . $i['issue_id'] . "' value='{$i['non_compliant_response']}' id='compliant_" . $i['issue_id'] . "'>
                                <div class='controls'>
                                    <label class='radio inline'>
                                        <input type='radio' name='issue_" . $i['issue_id'] . "' value='1' onclick='check_compliance(this)' id='" . $i['issue_id'] . "'> YES
                                    </label>
                                    <label class='radio inline'>
                                        <input type='radio' name='issue_" . $i['issue_id'] . "' value='-1' onclick='check_compliance(this)' id='" . $i['issue_id'] . "'> NO
                                    </label>
                                    <span id='upload_span'>
                                        <input type='file' name='image_" . $i['issue_id'] . "' id='image_" . $i['issue_id'] . "' style='visibility:hidden'>
                                    </span>
                                </div>
                                </div>
                             ";
                        }
                    }
                    echo "</div>";
                }
            }
            ?>
            <script type="text/javascript" language="javascript">
                function check_compliance(obj){
                    var id=obj.id
                    if(obj.value==(document.getElementById("compliant_"+id).value)){
                       document.getElementById("image_"+id).style.visibility='visible';
                    }
                    else{
                      document.getElementById("image_"+id).style.visibility='hidden';  
                    }
                }
                
                //function to validate the new form
                function validate_form(){
				
                    var element
				
                    element = document.getElementById('site_id')
                    if(element.value == ""){
                        alert("Please Enter a Site Id")
                        element.focus()
                        return false
                    }
                    element = document.getElementById('site_name')
                    if(element.value == ""){
                        alert("Please Enter a Site Name")
                        element.focus()
                        return false
                    }
                    element = document.getElementById('region_id')
                    if(element.value == "0"){
                        alert("Please Select a Region")
                        element.focus()
                        return false
                    }
                    element = document.getElementById('district_id')
                    if(element.value == "0"){
                        alert("Please Select a District")
                        element.focus()
                        return false
                    }
                    elements=document.getElementsByName('operator_id[]');
                    var isset=false;
                    for (var i=0;i<elements.length;i++){
                        if (elements[i].checked){
                            isset=true;
                            break;
           
                        }
                    }
                    if (!isset){
                        alert ("Choose one or more operators")
                        return false;
                    }
<?php
foreach ($radio_array as $key => $value) {
    $rgroup_name = 'issue_' . $value . '';
    echo "
            elements = document.getElementsByName('$rgroup_name')
            var isset=false;
            for (var i=0;i<elements.length;i++){
                if (elements[i].checked){
                    isset=true;
                    break;

                }
            }
            if (!isset){
                alert ('Choose a response for Issue {$value}')
                return false;
            }
        ";
}
?>
    }// end of the validate form function 
<?
$params[0]['array_name'] = "region_array";
$params[0]['default_text'] = "Select Region";
$params[0]['item_id'] = "region_id";
$params[0]['item_name'] = "region_name";
$params[0]['data'] = query("SELECT * FROM akk_region ORDER BY district_name ASC");
$params[1]['array_name'] = "district_array";
$params[1]['default_text'] = "All Districts";
$params[1]['item_id'] = "district_id";
$params[1]['item_name'] = "district_name";
$params[1]['data'] = query("SELECT * FROM akk_district ORDER BY district_name ASC");
echo multi_drop_down($params);
?>
            </script>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" id="btn_save" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
</div>