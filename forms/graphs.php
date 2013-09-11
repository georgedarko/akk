<script type="text/javascript">
function validate_values(frm){
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
    element=frm.category_id;
    if (element.options[element.selectedIndex].value=="0"){
        alert ("Select a Category");
        element.focus();
        return false;
    }    
    element=frm.issue_id;
    if (element.options[element.selectedIndex].value=="0"){
        alert ("Select a Issue");
        element.focus();
        return false;
    }    
    return true;
}
<?
$params[0]['array_name']="region_array";
$params[0]['default_text']="All Regions";
$params[0]['item_id']="region_id";
$params[0]['item_name']="region_name";
$params[0]['data']=query("SELECT * FROM akk_region");
$params[1]['array_name']="district_array";
$params[1]['default_text']="All Districts";
$params[1]['item_id']="district_id";
$params[1]['item_name']="district_name";
$params[1]['data']=query("SELECT * FROM akk_district");
echo multi_drop_down($params);

$params1[0]['array_name']="category_array";
$params1[0]['default_text']="Select Category";
$params1[0]['item_id']="category_id";
$params1[0]['item_name']="category_name";
$params1[0]['data']=query("SELECT * FROM akk_category");
$params1[1]['array_name']="issue_array";
$params1[1]['default_text']="Select an Issue";
$params1[1]['item_id']="issue_id";
$params1[1]['item_name']="issue_text";
$params1[1]['data']=query("SELECT DISTINCT i.* FROM akk_issue i, akk_isite_issue ii WHERE i.issue_id=ii.issue_id AND response+non_compliant_response<>0");
echo multi_drop_down($params1);
?>
</script>
<div class="row-fluid">
    <div class="span12">
        <form class="form well" action="index.php?p=graphs&loc=forms" onsubmit="return validate_values(this)" method="post">
            <input type="hidden" name="qt" value="2" />
            <div class="row-fluid">
                <div class="span5">
                    <label>Category</label>
                    <select type="text" id="category_id" name="category_id"class="input-block-level" onchange="reload_options(this.value,this.form.issue_id,issue_array);">
                        <option value="0">Select a Category</option>
                        <?php 
                        if ($_REQUEST['category_id']!=0){
                            drop_downs_selected('akk_category c,akk_issue i, akk_isite_issue ii','category_id','category_name',$_REQUEST['category_id'],'category_name'," c.date_deleted IS NULL AND i.date_deleted IS NULL AND ii.date_deleted IS NULL AND c.category_id=i.category_id AND i.issue_id=ii.issue_id AND response+non_compliant_response<>0 GROUP BY c.category_id");
                        }
                        else{
                            drop_downs('akk_category c,akk_issue i, akk_isite_issue ii','category_id','category_name','category_name'," c.date_deleted IS NULL AND i.date_deleted IS NULL AND ii.date_deleted IS NULL AND i.issue_id=ii.issue_id AND c.category_id=i.category_id  AND response+non_compliant_response<>0 GROUP BY c.category_id");
                        }    
                        ?>                        
                    </select>
                </div>
                <div class="span5">
                    <label>Issue</label>
                    <select type="text" id="issue_id" name="issue_id" class="input-block-level">
                        <option value="0">Select an Issue</option>
                        <?php
                        if ($_REQUEST['issue_id']!="0"){
                            drop_downs_selected('akk_issue i, akk_isite_issue ii','issue_id','issue_text',$_REQUEST['issue_id'],'issue_text'," i.date_deleted IS NULL AND ii.date_deleted IS NULL AND category_id={$_REQUEST['category_id']} AND i.issue_id=ii.issue_id AND response+non_compliant_response<>0 GROUP BY i.issue_id");
                        }                        
                        ?>
                    </select>
                </div>
                <!-- div class="span2">
                    <label>Compliant</label>
                    <select type="text" id="response" name="response" class="input-block-level">
                        <option value="0">Any</option>
                        <option value="1">Yes</option>
                        <option value="-1">No</option>
                    </select>
                </div -->
            </div>
            <hr>
            <div class="row-fluid">
                <div class="span3">
                    <label>Region</label>
                    <select id="region_id" name="region_id" class="input-block-level" onchange="reload_options(this.value,this.form.district_id,district_array);">
                        <option value="0">All Region</option>
                  <?php 
                  if ($_REQUEST['region_id']!="0"){
                    drop_downs_selected('akk_region','region_id','region_name',$_REQUEST['region_id'],'region_name',' date_deleted IS NULL');
                  }
                  else{
                      drop_downs('akk_region','region_id','region_name','region_name',' date_deleted IS NULL');
                  }
                            ?>
                    </select>
                </div>
                <div class="span3">
                    <label>District</label>
                    <select id="district_id" name="district_id" class="input-block-level">
                        <option value="0">All Districts</option>
                     <?php 
                        if ($_REQUEST['district_id']!="0"){
                            drop_downs_selected('akk_district','district_id','district_name',$_REQUEST['district_id'],'district_name'," date_deleted IS NULL AND region_id={$_REQUEST['region_id']}");
                        }
                    ?>
                   </select>
                </div>
                <div class="span5">
                    <label>Operator</label>
                    <?php
                    $opts=query("SELECT * FROM akk_operator WHERE date_deleted IS NULL");
                if (is_array($opts)){
                    foreach ($opts as $o){
                        if (isset($_REQUEST['operator_id'])){
                            echo "
                                <label class='checkbox inline'>
                                    <input type='checkbox'  name='operator_id[]' ".(in_array($o['operator_id'],$_REQUEST['operator_id'])?"checked":"")." value='".$o['operator_id']."'> {$o['operator_name']}
                                </label>

                                ";
                        }
                        else{
                            echo "
                                <label class='checkbox inline'>
                                    <input type='checkbox' checked name='operator_id[]' value='".$o['operator_id']."'> {$o['operator_name']}
                                </label>

                                ";
                        }
                    }
                }
                    ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="pull-right">
                <button class="btn btn-success">Graph</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- results -->
<div class="row-fluid">
    <div class="span12">
        		<?php 
				
                                if($_REQUEST['qt']==2){
                                        $s=" AND iss.issue_id={$_REQUEST['issue_id']}";
                                    if ($_REQUEST['district_id']!=0){
                                        $s.=" AND d.district_id='{$_REQUEST['district_id']}'";
                                    }
                                    elseif ($_REQUEST['region_id']!=0){
                                        $s.=" AND r.region_id='{$_REQUEST['region_id']}'";
                                    }
                                    
                                    $s.=" AND o.operator_id IN (".implode(",", $_REQUEST['operator_id']).")";
                               
                                    $data=query("SELECT o.operator_name, COUNT( DISTINCT i.isite_id) AS cell_site_count
                                                FROM akk_isite i, akk_operator o, akk_district d, akk_region r, akk_isite_operator io,akk_isite_issue ii, akk_issue iss  
                                                        
                                                WHERE i.date_deleted IS NULL
                                                AND i.district_id=d.district_id
                                                AND d.region_id=r.region_id
                                                AND i.isite_id=io.isite_id
                                                AND o.operator_id=io.operator_id
                                                AND i.isite_id=ii.isite_id
                                                AND iss.issue_id=ii.issue_id
                                                AND (ii.response+non_compliant_response)<>0 
                                                {$s}
                                                GROUP BY o.operator_id");

                                    /*          $ss.=" WHERE o.operator_id IN (".implode(",", $_REQUEST['operator_id']).")";
                               
                                    $data=query("SELECT o.operator_name, COUNT( DISTINCT rest.isite_id) AS cell_site_count 
                                                FROM akk_operator o LEFT JOIN (SELECT i.*,io.operator_id
                                                FROM akk_isite i, akk_isite_issue ii, akk_issue iss, akk_isite_operator io, akk_district d, akk_region r 
                                                WHERE i.isite_id=ii.isite_id 
                                                AND ii.issue_id=iss.issue_id 
                                                AND i.isite_id=io.isite_id 
                                                AND d.district_id=i.district_id 
                                                AND d.region_id=r.region_id 
                                                {$s}
                                                AND (ii.response+non_compliant_response)<>0 ) rest ON o.operator_id=rest.operator_id
                                                WHERE o.operator_id IN (1,2,3,4,5,6)
                                                GROUP BY o.operator_id",true);
                        */
                                }

                                    //form the xml for the graph
                                    $data_string="<graph caption='Non-Compliant Cell Site Count' xAxisName='Operator' yAxisName='Number of Cell Sites' showNames='1' showValues='1' rotateNames='0' showColumnShadow='1' animation='1' showAlternateHGridColor='1' numDivLines='2' AlternateHGridColor='ff5904' divLineColor='ff5904' divLineAlpha='20' alternateHGridAlpha='5' decimalPrecision='0' canvasBorderColor='666666' baseFontColor='666666'>";
                                    //only add data if  results were returned 

                                    if (is_array($data)){
                                        foreach ($data as $row){
                                                $data_string.="<set name='{$row['operator_name']}' value='{$row['cell_site_count']}' hoverText='{$row['operator_name']}' />";
                                        }
                                    }
                                    else{
                                        //echo "No data found.";
                                    }
                                    $data_string.="</graph>";
                                ?>
                                <div id="cell_frequency_div">The chart will appear within this DIV. This text will be replaced by the chart.</div>
                                <script type="text/javascript">
                                var cell_frequency = new FusionCharts("FusionCharts/Charts/FCF_Column2D.swf?ChartNoDataText=No data found.", "cell_frequency_graph", "980", "600");
                                cell_frequency.addParam("WMode", "Transparent");
                                cell_frequency.setDataXML("<?php echo $data_string ?>");
                                cell_frequency.render("cell_frequency_div");
                                </script>
    </div>
</div>