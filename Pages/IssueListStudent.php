<?php
include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');


  $sss_id= $_SESSION["LoggersID"];
  $sql11 = "SELECT * FROM student WHERE login_id = $sss_id";

  $result111 = mysqli_query($conn, $sql11);

  if(mysqli_num_rows($result111)>0){
    while($row_3 = mysqli_fetch_assoc($result111)){
      $stud_id = $row_3["student_id"];
      $stud_name = $row_3["s_name"];

      echo "<h1>My Issued Books</h1>";
      echo "<h3>All issued List</h3>";
      echo "<h4>STUDENT NAME : ".strtoupper($stud_name)."</h4>";

      if(isset($_REQUEST["btnView"])){
        if($_REQUEST["u_issue"] != 0){
          $i_id = $_REQUEST["u_issue"];
          $sql = "SELECT * FROM issuing_book WHERE status = $i_id And s_id = $stud_id";
        }else{
          $sql = "SELECT * FROM issuing_book WHERE s_id = $stud_id";
        }
        
      }else{
        $sql = "SELECT * FROM issuing_book WHERE s_id = $stud_id";
      }

    }
}

$result = mysqli_query($conn, $sql);

$sql_by_role = "select * from issuing_status";
$result_1 = mysqli_query($conn, $sql_by_role);

?>
        <div class='row'>
          <div class='column-10 float-right'>
            <form method="Post" action="IssueListStudent.php">
              <div class="column-3">
                <select name="u_issue" class="textbox_form">
                  <option value="0">Please Select</option>
                  <?php
                  if(mysqli_num_rows($result_1)>0){
                    while($row = mysqli_fetch_assoc($result_1))
                    {
                        $i_id = $row["stat_id"];
                        $i_name = $row["stat_name"];
                      
                        echo "<option value='".$i_id."'>$i_name</option>";
                    }
                  }
                    ?>
                  </select>
              </div>
              <div class="column-1">
                &nbsp;<input type='submit' class='btn btn-default' id='btnView' name='btnView' value='View'>
              </div>
              
            </form>
          </div>
        </div>
        
<?php

    echo "<table class='tbl_default'>";
      echo "<tr>";
        echo "<th>";
          echo "ID";
        echo "</th>";
        echo "<th>";
          echo "Date Issue";
        echo "</th>";
        echo "<th>";
          echo "Date Return";
        echo "</th>";
        echo "<th>";
          echo "Status";
        echo "</th>";
        echo "<th>";
          echo "Action";
        echo "</th>";
      echo "</tr>";
      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result))
        {
          echo "<tr>";
            echo "<td>";
              echo $row["issue_id"];
            echo "</td>";
            echo "<td>";
              echo $row["date_issue"];;
            echo "</td>";
            echo "<td>";
              echo $row["date_return"];
            echo "</td>";
            echo "<td>";
            $statuses = $row["status"];

            if($statuses == 1){
              echo "Completed";
            }else if($statuses == 2){
              echo "Extend";
            }
            else{
              echo "Pending";
            }
              
            echo "</td>";
            echo "<td>";
              echo "<a href='ViewIssueStudent.php?id=".$row['issue_id']."'><img src='includes/Button/view_button_blue.png' height='25px' width='40px'></a>";
            echo "</td>";
          echo "</tr>";
        }
    echo "</table>";
    mysqli_close($conn);
}
                
if(isset($_REQUEST["btn_add_user"])){
  header("Location:Register.php");
}




?>