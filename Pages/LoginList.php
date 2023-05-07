<?php
include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');
echo "<h1>Welcome</h1>";
echo "<h3>Users List</h3>";


if(isset($_REQUEST["btnView"])){
  if($_REQUEST["u_role"] != 0){
    $r_id = $_REQUEST["u_role"];
    $sql = "SELECT * FROM login where a_role = $r_id";
  }else{
    $sql = "SELECT * FROM login WHERE a_role <> 3";
  }
  
}else{
  $sql = "SELECT * FROM login WHERE a_role <> 3";
}

$result = mysqli_query($conn, $sql);

$sql_by_role = "select * from roles where role_id > 1 And role_id <> 3";
$result_1 = mysqli_query($conn, $sql_by_role);

?>
        <div class='row'>
          <div class='column-10 float-right'>
            <form method="Post" action="LoginList.php">
              <div class="column-3">
                <select name="u_role" class="textbox_form">
                  <option value="0">All</option>
                  <?php
                  if(mysqli_num_rows($result_1)>0){
                    while($row = mysqli_fetch_assoc($result_1))
                    {
                        $r_id = $row["role_id"];
                        $r_name = $row["role_name"];
                      
                        echo "<option value='".$r_id."'>$r_name</option>";
                    }
                  }
                    ?>
                  </select>
              </div>
              <div class="column-1">
                &nbsp;<input type='submit' class='btn btn-default' id='btnView' name='btnView' value='View'>
              </div>
              <input type='submit' class='btn btn-blue-fill float-right' id='btn_add_user' name='btn_add_user' value=' +  Add User'>
              
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
          echo "Email";
        echo "</th>";
        echo "<th>";
          echo "Password";
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
              echo $row["UserId"];
            echo "</td>";
            echo "<td>";
              echo $row["LoginEmail"];;
            echo "</td>";
            echo "<td>";
              echo $row["LoginPassword"];
            echo "</td>";
            echo "<td>";
              echo "<a href='ViewLogin.php?id=".$row['UserId']."'><img src='includes/Button/view_button_blue.png' height='25px' width='40px'></a>";
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