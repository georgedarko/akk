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
$handle = fopen("update2.csv", "r");
$data = fgetcsv($handle);
$fields=array("response","image_url");
$link=mysqli_open();
for ($i=1;!feof($handle);$i++){
        $data = fgetcsv($handle);
        $values=array();
        if ($data[0]!=""){
            for ($j=0;$j<37;$j++){
                $isite_id=$data[0];
                $issue_id=$j+9;
                $issue=read('akk_issue','issue_id',$j,false,$link);
                $response=$issue['non_compliant_response'];
                $col=($j*2)+3;
                if ($data[$col]!=""&&strtolower($data[$col])!="null"){
                    if (substr($data[$col], strlen($data[$col])-4)==".jpg"){
                        $url=$data[1]."/".$data[$col];
                    }
                    else{
                        $url=$data[1]."/".$data[$col].".jpg";
                    }       
                    $values=array($response,$url);
                    $result=update("akk_isite_issue",$fields,$values," isite_id={$isite_id} AND issue_id={$issue_id}",true,$link);
                    flush();
                }
            }

        }
        if (($i%400)==0){
          //die();
        }
}

fclose($handle);


?>
