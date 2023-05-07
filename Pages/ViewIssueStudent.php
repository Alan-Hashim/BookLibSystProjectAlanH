<?php
include "Connect.php";
$page_title = 'Book List';
include ('includes/header.html');


if(isset($_REQUEST["Delete"])){

  $id = $_REQUEST["id"];

  $sql = "SELECT * FROM issuing_book WHERE issue_id = '$id'";

  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
      $b_id = $row["b_id"];
    }
  }
  $sql1 = "UPDATE books SET status = 'Available' WHERE BookID = $b_id";
    
    if(mysqli_query($conn, $sql1)){
    $message[] = "Book Available";
    $_SESSION["msg_status"] = 'g';
    }
    else
    {
    $message[] = "Error : ".mysqli_error($conn);
    $_SESSION["msg_status"] = 'r';
    //echo "Error ".mysqli_error($conn);
    }

  $r_id = $_REQUEST["id"];

  //Delete from database
  $sql = "DELETE FROM issuing_book WHERE issue_id = $r_id";
         
  if(mysqli_query($conn, $sql)){

    $message[] = "succesfully Deleted";
    $_SESSION["msg_status"] = 'g';

    header("Location:IssueListStudent.php");
  }
  else
  {
    //echo "Error ".mysqli_error($conn);
    $message[] = "Delete failed. Error : ".mysqli_error($conn);
    $_SESSION["msg_status"] = 'r';
  }

  $_SESSION["message"] = $message;
}

$id = $_REQUEST["id"];

$sql = "SELECT * FROM issuing_book WHERE issue_id = '$id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_assoc($result)){
    $ib_sid = $row["s_id"];
    $ib_bid = $row["b_id"];
    $ib_date_issue = $row["date_issue"];
    $ib_date_return = $row["date_return"];
    $ib_status = $row["status"];

    if($ib_date_return != null){
      $hidden_btn_completed = "hidden";
    }
    $sql_by_role2 = "select * from issuing_status where stat_id=$ib_status";
    $result_2 = mysqli_query($conn, $sql_by_role2);
    if(mysqli_num_rows($result_2)>0){
      while($row = mysqli_fetch_assoc($result_2))
      {
        $stat_name = $row["stat_name"];
      }
    }
    

    //get book name
    $sqlbname = "SELECT * FROM books WHERE BookID = $ib_bid";

    $resultbname = mysqli_query($conn, $sqlbname);

    if(mysqli_num_rows($resultbname)>0){
      while($row = mysqli_fetch_assoc($resultbname)){
         $b_name = $row["BookName"];
      }
    }
//get student name
    $sql1sname = "SELECT * FROM student WHERE student_id = $ib_sid";

    $resultsname = mysqli_query($conn, $sql1sname);

    if(mysqli_num_rows($resultsname)>0){
      while($row = mysqli_fetch_assoc($resultsname)){
         $s_name = $row["s_name"];
      }
    }
    ?>
    
    
    <h1 style="text-align: center;">Profile</h1>
      <form method="POST" name="login" Action="ViewIssueStudent.php?id=<?php echo $id ?>">
          <br />
          <div class="row">
              <div class="column-3">
                  Student Name
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="sid" value="<?php echo $s_name ?>" id="sid" readonly/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Book Title :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="bid" value="<?php echo $b_name ?>" id="bid" readonly/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Date Issue :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="dti" value="<?php echo $ib_date_issue ?>" id="dti" readonly/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Date return :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="dtr" value="<?php echo $ib_date_return ?>" id="dtr" readonly/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  status :
              </div>
              <div class="column-7">
                <input type="text" class="textbox_form" name="stat" value="<?php echo $stat_name ?>" id="stat" readonly/>
              </div>
          </div>
          <br />
          <input type="submit" class="btn btn-red <?php echo $hidden_btn_completed?>" value="Cancel Issuing" name="Delete" id="Delete"/>
          <br />
      </form>
    
    <?php
  }
}
else {
  echo "its empty";
}





mysqli_close($conn);
?>
