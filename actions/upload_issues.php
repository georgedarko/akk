<?php	
die('terminated');
include_once "../functions/housekeeping.php";


$handle = fopen("temp.csv", "r");
//$data = fgetcsv($handle);
$fields=array("isite_id","cell_site_id","isite_name","district_id","date_added","added_by");
$fields_i=array("isite_id","issue_id","response","image_url","date_added","added_by");
$values_i=array();
$fields_o=array("isite_id","operator_id");
$values_o=array();
$psite_id=  get_new_id("akk_isite", "isite_id");
$link=mysqli_open();
for ($i=0;!feof($handle);$i++){
        $data = fgetcsv($handle);
        $district_id=add_or_fetch($data[2]);
        $ops=fetch_operators($data[3]);
        if (is_array($ops)){
            foreach ($ops as $o){
                $values_o[]=array(($psite_id+$i),$o);
            }
        }
        else{
            $values_o[]=array(($psite_id+$i),$ops);
        }
        $values[]=array(($psite_id+$i),sql_safe($link,$data[0]),sql_safe($link,$data[1]),$district_id,sql_safe($link,$data[4]),sql_safe($link,$data[5]),sql_safe($link,$data[7]),sql_safe($link,$data[8]),sql_safe($link,$data[9]),sql_safe($link,$data[11]),sql_safe($link,$data[12]),sql_safe($link,$data[13]),sql_safe($link,$data[15]),sql_safe($link,$data[16]),sql_safe($link,$data[17]),sql_safe($link,$data[19]),sql_safe($link,$data[20]),sql_safe($link,$data[21]),sql_safe($link,$data[23]),sql_safe($link,$data[24]),sql_safe($link,$data[25]),sql_safe($link,$data[7]),sql_safe($link,$data[28]),sql_safe($link,$data[29]),sql_safe($link,$data[31]),sql_safe($link,$data[32]),sql_safe($link,$data[33]),sql_safe($link,$data[35]),sql_safe($link,$data[36]),sql_safe($link,$data[37]),sql_safe($link,$data[39]),sql_safe($link,$data[40]),sql_safe($link,$data[41]),sql_safe($link,$data[43]),time(),1);
}
fclose($handle);

$result=add("akk_psite",$fields,$values);
//echo "<br/><br/><br/>";
$result_o=add("akk_psite_operator",$fields_o,$values_o,true);

mysqli_close($link);

function add_or_fetch($district_name){
    $result=query("SELECT * FROM akk_district WHERE district_name='{$district_name}' AND region_id=5");
    if (is_array($result)){
        return $result[0]['district_id'];
    }
    else{
        $district_id=  get_new_id("akk_district", "district_id");
        add("akk_district",array("district_id","district_name","region_id","date_added","added_by"),array($district_id,$district_name,5,time(),1));
        return $district_id;
    }
}

function fetch_operators($operator_name){
    if (stristr($operator_name, "/")!=false){
        $r=split("/",$operator_name);
        foreach($r as $rr){
            $o=read("akk_operator","operator_name",$rr);
            $tot[]=$o['operator_id'];
        }
        return $tot;
    }
    else{
        $o=read("akk_operator","operator_name",$operator_name);
        return $o['operator_id'];
    }
}
?>
