
<div class="span3">
<script type="text/javascript">
function validate_values(frm){
    element=frm.region_id;
    if (element.options[element.selectedIndex].value=="0"){
        alert ("Select a Region");
        element.focus();
        return false;
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
    element1=frm.f_value_min;
    element2=frm.f_value_max;
    if (element1.value==""&&element2.value!=""){
        alert ("Enter a minimum F value");
        element1.focus();
        return false;
    }    
    if (element2.value==""&&element1.value!=""){
        alert ("Enter a maximum F value");
        element2.focus();
        return false;
    }    
    if (element2.value<=element1.value&&element1.value!=""&&element2.value!=""){
        alert ("Maximum F value must be greater than Minimun F value");
        element2.focus();
        return false;
    }    
    element1=frm.pd_value_min;
    element2=frm.pd_value_max;
    if (element1.value==""&&element2.value!=""){
        alert ("Enter a minimum PD value");
        element1.focus();
        return false;
    }    
    if (element2.value==""&&element1.value!=""){
        alert ("Enter a maximum PD value");
        element2.focus();
        return false;
    }    
    if (element2.value<=element1.value&&element1.value!=""&&element2.value!=""){
        alert ("Maximum PD value must be greater than Minimun PD value");
        element2.focus();
        return false;
    }    
    element1=frm.ic_value_min;
    element2=frm.ic_value_max;
    if (element1.value==""&&element2.value!=""){
        alert ("Enter a minimum IC value");
        element1.focus();
        return false;
    }    
    if (element2.value==""&&element1.value!=""){
        alert ("Enter a maximum IC value");
        element2.focus();
        return false;
    }    
    if (element2.value<=element1.value&&element1.value!=""&&element2.value!=""){
        alert ("Maximum IC value must be greater than Minimun IC value");
        element2.focus();
        return false;
    }    
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
$params[0]['default_text']="Select Region";
$params[0]['item_id']="region_id";
$params[0]['item_name']="region_name";
$params[0]['data']=query("SELECT * FROM akk_region ORDER BY district_name ASC");
$params[1]['array_name']="district_array";
$params[1]['default_text']="All Districts";
$params[1]['item_id']="district_id";
$params[1]['item_name']="district_name";
$params[1]['data']=query("SELECT * FROM akk_district ORDER BY district_name ASC");
echo multi_drop_down($params);
?>
</script>
    <form class="form well" action="index.php?p=query_icnirp&loc=forms" onsubmit="return validate_cell_site(this)" method="post">
            <input type="hidden" name="qt" value="1" />
	  <div class="control-group">
	    <label class="control-label" for="cell_site">Cell Site ID/Name</label>
	    <div class="controls">
	      <input type="text" id="cell_site" name="cell_site" placeholder="Id/Name" class="input-block-level">
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	     <button type="submit" class="btn btn-block btn-success">Search</button>
	    </div>
	  </div>
        </form>
        <form class="form well" action="index.php?p=query_icnirp&loc=forms" onsubmit="return validate_values(this)" method="post">
            <input type="hidden" name="qt" value="2" />
	  <div class="control-group">
	    <label class="control-label" for="region_id">Region</label>
	    <div class="controls">
	      <select id="region_id" name="region_id" class="input-block-level" onchange="reload_options(this.value,this.form.district_id,district_array);">
                  <option value="0">Select Region</option>
                  <?php drop_downs('akk_region','region_id','region_name','region_name',' date_deleted IS NULL')?>
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="district_id">District</label>
	    <div class="controls">
	      <select id="district_id" name="district_id" class="input-block-level">
                  <option value="0">All Districts</option>
	      </select>
	    </div>
	  </div>
	  
	    
                <?php
                $opts=query("SELECT * FROM akk_operator WHERE date_deleted IS NULL");
                if (is_array($opts)){
                    foreach ($opts as $o){
                        echo "
 	      <label class='checkbox'>
	        <input type='checkbox' checked name='operator_id[]' value='".$o['operator_id']."' class='input-block-level'> {$o['operator_name']}
	      </label>
                           
                            ";
                    }
                }
                ?>
                <br/>
	    
	  
	  <div class="control-group">
	    <label class="control-label" for="f_value">F values between</label>
	    <div class="controls">
	      <input type="text" id="f_value_min" name="f_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="f_value_max" name="f_value_max" placeholder="" class="input-block-level" style="width:40%">
	    </div>
	    <label class="control-label" for="pd_value">PD values between</label>
	    <div class="controls">
	      <input type="text" id="pd_value_min" name="pd_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="pd_value_max" name="pd_value_max" placeholder="" class="input-block-level" style="width:40%">
	    </div>
	    <label class="control-label" for="ic_value">IC values between</label>
	    <div class="controls">
	      <input type="text" id="ic_value_min" name="ic_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="ic_value_max" name="ic_value_max" placeholder="" class="input-block-level" style="width:40%">
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	     <button type="submit" class="btn btn-block btn-success">Search</button>
	    </div>
	  </div>
	</form>
</div>
<!-- results -->
<div class="span9">
	
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
				<a href="?p=new_psite&loc=forms"><img src="mos-css/img/posting.png"><br>Add psite</a>
				</div -->
			<?php
                        
				$wc="";
				$ob=$_REQUEST['ob']==""?"psite_name":$_REQUEST['ob'];
				if ($_REQUEST['qt']==1){
                                    $s=" AND (`cell_site_id` LIKE '%{$_REQUEST['cell_site']}%' OR `psite_name` LIKE '%{$_REQUEST['cell_site']}%')";
                                }
                                elseif($_REQUEST['qt']==2){
                                    if ($_REQUEST['ic_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $ic.="OR ic{$x} BETWEEN {$_REQUEST['ic_value_min']} AND {$_REQUEST['ic_value_max']} ";
                                        }
                                    }
                                    if ($_REQUEST['pd_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $pd.="OR pd{$x} BETWEEN {$_REQUEST['pd_value_min']} AND {$_REQUEST['pd_value_max']} ";
                                        }
                                    }
                                    if ($_REQUEST['f_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $f.="OR f{$x} BETWEEN {$_REQUEST['f_value_min']} AND {$_REQUEST['f_value_max']} ";
                                        }
                                    }
                                    if ($ic!=""){
                                        $s=" AND (".substr($ic,2).")";
                                    }
                                    if ($pd!=""){
                                        $s.=" AND (".substr($pd,2).")";
                                    }
                                    if ($f!=""){
                                        $s.=" AND (".substr($f,2).")";
                                    }
                                    if ($_REQUEST['district_id']!=0){
                                        $s.=" AND d.district_id='{$_REQUEST['district_id']}'";
                                    }
                                    else{
                                        $s.=" AND r.region_id='{$_REQUEST['region_id']}'";
                                    }
                                    
                                    $s.=" AND o.operator_id IN (".implode(",", $_REQUEST['operator_id']).")";
                                }
				$query="SELECT p.*,o.operator_name, r.region_name, d.district_name
					       FROM akk_psite p, akk_operator o, akk_district d, akk_region r, akk_psite_operator po
					       WHERE p.date_deleted IS NULL
                                               AND p.district_id=d.district_id
                                               AND d.region_id=r.region_id
                                               AND p.psite_id=po.psite_id
                                               AND o.operator_id=po.operator_id
					       {$s} {$wc}";
					                                           
                                if($_REQUEST['qt']==3){
                                    $query=$_SESSION['query'];
                                }
                                else{
                                  $_SESSION['query']=$query;  
                                }
                                $content=query($query." ORDER BY ".$ob);
                                                   
				$total=count($content);
				if(is_array($content)){
					$num_per_page=15;		//number of rows to show on each page
				
					//determine where the results should start displaying form
					$page=$_REQUEST['page'];
					if($page) 
						$start = ($page - 1) * $num_per_page; 			//first item to display on this page
					else
						$start = 0;			//if no page var is given, set start to 0
				
					//paginate the results
					$pagination=paginate_results("?p=query_icnirp&loc=forms&qt=3&wc={$_REQUEST['wc']}&s={$_REQUEST['s']}".(isset($_REQUEST['ob'])?"&ob={$_REQUEST['ob']}":""),$page,count($content),$num_per_page,5);
				
					$content=array_slice($content,$start,$num_per_page);
					for ($i=0;$i<count($content);$i++){
						$content[$i]['date_added']=date("j M Y ",$content[$i]['date_added']);
						$content[$i]['is_active']=$content[$i]['is_active']==1?"Active":"Disabled";
					}
				}
				$field_names=array("psite_name"=>"Site Name","region_name"=>"Region","district_name"=>"District","operator_name"=>"Operator");
				$field_sizes=array("psite_name"=>250,"region_name"=>150,"district_name"=>200,"operator_name"=>150);
				$actions=array(
					       array("link"=>"?p=psite_detail&loc=pages&psite_id=#-psite_id-#","image"=>"bootstrap/img/detail.png","label"=>"Detail"),
//					       array("link"=>"?p=edit_psite&loc=forms&psite_id=#-psite_id-#","image"=>"mos-css/img/edit.png","label"=>"Edit"),
//					       array("link"=>"actions/delete_psite.php?psite_id=#-psite_id-#&wc=#-psite_name-#","image"=>"mos-css/img/delete.png","label"=>"Delete","other"=>" onclick='return confirm(\"Are you sure you want to delete #-psite_name-#?\")'"),
					       );
				//echo "<div style='float:right; width:400px'><form onsubmit='location.href=\"?p=psite&loc=pages&s=\"+this.s.value; return false;'>Search: <input type='text' name='s' value='{$_REQUEST['s']}' size='30' /><input type='button' value='Go' onclick='location.href=\"?p=psite&loc=pages&s=\"+this.form.s.value' /></form></div>";
				//echo "<div style='text-align: right'>Total: {$total}<br/></div>";
				echo "<h4>Query Results - {$total} cell site(s)</h4>";
				echo "<div class='clear'></div>";

                                echo display_table($content,$field_names,$field_sizes,$actions);
				echo $pagination;
			
		
			}
		?>
</div>