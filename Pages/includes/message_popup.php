<?php
//If error
if($_SESSION["message"] !== null){

  //get status = Error, success or warning
  $status_code = $_SESSION["msg_status"];

  //to assign class acording to status
  $status = "Nothing";

  switch($status_code){
      case 'g' : $status = "cont-green-message"; break;
      case 'r' : $status = "cont-red-message"; break;
      case 'y' : $status = "cont-yellow-message"; break;
  }

  //text box has 2 different color. Distinguished by code. code 'g' box will green. code 'r' box will red.
  echo "<div class='".$status." float-right' style='z-index:1'>";
      foreach($_SESSION["message"] as $msg){
      
          echo "<p>$msg</p>";
      
      }
    echo "</div>";
    $_SESSION["message"] = null;
    $_SESSION["msg_status"] = null;
}

    ?>
    

