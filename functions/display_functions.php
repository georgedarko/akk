<?php
    //* Function Name: resize_dimensions
    //* Description: This function takes in the length and width of an image and the length and width that the function caller wants to resize to. the function then returns an array containing the new dimensions which meet the target lenghth or width depending on which is more limiting. It also maintains the aspect ratio.
    //* Input Param 1: width � the current width of the image
    //* Input Param 2: height � the current height of the image
    //* Input Param 3: target_width � the desired resized width
    //* Input Param 4: target_height � the desired resized height
    //* Return Param 1: an array with two elements - 'width' and 'height' holding the resized values
    function resize_dimensions($width, $height, $target_width, $target_height){ 
            
            $percentage_w = ($target_width / $width); 
            $percentage_h = ($target_height / $height); 
            
            if ($percentage_h>$percentage_w)
                $percentage=$percentage_w;
            else
                $percentage=$percentage_h;
            //gets the new value and applies the percentage, then rounds the value 
            $width = round($width * $percentage); 
            $height = round($height * $percentage); 
            
            //returns the new sizes 
            $dimension['width']=$width;
            $dimension['height']=$height;
            
            return $dimension; 
            
    } 

    //* Function Name: get_message_text
    //* Description: This function takes a message code and returns the associated display message for that code
    //* Input Param 1: code � the code of the message is to be displayed
    //* Return Param 1: the  message text   
    function get_message_text($code){
            global $messages;
            
            //check the error variable to see if it has been set
            if ($code==""){
                    //if it has not been set, set the return to nothing nothing
                    $return="";
            }
            else{
                    if (isset($messages["{$code}"])){ 
                            //if it was able to get the error message from the array, then return the message
                            $message=$messages["{$code}"]; 
                    }
                    else{
                            //else return a default message
                            $message="An unknown error occured. Contact the Administrators with this error code:{$code}";
                            
                    }                               
                    $return=$message;
            }
            
            return $return;
    }
    
    //* Function Name: notify
    //* Description: This function takes a message and formats and displays it
    //* Input Param 1: message �  the message is to be displayed
    //* Input Param 2: error � the code of the error message
    //* Input Param 3: [optional] type � the type of format to use. options are, success, warning, error and information
    //* Return Param 1: the  message text   
    function notify($message,$error,$type="false"){
        if ($type=="false"){
            //decide the format of the notification based on what type of error it is
            if (substr($error,strlen($error)-1,1)==7){
                    //if it's a success use green and the succes image
                   $type="sukses";
            }
            /*elseif(substr($error,strlen($error)-1,1)=="a"){
                    //if it's an error that was communicated to the developers use yellow and the warning image
                    $type="informasi";
            }*/
            else{
                    //anything else use red and the error image
                    $type="gagal";
            }            
        }

        if ($message!=""){
            $return="<div class='{$type}'>{$message}</div>";
        }
        else{
            $return="";
        }
        return $return;
    }

    //* Function Name: drop_downs
    //* Description: This function is meant to populate the items of a drop down list with the appropirate html code. Input parameters point it to the data source
    //* Input Param 1: table_name � the table containing the data
    //* Input Param 2: id_value � the field in the database that will be used to populate the value attribute of the drop down option
    //* Input Param 3: name_value � the field(s) in the database that will be used to populate teh display text of the drop down option
    //* Input Param 4: [Optional] order_by_field � the field by which the data being retrieved should be sorted and whether it should be ascending or descending e.g. last_name DESC
    //* Input Param 5: [Optional] where_criteria � the sql code for the where criteria, in case the results of the search need to be filtered
    //* Input Param 6: [Optional] max_length � the maximum length of text to show in the display text of the drop down option
    function drop_downs($table_name, $id_value, $name_value, $order_by_field=false, $where_criteria=false, $max_length=256)
    {
            $link=mysqli_open();
            $queryString = "SELECT * FROM ".$table_name.($where_criteria==false?"":" WHERE ".$where_criteria).($order_by_field==false?"":" ORDER BY ".$order_by_field);
            $query = mysqli_query($link,$queryString);
            //echo mysql_error().$queryString;
            while($row = mysqli_fetch_assoc($query))
            {
                    $id = $row[$id_value];
                    $name="";
                    if (is_array($name_value)){
                        foreach ($name_value as $nv){
                            $name.=stripslashes($row[$nv])." ";
                        }
                    }
                    else{
                        $name = stripslashes($row[$name_value]);                                
                    }
                                                                            
                    echo "<option value = '".$id."'>".(strlen($name)>$max_length?(trim(substr($name,0,$max_length-2))."..."):$name)."</option>";
            }						
            mysqli_close($link);
            
    }
    
    //* Function Name: dropdowns_selected
    //* Description: This function is meant to populate the items of a drop down list with the appropirate html code and select a specified option by default. Input parameters point it to the data source
    //* Input Param 1: table_name � the table containing the data
    //* Input Param 2: id_value � the field in the database that will be used to populate the value attribute of the drop down option
    //* Input Param 3: name_value � the field(s) in the database that will be used to populate teh display text of the drop down option
    //* Input Param 4: selected_id - the id of the element that should be selected when the drop down has loaded
    //* Input Param 5: [Optional] order_by_field � the field by which the data being retrieved should be sorted and whether it should be ascending or descending e.g. last_name DESC
    //* Input Param 6: [Optional] where_criteria � the sql code for the where criteria, in case the results of the search need to be filtered
    //* Input Param 7: [Optional] max_length � the maximum length of text to show in the display text of the drop down option
    function drop_downs_selected($table_name, $id_value, $name_value, $selected_id, $order_by_field=false, $where_criteria=false, $max_length=256)
    {//start of the drop downs function
                                                                            
                    $link=mysqli_open();
                    $queryString = "SELECT * FROM ".$table_name.($where_criteria==false?"":" WHERE ".$where_criteria).($order_by_field==false?"":" ORDER BY ".$order_by_field);
                    $query = mysqli_query($link,$queryString);
                    while($row = mysqli_fetch_assoc($query))
                    {
                            $id = $row[$id_value];
                            $name="";
                            if (is_array($name_value)){
                                foreach ($name_value as $nv){
                                    $name.=stripslashes($row[$nv])." ";
                                }
                            }
                            else{
                                $name = stripslashes($row[$name_value]);                                
                            }
                            
                            if($id == $selected_id)
                            {							
                            echo "<option value = '".$id."' selected='selected'>".(strlen($name)>$max_length?(trim(substr($name,0,$max_length-2))."..."):$name)."</option>";
                            }
                            else
                            {
                            echo "<option value = '".$id."' >".(strlen($name)>$max_length?(trim(substr($name,0,$max_length-2))."..."):$name)."</option>";
                            }
                    }
                    mysqli_close($link);
    }

    //* Function Name: multi_drop_down.php
    //* Description:This function produces the javascript code that allows for the creating of multiple dropdowns which are dependent on each other
    //* Input Param 1: params[] � an associative multi-dimensional array with the following fields: item_id, item_name, default_text, array_name, function
    //* Input Param 2: used_once � a boolean variable that indicates if the function has been used once already on that page so the javascript function is not redefined
    //* Return Param 1: error_code if it was unable to retreive from the database. it retreival was successeful, then a string of javascript code will be returned 
    function multi_drop_down($params,$used_once=false){
            //this variable is to hold the javascript string for declaring the variables
            $var_declaration="";
            //this variable is to hold the javascript string for assigning the default values
            $default_assignment="";
            //this variable is to hold the javascript string for populating the array
            $array_string="";
            //this variable holds the code for the javascript function that will do the reloading of the drop downs
            $function_call="
            function reload_options(curr_value,drop_down,array){
                    drop_down.options.length=0;
                    if (array[curr_value]==null){
                            curr_value=0;
                    }
                    for (var i=0; i<array[curr_value].length;i++){
                            if (array[curr_value][i]!=null)
                                    drop_down.options[i]=array[curr_value][i];
                    }
            }
            
            ";
            //this variable is to hold the parent array name of an array that is being populated
            $parent_array_name="";
            //this variable is to hold the id field of the parent of an array that is being populated
            $parent_item_id="";
            //loop through the params creating the string
            foreach($params as $level){
                    $var_declaration.="var {$level['array_name']}=new Array();\n";
                    $default_assignment.="{$level['array_name']}[0]=new Array(new Option('{$level['default_text']}',0,false,false));\n";
                    
                    //get the items of the current level from the db
                    $where=array(array("field"=>"date_deleted","symbol"=>"IS","value"=>"NULL", "operand"=>"AND"));
                    $sort=array(" {$level['item_name']} ASC");
                    if ($parent_array_name!=""&&$parent_item_id!=""){
                            $result=$level['data'];
                            if (is_array($result)){
                                    //the array for forming the string
                                    $array_str=array();
                                    //form the string
                                    foreach ($result as $row){
                                            //form the opening part of the string if it hasn't been formed already
                                            if (!$array_str[$row[$parent_item_id]]['opening']){
                                                    $array_str[$row[$parent_item_id]]['opening']="{$level['array_name']}[".$row[$parent_item_id]."]= new Array(new Option('{$level['default_text']}',0,false,false)";
                                            }
                                            //form the main part of the string
                                            $array_str[$row[$parent_item_id]]['main'].=",new Option('".$row[$level['item_name']]."',".$row[$level['item_id']].",false,false)";
                                    }
                                    //loop through the string array and form the combined sing string to be returned
                                    foreach($array_str as $str){
                                            $array_string.=$str['opening'].$str['main'].");\n";
                                    }
                            }
                            else {
                                    break;
                            }
                    }
                    //store the name and id as the parent for the next item
                    $parent_array_name=$level['array_name'];
                    $parent_item_id=$level['item_id'];
                    
            }
            return $var_declaration."\n\n".$default_assignment."\n\n".$array_string."\n\n".($used_once==false?$function_call:"");
    }
 
    //* Function Name: paginate_results
    //* Description: This function creates a set of links to be used for pagination when given the total number of rows and number of rows to be displayed per page
    //* Input Param 1: target_page -  the page (displaying the paginted list) to go to when each link is clicked
    //* Input Param 2: $page �  the current page being viewed
    //* Input Param 3: $total_rows �  total number of rows to be paginated
    //* Input Param 4: [optional] limit � number of rows to be shown on each page, 20 by default
    //* Input Param 5: [optional] adjacents �  number of links to be shown on the left AND right of the link in focus (i.e. page currently being viewed), 3 by default
    //* Input Param 6: [optional] ajax �  the ajax/javascript function to call instead of the target page link)
    //* Return Param:  a string containg the html code for the pagination links
    function paginate_results($target_page,$page,$total_rows,$limit=20,$adjacents=3,$ajax=false){
                    
            /* Setup page vars for display. */
            if ($page == 0) $page = 1;					//if no page var is given, default to 1.
            $prev = $page - 1;							//previous page is page - 1
            $next = $page + 1;							//next page is page + 1
            $lastpage = ceil($total_rows/$limit);		//lastpage is = total pages / items per page, rounded up.
            $lpm1 = $lastpage - 1;						//last page minus 1
            
            /* 
                    Now we apply our rules and draw the pagination object. 
                    We're actually saving the code to a variable in case we want to draw it more than once.
            */
            $pagination = "";
            if($lastpage > 1)
            {	
                    $pagination .= "<div class=\"pagination\">";
                    //previous button
                    if ($page > 1) 
                            $pagination.= "<a href=\"$target_page&page=$prev\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$prev,$ajax)."; \"":"").">&laquo; previous</a>";
                    else
                            $pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
                    
                    //pages	
                    if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
                    {	
                            for ($counter = 1; $counter <= $lastpage; $counter++)
                            {
                                    if ($counter == $page)
                                            $pagination.= "<span class=\"current\">$counter</span>";
                                    else
                                            $pagination.= "<a href=\"$target_page&page=$counter\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$counter,$ajax)."; \"":"").">$counter</a>";					
                            }
                    }
                    elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
                    {
                            //close to beginning; only hide later pages
                            if($page < 1 + ($adjacents * 2))		
                            {
                                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                                    {
                                            if ($counter == $page)
                                                    $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                    $pagination.= "<a href=\"$target_page&page=$counter\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$counter,$ajax)."; \"":"").">$counter</a>";					
                                    }
                                    $pagination.= "...";
                                    $pagination.= "<a href=\"$target_page&page=$lpm1\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$lpml,$ajax)."; \"":"").">$lpm1</a>";
                                    $pagination.= "<a href=\"$target_page&page=$lastpage\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$lastpage,$ajax)."; \"":"").">$lastpage</a>";		
                            }
                            //in middle; hide some front and some back
                            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                            {
                                    $pagination.= "<a href=\"$target_page&page=1\"".($ajax!=false?" onClick=\"return ".str_replace('page_num','1',$ajax)."; \"":"").">1</a>";
                                    $pagination.= "<a href=\"$target_page&page=2\"".($ajax!=false?" onClick=\"return ".str_replace('page_num','2',$ajax)."; \"":"").">2</a>";
                                    $pagination.= "...";
                                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                                    {
                                            if ($counter == $page)
                                                    $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                    $pagination.= "<a href=\"$target_page&page=$counter\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$counter,$ajax)."; \"":"").">$counter</a>";					
                                    }
                                    $pagination.= "...";
                                    $pagination.= "<a href=\"$target_page&page=$lpm1\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$lpml,$ajax)."; \"":"").">$lpm1</a>";
                                    $pagination.= "<a href=\"$target_page&page=$lastpage\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$lastpage,$ajax)."; \"":"").">$lastpage</a>";		
                            }
                            //close to end; only hide early pages
                            else
                            {
                                    $pagination.= "<a href=\"$target_page&page=1\"".($ajax!=false?" onClick=\"return ".str_replace('page_num','1',$ajax)."; \"":"").">1</a>";
                                    $pagination.= "<a href=\"$target_page&page=2\"".($ajax!=false?" onClick=\"return ".str_replace('page_num','2',$ajax)."; \"":"").">2</a>";
                                    $pagination.= "...";
                                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                                    {
                                            if ($counter == $page)
                                                    $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                    $pagination.= "<a href=\"$target_page&page=$counter\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$counter,$ajax)."; \"":"").">$counter</a>";					
                                    }
                            }
                    }
                    
                    //next button
                    if ($page < $counter - 1) 
                            $pagination.= "<a href=\"$target_page&page=$next\"".($ajax!=false?" onClick=\"return ".str_replace('page_num',$next,$ajax)."; \"":"").">next &raquo;</a>";
                    else
                            $pagination.= "<span class=\"disabled\">next &raquo;</span>";
                    $pagination.= "</div>\n";		
            }
            return $pagination;
    }

    //* Function Name: display_table
    //* Description: This function takes input and returns a table with sorting functionality and search box
    //* Input Param 1: content - the multidimensional array containing the data to be displayed in the table
    //* Input Param 2: field_titles – an associative array matching the field names with the titles that should show in the table header
    //* Input Param 3: field_sizes – an associative array matching the fields names with the sizes
    //* Input Param 4: actions - a multidimensional array showing the actions that can take place on each row. fields of each element are label, image, link and other. The link should contain the following character sequence "#-field_name-#". The field name be replaced by the actual value of the field in that row
    function display_table($content, $field_titles, $field_sizes, $actions=false)
    {
        // start of the table
        $table="<table class='table table-striped table-bordered'>";
        
        //start the header for the table;
        $header="<thead class='data'>";
        
        //loop through the GET variables to form the link for the header sort
        foreach ($_GET as $f=>$v){
            if ($f!="ob"){
                $sort_link.="&{$f}=$v";
            }            
        }
        $sort_link=$_SERVER['PHP_SELF']."?".substr($sort_link,1);
        
	//loop through the field names so we can display the titles
	foreach ($field_titles as $name=>$title){
		//if ($col_count==0){
		//	$header.="<th width='{$field_sizes[$col_count]}'><input type='{$input_type}' onclick='select_all(this,\"{$name}s[]\")' /></td>";
		//}
		//else{
			//$header.="<th width='{$field_sizes[$col_count]}'>{$title}</th>";
		//}
                $header.="<th width='{$field_sizes[$name]}' class='data'><a href='{$sort_link}&ob=".(stripos($_REQUEST['ob'],$name)!==false?(stripos($_REQUEST['ob'],"ASC")!==false?$name." ASC":$name." DESC"):$name)."'><strong>{$title}</strong></a></th>";
	}
        //if there are action links/buttons, add a column for that but only if there are acuall results to display
        //$header.="<form onsubmit='location.href=\"".$_SERVER['PHP_SELF']."?p=".$_GET['p']."&loc=".$_GET['loc']."&s=\"+this.s.value; return false;'><th class='data'>Search: <input type='text' name='s' value='{$_REQUEST['s']}' /><input type='button' value='Go' onclick='location.href=\"".$_SERVER['PHP_SELF']."?p=".$_GET['p']."&loc=".$_GET['loc']."&s=\"+this.form.s.value' /></th></form>";
        $header.="<th class='data'></th></form>";
            
        // end the header for the table;
        $header.="</thead>\n";
        
        //run through the content and display the data
        $row_count=0;   //initialize the row count
	
        if ($content==120){
            //if there is nothing in the content, display a no results 
            $body="<tr class='data'><td colspan='".(count($field_titles)+1)."'><strong>No Results to display</strong></td></tr>";
	}
        elseif (!is_array($content)){
            //if there is nothing in the content, display a no results 
            $body="<tr class='data'><td colspan='".(count($field_titles))."'><strong>".get_message_text($content)."</strong></td></tr>";
        }
        else{
            //loop through the cells of that row and display their content
            $row_count=0;
            foreach ($content as $row){
                //determine which class should apply to the row
                //$class=($row_count%2)?"odd":"even";
                //start the row
                $body.="<tr class='data'>";
                foreach ($field_titles as $name=>$title){
                        //if ($col_count==0){
                        //        //add a check box in the first column
                        //        $body.="<td width='{$field_sizes[$col_count]}'><input type='{$input_type}' name='{$name}s[]' value='{$row[$name]}' /></td>";
                        //        //get the item id so we can use it for the action links
                        //        $item_id=$row[$name];
                        //}
                        //else{
                                $body.="<td width='{$field_sizes[$name]}' class='data'>{$row[$name]}</td>";			
                        //}
                }
                //if there are actions to show
                if (is_array($actions)){
                    $body.="<td class='data'>";
                    foreach ($actions as $a){
                        //some complicated code to replace the place holder with value
                        while (strpos($a['link'],"#-")!==false){
                            $pos=strpos($a['link'],"#-");
                            $pos2=strpos($a['link'],"-#",$pos+1);
                            $field_name=substr($a['link'],$pos+2,$pos2-($pos+2));
                            $a['link']=str_replace("#-{$field_name}-#",$row[$field_name],$a['link']);
                        }
                        while (strpos($a['label'],"#-")!==false){
                            $pos=strpos($a['label'],"#-");
                            $pos2=strpos($a['label'],"-#",$pos+1);
                            $field_name=substr($a['label'],$pos+2,$pos2-($pos+2));
                            $a['label']=str_replace("#-{$field_name}-#",$row[$field_name],$a['label']);
                        }
                        while (strpos($a['other'],"#-")!==false){
                            $pos=strpos($a['other'],"#-");
                            $pos2=strpos($a['other'],"-#",$pos+1);
                            $field_name=substr($a['other'],$pos+2,$pos2-($pos+2));
                            $a['other']=str_replace("#-{$field_name}-#",$row[$field_name],$a['other']);
                        }
                        $body.="<a href='{$a['link']}' title='{$a['label']}' {$a['other']}><img class='il' src='{$a['image']}' border='0' /></a>&nbsp;&nbsp;";
                    }
                    $body.="</td>";
                }
                //end the row
                $body.="</tr>\n";
                $row_count++;
            }
            
        }
        $table.=$header.$body."</table>";
        return $table;
    }

    //* Function Name: check_boxes
    //* Description: This function is meant to populate the items of a drop down list with the appropirate html code. Input parameters point it to the data source
    //* Input Param 1: chk_name � the name of the checkboxes
    //* Input Param 2: table_name � the table containing the data
    //* Input Param 3: id_value � the field in the database that will be used to populate the value attribute of the drop down option
    //* Input Param 4: name_value � the field(s) in the database that will be used to populate teh display text of the drop down option
    //* Input Param 5: [Optional] order_by_field � the field by which the data being retrieved should be sorted and whether it should be ascending or descending e.g. last_name DESC
    //* Input Param 6: [Optional] where_criteria � the sql code for the where criteria, in case the results of the search need to be filtered
    //* Input Param 7: [Optional] chk_class � the name of the css class that will apply to the checkboxes
    //* Return Param: an array of checkboxes which can be placed as desired
    function check_boxes($chk_name, $table_name, $id_value, $name_value, $order_by_field=false, $where_criteria=false, $chk_class='')
    {
            $link=mysqli_open();
            $queryString = "SELECT * FROM ".$table_name.($where_criteria==false?"":" WHERE ".$where_criteria).($order_by_field==false?"":" ORDER BY ".$order_by_field);
            $query = mysqli_query($link,$queryString);
            //echo mysql_error().$queryString;
            $chk_string=array();
            while($row = mysqli_fetch_assoc($query))
            {
                    $id = $row[$id_value];
                    $name="";
                    if (is_array($name_value)){
                        foreach ($name_value as $nv){
                            $name.=stripslashes($row[$nv])." ";
                        }
                    }
                    else{
                        $name = stripslashes($row[$name_value]);                                
                    }
                                                                            
                    $chk_string[]="<input name='{$chk_name}' class='$chk_class' type='checkbox' value = '".$id."' />".$name;
            }						
            mysqli_close($link);
            return $chk_string;
            
    }
    
    //* Function Name: check_boxes_selected
    //* Description: This function is meant to populate the items of a drop down list with the appropirate html code and select a specified option by default. Input parameters point it to the data source
    //* Input Param 1: chk_name � the name of the checkboxes
    //* Input Param 2: table_name � the table containing the data
    //* Input Param 3: id_value � the field in the database that will be used to populate the value attribute of the drop down option
    //* Input Param 4: name_value � the field(s) in the database that will be used to populate teh display text of the drop down option
    //* Input Param 5: selected_id - the id of the element that should be selected when the drop down has loaded
    //* Input Param 6: [Optional] order_by_field � the field by which the data being retrieved should be sorted and whether it should be ascending or descending e.g. last_name DESC
    //* Input Param 7: [Optional] where_criteria � the sql code for the where criteria, in case the results of the search need to be filtered
    //* Input Param 8: [Optional] chk_class � the name of the css class that will apply to the checkboxes
    //* Return Param: an array of checkboxes which can be placed as desired
    function check_boxes_selected($chk_name, $table_name, $id_value, $name_value, $selected_id, $order_by_field=false, $where_criteria=false, $max_length=256)
    {//start of the drop downs function
                                                                            
            $link=mysqli_open();
            $queryString = "SELECT * FROM ".$table_name.($where_criteria==false?"":" WHERE ".$where_criteria).($order_by_field==false?"":" ORDER BY ".$order_by_field);
            $query = mysqli_query($link,$queryString);
            $chk_string=array();
            while($row = mysqli_fetch_assoc($query))
            {
                    $id = $row[$id_value];
                    $name="";
                    if (is_array($name_value)){
                        foreach ($name_value as $nv){
                            $name.=stripslashes($row[$nv])." ";
                        }
                    }
                    else{
                        $name = stripslashes($row[$name_value]);                                
                    }
                    
                    if(in_array($id,$selected_id,true))
                    {							
                        $chk_string[]="<input name='{$chk_name}' class='$chk_class' type='checkbox' value = '".$id."' checked />".$name;
                    }
                    else
                    {
                        $chk_string[]="<input name='{$chk_name}' class='$chk_class' type='checkbox' value = '".$id."' />".$name;
                    }
            }
            mysqli_close($link);
             return $chk_string;
   }
    
?>