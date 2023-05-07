<?php
session_start();

include 'Connect.php';

$id = $_SESSION["LoggersID"];

$sql = "SELECT * from login where UserId = $id";

$result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0)
  {
    echo "<h6 class='badge' style='margin-left:10px; float:left;'>Authorized User<span class='dot' style='margin-right:-3px;'></span></h6>";
  }
  else{
    header("Location:Login.html");
  }

  //Update View Book after view ON ViewBook.php only
  if($page_title == "View Book"){
    $id_book = $_REQUEST["id"];

    $sqlUpd = "SELECT * FROM books WHERE BookID = '$id_book'";

    $resultUpd = mysqli_query($conn, $sqlUpd);

    if(mysqli_num_rows($resultUpd)>0){
      while($row = mysqli_fetch_assoc($resultUpd)){
        if($row["isViewed"] == 0){
          //Update isViewed == 1  in the database because it is currently view
          $isViewedSQL = "UPDATE books SET isViewed = 1 WHERE BookID = $id_book";

          if(mysqli_query($conn, $isViewedSQL)){
          }
          else
          {
            echo "Error ".mysqli_error($conn);
          }
        }
      } 

    }
  }


  //Check New Added Books unviewed yet
  //notification dot popup kt menu
  $sql1 = "SELECT count(isViewed) as bookisviewed FROM books WHERE UserId = $id AND isViewed = 0";

  $result1 = mysqli_query($conn, $sql1);
  if(mysqli_num_rows($result1)>0){
      while($row = mysqli_fetch_assoc($result1)){
          $totalbookviewed = $row["bookisviewed"];

          //visibility of noti dot menu
          if($totalbookviewed > 0){
            $isVisible = "true";
          }else{
            $isVisible = "false";
          }
      }
  }

  //check user's role
  $role = $_SESSION["role_id"];

  $sql2 = "SELECT role_name FROM roles WHERE role_id = $role";

  $result2 = mysqli_query($conn, $sql2);
  if(mysqli_num_rows($result2)>0){
      while($row = mysqli_fetch_assoc($result2)){
          $role_name = $row["role_name"];
      }
    }

?>