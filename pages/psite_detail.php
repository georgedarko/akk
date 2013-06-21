<?php 
    $link=mysqli_open();
    $psite_id=sql_safe($link,$_REQUEST['psite_id']);
    $data=read("akk_psite","psite_id",$psite_id);
?>
<style>
    .text-bold{
        font-weight: bold;
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
				<?php echo $data['psite_name'] ?>
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
                                    $operators=query("SELECT * FROM akk_operator o, akk_psite_operator po WHERE po.operator_id=o.operator_id AND  psite_id={$psite_id} ");
                                    foreach ($operators as $o){
                                        $str=", {$o['operator_name']}";
                                    }
                                    echo substr($str,2);
                                
                                ?>
			</td>
		</tr>
	</table>
	<h4>ICNIRP VALUES</h4>
	<table class="table table-bordered">
		<tr>
			<?php
                        for ($i=1;$i<11;$i++){
                            echo "
                            <tr>
                                <td>
                                        F{$i}
                                </td>
                                <td class='text-bold'>
                                        {$data['f'.$i]} MHz
                                </td>
                                <td>
                                        PD{$i}
                                </td>
                                <td class='text-bold'>
                                        {$data['pd'.$i]} W/m2
                                </td>
                                <td>
                                        IC{$i}
                                </td>
                                <td class='text-bold'>
                                        {$data['ic'.$i]} W/m2
                                </td>
                             </tr>
                                ";
                        }
                        ?>

	</table>
        <a href="?p=query_icnirp&loc=forms&qt=3" class="btn btn-success">Back</a>
</div>