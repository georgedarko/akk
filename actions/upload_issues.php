<?php	

include_once "../functions/housekeeping.php";
$imgs=query("SELECT * FROM akk_isite_issue WHERE image_url  IS NOT NULL");
foreach ($imgs as $i){
    if ($i['image_url']!=""){
        if (!is_file("../../akk1/{$i['image_url']}")){
            echo $i['isite_id']."-".$i['issue_id']."<br/>";
            $akk[]=$i['isite_issue_id'];
        }
    }
}    echo implode(",",$akk);
die('terminated'.count($akk));
$handle = fopen("temp_un.csv", "r");
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
            $icount++;
            if (yes_no($data[$col])==$iss['non_compliant_response']){
                $inccount++;
                if ($data[$col+1]!=""&&$data[$col+1]!="null"){
                    $incpiccount++;
                    if (substr($data[$col+1], strlen($data[$col+1])-4)==".jpg"){
                        $url=$data[$col+1];
                    }
                    else{
                        $url=$data[$col+1].".jpg";
                    }
                    $values_i[]=array(($isite_id+$i),$iss['issue_id'],yes_no($data[$col]),$data[2]."/".$url,time(),1);
                    if (is_file("../../akk1/".$data[2]."/".$url)){
                        
                        $nopicarray2[]=$isite_id+$i;
                    }
                }
                else{
                    $incnopiccount++;
                    $nopicarray[]=$isite_id+$i;
                    $values_i[]=array(($isite_id+$i),$iss['issue_id'],($iss['non_compliant_response']*-1),"*-null-*",time(),1);
                }
            }
            else{
                $iccount++;
                $values_i[]=array(($isite_id+$i),$iss['issue_id'],$iss['non_compliant_response']*(-1),"*-null-*",time(),1);
            }
            
        }
        $values[]=array(($isite_id+$i),sql_safe($link,$data[1]),sql_safe($link,$data[2]),$district_id,time(),1);
        if (count($values_i)>1000){
            echo "<br/><br/><br/>";
            $result_i=add("akk_isite_issue",$fields_i,$values_i);
            flush();
            $values_i=array();
        }
        
}
fclose($handle);

$result=add("akk_isite",$fields,$values);
echo "<br/><br/><br/>";
$result_o=add("akk_isite_operator",$fields_o,$values_o);
echo "issue count:$icount<br/>
    issue non compliant:$inccount<br/>
    issue non compliant picture:$incpiccount<br/>
    issue non compliant no picture:$incnopiccount<br/>
    issue compliant:$iccount<br/><br/><br/>
    no pics at all:".count($nopicarray)."--".implode(",",$nopicarray)."<br/>
    should be pics:".count($nopicarray2)."--".  implode(",", $nopicarray2);

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
    /*if ($val==1) return "YES";
    if (strtoupper(trim($val))=="YES") return 1;
    if ($val==-1) return "NO";
    if (strtoupper(trim($val))=="YES") return -1;*/
    return 15;
}
?>
