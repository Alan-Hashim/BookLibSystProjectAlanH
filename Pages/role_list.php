<?php
   
  echo "<div class='cont-card' style=''>";
  $sql_role = "SELECT * FROM roles";
  $result = mysqli_query($conn, $sql_role);
  echo "<form action='manage_roles.php' method='post'>".

    "<h1>User Categories List</h1>".
    "<br />";
    echo "<table class='tbl_default' style='overflow-y:auto; height:209.5px; display:block'>";
      echo "<tr style='position:sticky;'>";
        echo "<th>";
          echo "Code";
        echo "</th>";
        echo "<th>";
          echo "Roles";
        echo "</th>";
        echo "<th>";
          echo "Description";
        echo "</th>";
        echo "<th>";
          echo "Action";
        echo "</th>";
      echo "</tr>";

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result))
        {
          $id_r = $row["role_id"];
          echo "<tr>";
            echo "<td>";
              echo $row["role_id"];
            echo "</td>";
            echo "<td>";
              echo $row["role_name"];;
            echo "</td>";
            echo "<td>";
              echo $row["Descriptions"];;
            echo "</td>";
            echo "<td>";
              echo "<a class='links' href='RoleView.php?id=".$id_r."'><img src='includes/Button/view_button_blue.png' height='25px' width='40px'></a>";
            echo "</td>";
          echo "</tr>";
            
        }
        
      }else{
        echo "<tr><td colspan='5' style='text-align:center;'>No Data Found</td></tr>";
      }
      echo "</table>";
      echo "<input type='submit' value='Add Role' id='btn_add_role' style='margin-left:7px;' name='btn_add_role' class='btn btn-blue-fill'/>";
      echo "</form>";

      if(isset($_REQUEST["btn_add_role"])){
        header('Location:manage_roles');
      }
    echo "</div>";