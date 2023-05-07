<?php
$page_title = 'Roles!';
include ('includes/header.html');

include ('connect.php');
?>
   <div class="cont-card" style="margin-top:10px">
   
      <form action="manage_roles.php" method="POST">
         <h1>
            Roles
         </h1>
         <br />
            <div class="row">
                <div class="column-2">
                    <p>Role Name :</p>
                </div>
                <div class="column-8">
                  <input type="text" class="textbox_form" name="roleName" id="roleName"/>
                </div>
            </div>
            <div class="row">
                <div class="column-2">
                    <p>Description :</p>
                </div>
                <div class="column-8">
                  <textarea type="text" style="resize:none;" class="textbox_form" name="roleDesc" id="roleDesc"></textarea>
                </div>
            </div>
            <br />
            <input type="reset" class="btn" value="Clear" name="Clear" id="Clear"/>
            <input type="submit" class="btn btn-green-fill float-right" value="Add Role" name="btn_reg_role" id="btn_reg_role"/>
      </form>
   </div>

   <?php
      if(isset($_REQUEST["btn_role_list"])){
         header('Location:role_list.php');
      }

      if(isset($_POST["btn_reg_role"]))
      {

        $message = array(); //for array message;

        $r_name = $_POST["roleName"];
        $r_desc = $_POST["roleDesc"];
        
        
        $sql = "INSERT INTO roles(role_name, Descriptions) 
        VALUES('$r_name','$r_desc')";
    
        if(mysqli_query($conn, $sql)){
        $message[] = "Data Added";
        $_SESSION["msg_status"] = 'g';
        }
        else
        {
        $message[] = "Error : ".mysqli_error($conn);
        $_SESSION["msg_status"] = 'r';
        //echo "Error ".mysqli_error($conn);
        }

         //Add message array into Session
         $_SESSION["message"] = $message;
         
      //Refresh page
      header('Location: '.$_SERVER['REQUEST_URI']);
         
      }

      
?>