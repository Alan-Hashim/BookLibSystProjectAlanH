<?php
include "Connect.php";
$page_title = 'Book List';
include ('includes/header.html');

$id = $_REQUEST["id"];

$sql = "SELECT * FROM login WHERE UserId = '$id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_assoc($result)){
    $user_id = $row["UserId"];
    $user_e = $row["LoginEmail"];
    $user_p = $row["LoginPassword"];
    $user_r = $row["a_role"];
    ?>
    
    <h1 style="text-align: center;">Profile</h1>
      <form method="POST" name="login" Action="ViewLogin.php?id=<?php echo $id ?>">
          <br />
          <div class="row">
              <div class="column-3">
                  Email :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="email" value="<?php echo $user_e ?>" id="email" />
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Password :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="password" value="<?php echo $user_p ?>" id="password" />
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Role :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="roles" value="<?php echo $user_r ?>" id="roles" readonly/>
              </div>
          </div>
          <br />
          <input type='submit' class='btn btn-red' value='DELETE' name='Delete' id='Delete'/>
          <input type="submit" class="btn btn-yellow float-right" value="Update" name="btnUpdate" id="btnUpdate">
          <br />
      </form>
    
    <?php
  }
}
else {
  echo "its empty";
}

if(isset($_REQUEST["btnUpdate"])){
  $id = $_REQUEST["id"];
  $email = $_REQUEST["email"];
  $pswd = $_REQUEST["password"];

  $sql = "UPDATE login SET LoginEmail = '$email', LoginPassword = '$pswd' Where UserId = $id";
         
  if(mysqli_query($conn, $sql)){
    //Refresh page

    $message[] = "Database Updated";

    $_SESSION["msg_status"] = 'g';
    
  }

  $_SESSION["message"] = $message;
  header('Location: '.$_SERVER['REQUEST_URI']);
}

if(isset($_REQUEST["Delete"])){
  $r_id = $_REQUEST["id"];

  //Delete from database
  $sql = "DELETE FROM login WHERE UserId = $r_id";
         
  if(mysqli_query($conn, $sql)){

    $message[] = "succesfully Deleted";
    $_SESSION["msg_status"] = 'g';

    header("Location:LoginList.php");
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
