<?php 
    $link=mysqli_open();
    $isite_id=sql_safe($link,$_REQUEST['isite_id']);
    $data=read("akk_isite","isite_id",$isite_id);
?>
<style>
    .text-bold{
        font-weight: bold;
    }
    .red{
        color: #DD0000;
    }
    .green{
        color: #00DD00;
    }
</style>
<!-- details -->
<div class="span12">
	<h4>Cell Site Details</h4>
	<table class="table table-bordered">
		<tr>
			<td>
				ID
			</td>
			<td class="text-bold">
				<?php echo $data['cell_site_id'] ?>
			</td>
		<tr>
		</tr>
			<td>
				Cell Site Name
			</td>
			<td class="text-bold">
				<?php echo $data['isite_name'] ?>
			</td>
		<tr>
		</tr>
			<td>
				Region
			</td>
			<td class="text-bold">
				<?php 
                                    $district=read("akk_district","district_id",$data['district_id'] );
                                    $region=read("akk_region","region_id",$district['region_id'] );
                                    echo $region['region_name'];
                                
                                ?>
			</td>
		<tr>
		</tr>
			<td>
				District
			</td>
			<td class="text-bold">
				<?php 
                                    
                                    echo $district['district_name'];
                                
                                ?>
			</td>
		<tr>
		</tr>
			<td>
				Operators
			</td>
			<td class="text-bold">
				<?php 
                                    $operators=query("SELECT * FROM akk_operator o, akk_isite_operator io WHERE io.operator_id=o.operator_id AND isite_id={$isite_id} ");
                                    foreach ($operators as $o){
                                        $str=", {$o['operator_name']}";
                                    }
                                    echo substr($str,2);
                                
                                ?>
			</td>
		</tr>
	</table>
	<h4>Cell Site ISSUES </h4>
	<table class="table table-bordered">
		<tr>
			<?php
                        $issues=query("SELECT * FROM akk_isite_issue ii, akk_issue i WHERE i.issue_id=ii.issue_id AND ii.isite_id={$isite_id}");
                        foreach ($issues as $i){
                            $color=$i['response']==$i['non_compliant_response']?"red":"green";
                            echo "
                            <tr>
                                <td class='text-bold'>
                                        {$i['issue_text']}
                                </td>
                                <td class='text-bold {$color}'>
                                        ".yes_no($i['response'])."
                                </td>
                             </tr>
                                ";
                        }
                        ?>

	</table>
        <a href="?p=query_icnirp&loc=forms&qt=3" class="btn btn-success">Back</a>
</div>