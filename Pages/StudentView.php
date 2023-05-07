<?php
include "Connect.php";
$page_title = 'Book List';
include ('includes/header.html');

$id = $_REQUEST["id"];

$result = mysqli_query($conn, $sql);
$sql = "SELECT * FROM student WHERE student_id = '$id'";

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_assoc($result)){
        $s_name = $row["s_name"];
        $s_phone = $row["s_phone"];
        $s_sem = $row["s_semester"];

        $l_id = $row["login_id"];


$sql2 = "SELECT * FROM login WHERE UserId = '$l_id'";
$result2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($result2)>0){
  while($row = mysqli_fetch_assoc($result2)){
    $user_id = $row["UserId"];
    $user_e = $row["LoginEmail"];
    $user_p = $row["LoginPassword"];
    $user_r = $row["a_role"];
    
      }
    }

    if(isset($_REQUEST["Delete"])){
      $r_id = $_REQUEST["id"];
    
      //Delete from database
      $sql = "DELETE FROM student WHERE student_id = $r_id";
             
      if(mysqli_query($conn, $sql)){
    
        $message[] = "succesfully Deleted Student Record";
        $_SESSION["msg_status"] = 'g';
    
        $sql2 = "DELETE FROM login WHERE UserId = $l_id";
    
        if(mysqli_query($conn, $sql2)){
          $message[] = "succesfully Deleted Login Record";
        $_SESSION["msg_status"] = 'g';
        }
    
        header("Location:StudentList.php");
      }
      else
      {
        //echo "Error ".mysqli_error($conn);
        $message[] = "Delete failed. Error : ".mysqli_error($conn);
        $_SESSION["msg_status"] = 'r';
      }
    
    
      $_SESSION["message"] = $message;
    
    }

    
    if(isset($_REQUEST["btnUpdate"])){
      
      
      $id = $_REQUEST["id"];
      $name = $_REQUEST["name"];
      $phone = $_REQUEST["phone"];
      $semester = $_REQUEST["semester"];
      $email = $_REQUEST["email"];
      

      $sql2 = "UPDATE student SET s_name = '$name', s_phone = '$phone', s_semester = $semester, s_email = '$email' Where student_id = $id";

      if(mysqli_query($conn, $sql2)){
        //Refresh page
        $message[] = "Student data Updated";

        $_SESSION["msg_status"] = 'g';
        
      }else{
        $message[] = "Delete failed. Error : ".mysqli_error($conn);
        $_SESSION["msg_status"] = 'r';
      }

      $id = $_REQUEST["id"];
      $email = $_REQUEST["email"];
      $pswd = $_REQUEST["password"];

      $sql = "UPDATE login SET LoginEmail = '$email', LoginPassword = '$pswd' Where UserId = $l_id";
            
      if(mysqli_query($conn, $sql)){
        //Refresh page
        $message[] = "Login data Updated";

        $_SESSION["msg_status"] = 'g';
        
      }

      $_SESSION["message"] = $message;
      header('Location: '.$_SERVER['REQUEST_URI']);
    }
    ?>
    
    <h1 style="text-align: center;">Profile</h1>
      <form method="POST" name="login" Action="StudentView.php?id=<?php echo $id ?>">
      <input type="text" class="textbox_form hidden" name="log_id" value="<?php echo $l_id ?>" id="log_id" />
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
          <br />
          <div class="row">
              <div class="column-3">
                  Name :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="name" value="<?php echo $s_name ?>" id="name" required/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Phone :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="phone" value="<?php echo $s_phone ?>" id="phone" required/>
              </div>
          </div>
          <div class="row">
              <div class="column-3">
                  Semester :
              </div>
              <div class="column-7">
                  <input type="text" class="textbox_form" name="semester" value="<?php echo $s_sem ?>" id="semester" required/>
              </div>
          </div>
          <br />
          <input type='submit' class='btn btn-red' value='DELETE' name='Delete' id='Delete'/>
          <input type="submit" class="btn btn-yellow float-right" value="Update" name="btnUpdate" id="btnUpdate"/>
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
