<?php	
die('terminated');
include_once "../functions/housekeeping.php";


$handle = fopen("tempic_un.csv", "r");
//$data = fgetcsv($handle);
$fields=array("psite_id","cell_site_id","psite_name","district_id","f1","pd1","ic1","f2","pd2","ic2","f3","pd3","ic3","f4","pd4","ic4","f5","pd5","ic5","f6","pd6","ic6","f7","pd7","ic7","f8","pd8","ic8","f9","pd9","ic9","f10","pd10","ic10","date_added","added_by");
$fields_o=array("psite_id","operator_id");
$values_o=array();
$psite_id=  get_new_id("akk_psite", "psite_id");
$link=mysqli_open();
for ($i=0;!feof($handle);$i++){
        $data = fgetcsv($handle);
        $district_id=add_or_fetch($data[3],$data[0]);
        $ops=fetch_operators($data[4]);
        if (is_array($ops)){
            foreach ($ops as $o){
                $values_o[]=array(($psite_id+$i),$o);
            }
        }
        else{
            $values_o[]=array(($psite_id+$i),$ops);
        }
        $values[]=array(($psite_id+$i),sql_safe($link,$data[1]),sql_safe($link,$data[2]),$district_id,sql_safe($link,$data[5]),sql_safe($link,$data[6]),sql_safe($link,$data[8]),sql_safe($link,$data[9]),sql_safe($link,$data[10]),sql_safe($link,$data[12]),sql_safe($link,$data[13]),sql_safe($link,$data[14]),sql_safe($link,$data[16]),sql_safe($link,$data[17]),sql_safe($link,$data[18]),sql_safe($link,$data[20]),sql_safe($link,$data[21]),sql_safe($link,$data[22]),sql_safe($link,$data[24]),sql_safe($link,$data[25]),sql_safe($link,$data[26]),sql_safe($link,$data[28]),sql_safe($link,$data[29]),sql_safe($link,$data[30]),sql_safe($link,$data[32]),sql_safe($link,$data[33]),sql_safe($link,$data[34]),sql_safe($link,$data[36]),sql_safe($link,$data[37]),sql_safe($link,$data[38]),sql_safe($link,$data[40]),sql_safe($link,$data[41]),sql_safe($link,$data[42]),sql_safe($link,$data[44]),time(),1);
        if (count($values)>1000){
            echo "<br/><br/><br/>";
            //$result_o=add("akk_psite_operator",$fields_o,$values_o);
            $result=add("akk_psite",$fields,$values);
            flush();
            //$values_o=array();
            $values=array();
        }
}
fclose($handle);

$result=add("akk_psite",$fields,$values);
//echo "<br/><br/><br/>";
$result_o=add("akk_psite_operator",$fields_o,$values_o,true);

mysqli_close($link);

function add_or_fetch($district_name,$region_id){
    $result=query("SELECT * FROM akk_district WHERE district_name='{$district_name}' AND region_id={$region_id}");
    if (is_array($result)){
        return $result[0]['district_id'];
    }
    else{
        $district_id=  get_new_id("akk_district", "district_id");
        add("akk_district",array("district_id","district_name","region_id","date_added","added_by"),array($district_id,$district_name,$region_id,time(),1));
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
