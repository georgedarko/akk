<script type="text/javascript">
function validate_values(){
    return true;
}
function validate_cell_site(){
    return true;
}
</script>
<div class="span3">
	<form class="form well" action="index.php?p=query_icnirp&loc=forms" onsubmit="return validate_cell_site()" method="post">
            <input type="hidden" name="qt" value="1" />
	  <div class="control-group">
	    <label class="control-label" for="cell_site">Cell Site ID/Name</label>
	    <div class="controls">
	      <input type="text" id="cell_site" name="frm_cell_site" placeholder="Id/Name" class="input-block-level">
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	     <button type="submit" class="btn btn-block btn-success">Search</button>
	    </div>
	  </div>
        </form>
        <form class="form well" action="index.php?p=query_icnirp&loc=forms" onsubmit="return validate_values()" method="post">
            <input type="hidden" name="qt" value="1" />
	  <div class="control-group">
	    <label class="control-label" for="frm_region">Region</label>
	    <div class="controls">
	      <select id="frm_region" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="frm_district">District</label>
	    <div class="controls">
	      <select id="frm_district" class="input-block-level">
	      </select>
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
                <?php
                $opts=query("SELECT * FROM akk_operator WHERE date_deleted IS NULL");
                if (is_array($opts)){
                    foreach ($opts as $o){
                        echo "
 	      <label class='checkbox'>
	        <input type='checkbox' name='' class='input-block-level'> MTN
	      </label>
                           
                            ";
                    }
                }
                ?>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_tigo" class="input-block-level"> Tigo
	      </label>
	      <label class="checkbox">
	        <input type="checkbox" id="frm_vodafone" class="input-block-level"> Vodafone
	      </label>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_expresso" class="input-block-level"> Expresso
	      </label>
		  <label class="checkbox">
	        <input type="checkbox" id="frm_glo" class="input-block-level"> Glo
	      </label>
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="f_value">F values between</label>
	    <div class="controls">
	      <input type="text" id="f_value_min" name="frm_f_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="f_value_max" name="frm_f_value_max" placeholder="" class="input-block-level" style="width:40%">
	    </div>
	    <label class="control-label" for="pd_value">PD values between</label>
	    <div class="controls">
	      <input type="text" id="pd_value_min" name="frm_pd_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="pd_value_max" name="frm_pd_value_max" placeholder="" class="input-block-level" style="width:40%">
	    </div>
	    <label class="control-label" for="ic_value">IC values between</label>
	    <div class="controls">
	      <input type="text" id="ic_value_min" name="frm_ic_value_min" placeholder="" class="input-block-level" style="width:40%">
	      &nbsp;&nbsp;AND&nbsp;&nbsp; <input type="text" id="ic_value_max" name="frm_ic_value_max" placeholder="" class="input-block-level" style="width:40%">
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
	<h4>Query Results</h4>
        		<?php 

			$is_valid=167;//validate_user(array(1));
			if ($is_valid==166){
			    echo notify(get_message_text($is_valid),$is_valid);
			}
			else{
				if ($_REQUEST['err']!=""){
				    echo notify(get_message_text($_REQUEST['err']),$_REQUEST['err']);
				}
			?>
				<!--div class="shortcutHome">
				<a href="?p=new_department&loc=forms"><img src="mos-css/img/posting.png"><br>Add Department</a>
				</div -->
				
				<div class="clear"></div>
			<?php
				$wc="";
				$ob=$_REQUEST['ob']==""?"psite_name":$_REQUEST['ob'];
				if ($_REQUEST['qt']==1){
                                    $s=" AND (`cell_site_id` LIKE '%{$_REQUEST['cell_site']}%' OR `psite_name` LIKE '%{$_REQUEST['cell_site']}%')";
                                }
                                elseif($_REQUEST['qt']==2){
                                    if ($_REQUEST['ic_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $ic.="OR ic_{$x} BETWEEN {$_REQUEST['ic_value_min']} AND {$_REQUEST['ic_value_max']} ";
                                        }
                                    }
                                    if ($_REQUEST['pd_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $pd.="OR pd_{$x} BETWEEN {$_REQUEST['pd_value_min']} AND {$_REQUEST['pd_value_max']} ";
                                        }
                                    }
                                    if ($_REQUEST['f_value_min']!=""){
                                        for ($x=1;$x<11;$x++){
                                            $f.="OR f_{$x} BETWEEN {$_REQUEST['f_value_min']} AND {$_REQUEST['f_value_max']} ";
                                        }
                                    }
                                    if ($ic!=""){
                                        $s="AND (".substr($ic,2).")";
                                    }
                                    if ($pd!=""){
                                        $s.="AND (".substr($pd,2).")";
                                    }
                                    if ($f!=""){
                                        $s.="AND (".substr($f,2).")";
                                    }
                                    $s=" AND";
                                }
				$content=query("SELECT d.*, COUNT(je.employee_id) as employee_count
					       FROM chub_department d LEFT JOIN
							(SELECT e.employee_id, j.department_id
							FROM chub_job j, chub_employee e, chub_job_history jh
							WHERE e.employee_id=jh.employee_id
							AND j.job_id=jh.job_id
							AND jh.severance_date IS NULL
							AND j.date_deleted IS NULL
							AND e.date_deleted IS NULL
							AND jh.date_deleted IS NULL) je
						ON d.department_id=je.department_id
					       WHERE d.date_deleted IS NULL
					       {$s} {$wc}
					       GROUP BY d.department_id
					       ORDER BY ".$ob);
				$total=count($content);
				if(is_array($content)){
					$num_per_page=10;		//number of rows to show on each page
				
					//determine where the results should start displaying form
					$page=$_REQUEST['page'];
					if($page) 
						$start = ($page - 1) * $num_per_page; 			//first item to display on this page
					else
						$start = 0;			//if no page var is given, set start to 0
				
					//paginate the results
					$pagination=paginate_results("?p=department&loc=pages&wc={$_REQUEST['wc']}&s={$_REQUEST['s']}".(isset($_REQUEST['ob'])?"&ob={$_REQUEST['ob']}":""),$page,count($content),$num_per_page,5);
				
					$content=array_slice($content,$start,$num_per_page);
					for ($i=0;$i<count($content);$i++){
						$content[$i]['date_added']=date("j M Y ",$content[$i]['date_added']);
						$content[$i]['is_active']=$content[$i]['is_active']==1?"Active":"Disabled";
					}
				}
				$field_names=array("department_name"=>"Department Name","employee_count"=>"Number of Employees");
				$field_sizes=array("department_name"=>450,"employee_count"=>150);
				$actions=array(
//					       array("link"=>"?p=department_detail&loc=pages&department_id=#-department_id-#","image"=>"mos-css/img/detail.png","label"=>"Detail"),
					       array("link"=>"?p=edit_department&loc=forms&department_id=#-department_id-#","image"=>"mos-css/img/edit.png","label"=>"Edit"),
					       array("link"=>"actions/delete_department.php?department_id=#-department_id-#&wc=#-department_name-#","image"=>"mos-css/img/delete.png","label"=>"Delete","other"=>" onclick='return confirm(\"Are you sure you want to delete #-department_name-#?\")'"),
					       );
				//echo "<div style='float:right; width:400px'><form onsubmit='location.href=\"?p=department&loc=pages&s=\"+this.s.value; return false;'>Search: <input type='text' name='s' value='{$_REQUEST['s']}' size='30' /><input type='button' value='Go' onclick='location.href=\"?p=department&loc=pages&s=\"+this.form.s.value' /></form></div>";
				//echo "<div style='text-align: right'>Total: {$total}<br/></div>";
				echo display_table($content,$field_names,$field_sizes,$actions);
				echo $pagination;
			
		
			}
		?>
</div>