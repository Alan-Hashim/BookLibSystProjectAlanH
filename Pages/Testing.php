<?php 

    include "Connect.php";

    $arr_level = array(1,2,3);

    $arr_shelve = array(1,2,3,4,5,6,7,8);

    $arr_category = array(
    '000'=>"Computer Information and General Reference",
    '100'=>"Philosophy and Psychology",
    '200'=>"Religion",
    '300'=>"Social Knowledge",
    '400'=>"Language",
    '500'=>"Science and Mathematics",
    '600'=>"Technology",
    '700'=>"Art and Recreation",
    '800'=>"Literature",
    '900'=>"History and Geography");
    
    foreach($arr_level as $level){
        foreach($arr_shelve as $shelve){
            foreach($arr_category as $cat=>$cat_value){

                    $location_id = $level."-".$shelve."-".$cat;
                    
                    // INSER INTO THE DATABASE FOR LOCATION
                    
                    // $sql = "INSERT INTO location(loc_id, level_no, shelve_no, category_no, category) 
                    // VALUES('$location_id', $level, $shelve, '$cat', '$cat_value')";

                    // if(mysqli_query($conn, $sql)){
                    // echo "Done";
                    // }
                    // else
                    // {
                    // echo "Error : ".mysqli_error($conn);
                    // }


                    echo "----------------->  CODE : ".$location_id."  -------------------->";
                    echo "Level : ".$level."-";
                    echo "Shelve : ".$shelve."-";
                    echo "Category Key : ".$cat." => Category Value :".$cat_value."<br />";

                    
                    
                
                
            }
        }
    }

    // for($level = 0; $level < $level_size; $level++){
    //     echo 

    // }
    
?>


<form method="Post" Action="Testing.php">
    <input type="submit" class="btn btn-green-fill" value="Issue This Book" name="btnIssue" id="btnIssue"/>
</form>

