<?php
include "Connect.php";
$page_title = 'View Book';
include ('includes/header.html');
$id = $_REQUEST["id"];
$sql = "SELECT * FROM roles WHERE role_id = '$id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
   while($row = mysqli_fetch_assoc($result)){

    $id = $row["role_id"];
    $name = $row["role_name"];
    $desc = $row["Descriptions"];
    
    echo 
    "<div class='cont-card' style='margin-top:10px;'>".
      "<form action='RoleView.php?id=$id' method='POST'>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Role Code :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='roleId' id='roleId' value='$id' readonly/>".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Role Name :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='roleName' id='roleName' value='$name' required/>".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Escriptions :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<textarea type='text' style='resize:none;' class='textbox_form' name='roleDesc' id='roleDesc'>$desc</textarea>".
                "</div>".
              "</div>".
            "<br />".
            "<input type='submit' class='btn btn-red' value='DELETE' name='Delete' id='Delete'/>".
            "<input type='submit' class='btn btn-yellow float-right' value='UPDATE' name='Update' id='Update'/>".
            
      "</form>"
   ."</div>".
   "<br /><br /><br />";

  }
 
  // To Update
  if(isset($_REQUEST["Update"])){
    $message = array();
    //Update New Data
          $r_id = $_REQUEST["id"];
          $r_name = $_REQUEST["roleName"];
          $r_desc = $_REQUEST["roleDesc"];
          
          $sql = "UPDATE roles SET role_name = '$r_name', Descriptions = '$r_desc' Where role_id = $r_id";
         
          if(mysqli_query($conn, $sql)){
            //Refresh page

            $message[] = "Database Updated";

            if($_SESSION["msg_status"] == 'r'){
              // to check if there is no error in Uploading file
              $_SESSION["msg_status"] = 'r';
            }else{
              $_SESSION["msg_status"] = 'g';
            }
            
          }

          $_SESSION["message"] = $message;
          header('Location: '.$_SERVER['REQUEST_URI']);
  }
}
else {
  $message = array();
  $message[] = "Record not exist";
  $_SESSION["msg_status"] = 'r';
  $_SESSION["message"] = $message;
}



if(isset($_REQUEST["Delete"])){
  $r_id = $_REQUEST["id"];

  //Delete from database
  $sql = "DELETE FROM roles WHERE role_id = $r_id";
         
  if(mysqli_query($conn, $sql)){

    $message[] = "succesfully Deleted";
    $_SESSION["msg_status"] = 'g';

    header("Location:index.php");
  }
  else
  {
    //echo "Error ".mysqli_error($conn);
    $message[] = "Delete failed. Error : ".mysqli_error($conn);
    $_SESSION["msg_status"] = 'r';
  }
  $_SESSION["message"] = $message;

}

mysqli_close($conn);
?>