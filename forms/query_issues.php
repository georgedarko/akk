<script type="text/javascript">
function validate_values(frm){
    element=frm.response
    if (element.selectedIndex!=0){
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
    /*element=frm.category_id;
    if (element.options[element.selectedIndex].value=="0"){
        alert ("Select a Category");
        element.focus();
        return false;
    }*/    
    return true;
}
function validate_cell_site(frm){
    element=frm.cell_site
    if (element.value==""){
        alert ("Enter an ID or cell site name");
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
$params[1]['data']=query("SELECT DISTINCT d.* FROM akk_district d, akk_isite i WHERE d.district_id=i.district_id ORDER BY district_name ASC");
echo multi_drop_down($params);

$params1[0]['array_name']="category_array";
$params1[0]['default_text']="All Categories";
$params1[0]['item_id']="category_id";
$params1[0]['item_name']="category_name";
$params1[0]['data']=query("SELECT * FROM akk_category");
$params1[1]['array_name']="issue_array";
$params1[1]['default_text']="All Issues";
$params1[1]['item_id']="issue_id";
$params1[1]['item_name']="issue_text";
$params1[1]['data']=query("SELECT * FROM akk_issue");
echo multi_drop_down($params1);
?>
</script>
<div class="row-fluid">
    <div class="span12">
    <form class="form well" action="index.php?p=query_issues&loc=forms" onsubmit="return validate_cell_site(this)" method="post">
            <input type="hidden" name="qt" value="1" />
	  <div class="control-group">
	    <label class="control-label" for="cell_site">Cell Site ID/Name</label>
	    <div class="controls">
	      <input type="text" id="cell_site" name="cell_site" placeholder="Id/Name" class="input-block-level">
	    </div>
	  </div>
	  <div class="row-fluid">
                <div class="pull-right">
                <button class="btn btn-success">Search</button>
                </div>
          </div>
        </form>
        <form class="form well" action="index.php?p=query_issues&loc=forms" onsubmit="return validate_values(this)" method="post">
            <input type="hidden" name="qt" value="2" />
            <div class="row-fluid">
                <div class="span3">
                    <label>Region</label>
                    <select id="region_id" name="region_id" class="input-block-level" onchange="reload_options(this.value,this.form.district_id,district_array);">
                        <option value="0">All Regions</option>
                  <?php 
                  if ($_REQUEST['region_id']!=0){
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
                        if ($_REQUEST['district_id']!=0){
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
            <hr>
            <div class="row-fluid">
                <div class="span5">
                    <label>Category</label>
                    <select type="text" id="category_id" name="category_id"class="input-block-level" onchange="reload_options(this.value,this.form.issue_id,issue_array);">
                        <option value="0">All Categories</option>
                        <?php 
                        if ($_REQUEST['category_id']!=0){
                            drop_downs_selected('akk_category','category_id','category_name',$_REQUEST['category_id'],'category_name',' date_deleted IS NULL');
                        }
                        else{
                            drop_downs('akk_category','category_id','category_name','category_name',' date_deleted IS NULL');
                        }    
                        ?>                        
                    </select>
                </div>
                <div class="span5">
                    <label>Issue</label>
                    <select type="text" id="issue_id" name="issue_id" class="input-block-level">
                        <option value="0">All Issues</option>
                        <?php
                        if ($_REQUEST['issue_id']!=0){
                            drop_downs_selected('akk_issue','issue_id','issue_text',$_REQUEST['issue_id'],'issue_text'," date_deleted IS NULL AND category_id={$_REQUEST['category_id']}");
                        }                        
                        ?>
                    </select>
                </div>
                <div class="span2">
                    <label>Status</label>
                    <select type="text" id="response" name="response" class="input-block-level">
                        <option value="0">Any</option>
                        <option value="1" <?php echo ($_REQUEST['response']==1)?"selected":""?>>Doesn't Conform</option>
                        <option value="-1" <?php echo ($_REQUEST['response']==-1)?"selected":""?>>Conforms</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row-fluid">
                <div class="pull-right">
                <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- results -->
<div class="row-fluid">
    <div class="span12">
        		<?php 

			$is_valid=validate_user(array(1,2));
			if ($is_valid==166){
			    echo notify(get_message_text($is_valid),$is_valid);
			}
			else{
				if ($_REQUEST['err']!=""){
				    echo notify(get_message_text($_REQUEST['err']),$_REQUEST['err']);
				}
			?>
				<!--div class="shortcutHome">
				<a href="?p=new_isite&loc=forms"><img src="mos-css/img/posting.png"><br>Add isite</a>
				</div -->
			<?php
                        
				$wc="";
				$ob=$_REQUEST['ob']==""?"isite_name":$_REQUEST['ob'];
				if ($_REQUEST['qt']==1){
                                    $s=" AND (`cell_site_id` LIKE '%{$_REQUEST['cell_site']}%' OR `isite_name` LIKE '%{$_REQUEST['cell_site']}%')";
                                }
                                elseif($_REQUEST['qt']==2){
                                    if ($_REQUEST['issue_id']!="0"){
                                        $s=" AND iss.issue_id={$_REQUEST['issue_id']}";
                                    }
                                    elseif ($_REQUEST['category_id']!="0"){
                                        $s.=" AND iss.category_id={$_REQUEST['category_id']}";
                                    }
                                    if ($_REQUEST['response']=="-1"){
                                        $s.=" AND iss.non_compliant_response<>ii.response ";
                                    }
                                    elseif($_REQUEST['response']=="1"){
                                        $s.=" AND iss.non_compliant_response=ii.response ";
                                    }
                                    if ($_REQUEST['district_id']!=0){
                                        $s.=" AND d.district_id='{$_REQUEST['district_id']}'";
                                    }
                                    elseif ($_REQUEST['region_id']!=0){
                                        $s.=" AND r.region_id='{$_REQUEST['region_id']}'";
                                    }
                                    
                                    $s.=" AND o.operator_id IN (".implode(",", $_REQUEST['operator_id']).")";
                                }
//                                if ($_REQUEST['category_id']!="0"&&$_REQUEST['category_id']!=""){
                                    $query="SELECT DISTINCT i.*,o.operator_name, r.region_name, d.district_name
                                                FROM akk_isite i, akk_operator o, akk_district d, akk_region r, akk_isite_operator io,akk_isite_issue ii, akk_issue iss  
                                                        
                                                WHERE i.date_deleted IS NULL
                                                AND i.district_id=d.district_id
                                                AND d.region_id=r.region_id
                                                AND i.isite_id=io.isite_id
                                                AND o.operator_id=io.operator_id
                                                AND i.isite_id=ii.isite_id
                                                AND iss.issue_id=ii.issue_id
                                                {$s} {$wc}";
/*                                }
                                else{
                                    $query="SELECT i.*,o.operator_name, r.region_name, d.district_name
                                                FROM akk_isite i, akk_operator o, akk_district d, akk_region r, akk_isite_operator io
                                                WHERE i.date_deleted IS NULL
                                                AND i.district_id=d.district_id
                                                AND d.region_id=r.region_id
                                                AND i.isite_id=io.isite_id
                                                AND o.operator_id=io.operator_id
                                                {$s} {$wc}";
                                }*/
                                if($_REQUEST['qt']==3){
                                    $query=$_SESSION['query'];
                                }
                                else{
                                  $_SESSION['query']=$query;  
                                }
                                $content=query($query." ORDER BY ".$ob);
                                  
				if(is_array($content)){
				$total=count($content);
					$num_per_page=15;		//number of rows to show on each page
				
					//determine where the results should start displaying form
					$page=$_REQUEST['page'];
					if($page) 
						$start = ($page - 1) * $num_per_page; 			//first item to display on this page
					else
						$start = 0;			//if no page var is given, set start to 0
				
					//paginate the results
					$pagination=paginate_results("?p=query_issues&loc=forms&qt=3&wc={$_REQUEST['wc']}&s={$_REQUEST['s']}".(isset($_REQUEST['ob'])?"&ob={$_REQUEST['ob']}":""),$page,count($content),$num_per_page,5);
				
					$content=array_slice($content,$start,$num_per_page);
					for ($i=0;$i<count($content);$i++){
						$content[$i]['date_added']=date("j M Y ",$content[$i]['date_added']);
						$content[$i]['is_active']=$content[$i]['is_active']==1?"Active":"Disabled";
					}
				}
                                else{
                                    $total=0;
                                }
				$field_names=array("isite_name"=>"Site Name","region_name"=>"Region","district_name"=>"District","operator_name"=>"Operator");
				$field_sizes=array("isite_name"=>250,"region_name"=>150,"district_name"=>200,"operator_name"=>150);
				$actions=array(
					       array("link"=>"?p=isite_detail&loc=pages&isite_id=#-isite_id-#","image"=>"bootstrap/img/detail.png","label"=>"Detail"),
//					       array("link"=>"?p=edit_isite&loc=forms&isite_id=#-isite_id-#","image"=>"mos-css/img/edit.png","label"=>"Edit"),
//					       array("link"=>"actions/delete_isite.php?isite_id=#-isite_id-#&wc=#-isite_name-#","image"=>"mos-css/img/delete.png","label"=>"Delete","other"=>" onclick='return confirm(\"Are you sure you want to delete #-isite_name-#?\")'"),
					       );
				//echo "<div style='float:right; width:400px'><form onsubmit='location.href=\"?p=isite&loc=pages&s=\"+this.s.value; return false;'>Search: <input type='text' name='s' value='{$_REQUEST['s']}' size='30' /><input type='button' value='Go' onclick='location.href=\"?p=isite&loc=pages&s=\"+this.form.s.value' /></form></div>";
				//echo "<div style='text-align: right'>Total: {$total}<br/></div>";
				echo isset($_REQUEST['qt'])?"<h4>Query Results - {$total} cell site(s)</h4>":"";
				echo "<div class='clear'></div>";

                                echo display_table($content,$field_names,$field_sizes,$actions);
				echo $pagination;
			
		
			}
		?>
    </div>
</div>