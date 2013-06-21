<?php	
die('terminated');
include_once "../functions/housekeeping.php";


$handle = fopen("temp.csv", "r");
$data = fgetcsv($handle);
$fields=array("isite_id","cell_site_id","isite_name","district_id","date_added","added_by");
$fields_i=array("isite_id","issue_id","response","image_url","date_added","added_by");
$values_i=array();
$issues=query("SELECT * FROM akk_issue");
$fields_o=array("isite_id","operator_id");
$values_o=array();
$isite_id=  get_new_id("akk_isite", "isite_id");
$link=mysqli_open();
for ($i=0;!feof($handle);$i++){
        $data = fgetcsv($handle);
        $district_id=add_or_fetch($data[3],$data[0]);
        $ops=fetch_operators($data[4]);
        if (is_array($ops)){
            foreach ($ops as $o){
                $values_o[]=array(($isite_id+$i),$o);
            }
        }
        else{
            $values_o[]=array(($isite_id+$i),$ops);
        }
        foreach($issues as $iss){
            $col=($iss['issue_id']*2)+3;
            if (yes_no($data[$col])==$iss['non_compliant_response']){
                if ($data[$col+1]!=""&&$data[$col+1]!="null"){
                    if (substr($data[$col+1], strlen($data[$col+1])-4)==".jpg"){
                        $url=$data[$col+1];
                    }
                    else{
                        $url=$data[$col+1].".jpg";
                    }
                    $values_i[]=array(($isite_id+$i),$iss['issue_id'],yes_no($data[$col]),$data[2]."/".$url,time(),1);
                }
                else{
                    $values_i[]=array(($isite_id+$i),$iss['issue_id'],($iss['non_compliant_response']*-1),"*-null-*",time(),1);
                }
            }
            else{
                $values_i[]=array(($isite_id+$i),$iss['issue_id'],$iss['non_compliant_response']*(-1),"*-null-*",time(),1);
            }
            
        }
        $values[]=array(($isite_id+$i),sql_safe($link,$data[1]),sql_safe($link,$data[2]),$district_id,time(),1);
        if (count($values_i)>1000){
            echo "<br/><br/><br/>";
            $result_i=add("akk_isite_issue",$fields_i,$values_i,true);
            flush();
            $values_i=array();
        }
        
}
fclose($handle);

$result=add("akk_isite",$fields,$values);
echo "<br/><br/><br/>";
$result_o=add("akk_isite_operator",$fields_o,$values_o,true);
//echo "<br/><br/><br/>";
//$result_i=add("akk_isite_issue",$fields_i,$values_i,true);
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

function yes_no($val){
    if ($val==1) return "YES";
    if (strtoupper($val)=="YES") return 1;
    if ($val==-1) return "NO";
    if (strtoupper($val)=="YES") return -1;
}
?>
