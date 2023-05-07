<?php
include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');
echo "<h1>Welcome</h1>";
echo "<h3>Users List</h3>";

if(isset($_REQUEST["btn_add_student"])){
  header("Location:RegisterStudent.php");
}

  $sql = "SELECT * FROM student";

$result = mysqli_query($conn, $sql);

?>
<form method="Post" action="StudentList.php">
  <input type='submit' class='btn btn-blue-fill float-right' id='btn_add_student' name='btn_add_student' value=' +  Add Student'>
</form>
<br /><br /><br />
<?php
    echo "<table class='tbl_default'>";
      echo "<tr>";
        echo "<th>";
          echo "ID";
        echo "</th>";
        echo "<th>";
          echo "Name";
        echo "</th>";
        echo "<th>";
          echo "Phone";
        echo "</th>";
        echo "<th>";
          echo "Semester";
        echo "</th>";
        echo "<th>";
          echo "Email";
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
              echo $row["student_id"];
            echo "</td>";
            echo "<td>";
              echo $row["s_name"];;
            echo "</td>";
            echo "<td>";
              echo $row["s_phone"];
            echo "</td>";
            echo "<td>";
              echo $row["s_semester"];
            echo "</td>";
            echo "<td>";
              echo $row["s_email"];
            echo "</td>";
            echo "<td>";
              echo "<a href='StudentView.php?id=".$row['student_id']."'><img src='includes/Button/view_button_blue.png' height='25px' width='40px'></a>";
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