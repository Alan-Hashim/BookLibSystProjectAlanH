<?php

$page_title = 'Welcome to this Site!';
include ('includes/header.html');

include ('connect.php');

$userid = $_SESSION["LoggersID"];

$sql = "SELECT LoginEmail, LoginPassword, a_role FROM login WHERE UserId = $userid";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        $email = $row["LoginEmail"];
        $password = $row["LoginPassword"];
        $roleLoggers = $row["a_role"];
    }
}

if($roleLoggers == 3){
    $visibleStudent = "visible";
    $sqlStudent = "SELECT * FROM student WHERE login_id = '$userid'";

    $resultStudent = mysqli_query($conn, $sqlStudent);
    if(mysqli_num_rows($resultStudent)>0){
      while($row = mysqli_fetch_assoc($resultStudent)){
        $s_name = $row["s_name"];
        $s_phone = $row["s_phone"];
        $s_sem = $row["s_semester"];

        $l_id = $row["login_id"];
      }
    }
}else{
    $visibleStudent = "hidden";
}

$sql2 = "SELECT count(BookID) as booktotal FROM books WHERE UserId = $userid";

$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2)>0){
    while($row = mysqli_fetch_assoc($result2)){
        $totalbook = $row["booktotal"];
    }
}

$sql3 = "SELECT count(isViewed) as bookisviewed FROM books WHERE UserId = $userid AND isViewed = 0";

$result3 = mysqli_query($conn, $sql3);

if(mysqli_num_rows($result3)>0){
    while($row = mysqli_fetch_assoc($result3)){
        $totalbookviewed = $row["bookisviewed"];
        
    }
}
?>
<?php if($totalbookviewed>0){ ?>
    <h5 class="badge">
        <?php echo $totalbookviewed?> New Added Book !
    </h5>
<?php } 

    $isreadonly = "Readonly";
    $visibility_pswd_2 = "hidden";
    $visibility_pswd_1 = "visible";
    $visibility_pswd_2 = "hidden";
    $restrict = "restricted";

    if(isset($_REQUEST["btnVisPswd"])){
        $isreadonly = "";
        $visibility_pswd_2 = "visible";
        $visibility_pswd_1 = "hidden";
        $visibility_pswd_2 = "visible";
        $restrict = "";
    }

    if(isset($_REQUEST["btnCancel"])){
        $isreadonly = "Readonly";
        $visibility_pswd_2 = "hidden";
        $visibility_pswd_1 = "visible";
        $visibility_pswd_2 = "hidden";
        $restrict = "restricted";
    }
    
    if(isset($_REQUEST["btnUpdate"])){
      
      
        $userid = $_SESSION["LoggersID"];
    
        $name = $_REQUEST["name"];
        $phone = $_REQUEST["phone"];
        $semester = $_REQUEST["semester"];
        $email = $_REQUEST["email"];
    
        $sql2 = "UPDATE student SET s_name = '$name', s_phone = '$phone', s_semester = $semester, s_email = '$email' Where login_id = $userid";
    
        if(mysqli_query($conn, $sql2)){
          //Refresh page
          $message[] = "Student data Updated";
    
          $_SESSION["msg_status"] = 'g';
          
        }else{
          $message[] = "Delete failed. Error : ".mysqli_error($conn);
          $_SESSION["msg_status"] = 'r';
        }
    
        $_SESSION["message"] = $message;
        header('Location: '.$_SERVER['REQUEST_URI']);
      }

    if(isset($_REQUEST["btnChangePassword"])){

        if (empty($_POST['email'])) {
            $message[] = 'You forgot to enter your email.';
         } else {
            $email_new = $_REQUEST["email"];
         }

         if (empty($_POST['password'])) {
            $message[] = 'You forgot to enter your first password.';
         } else {
            $pswd1_new = $_REQUEST["password"];
         }
         
         // Check for a first name:
         if (empty($_POST['password2'])) {
            $message[] = 'You forgot to enter your second password.';
         } else {
            $pswd2_new = $_REQUEST["password2"];
         }

         if(empty($message)){

            if($pswd1_new == $pswd2_new){
                $sqlUpdate = "UPDATE login SET LoginEmail = '$email_new', LoginPassword = '$pswd1_new' WHERE UserId = $userid";
                if(mysqli_query($conn, $sqlUpdate)){
                    $message[] = "Successfuly Updated User Info";
                    $_SESSION["msg_status"] = 'g';
                }
                else{
                    //echo "Error ".mysqli_error($conn);
                    $message[] = "Error ".mysqli_error($conn);
                    $_SESSION["msg_status"] = 'r';
                }
            }
            else{
                //echo "Password entered are not match. Please re-enter";
                $message[] = "Password entered are not match. Please re-enter";
                $_SESSION["msg_status"] = 'r';
            }
        }else
        {
            $_SESSION["msg_status"] = 'r';
        }
        $_SESSION["message"] = $message;
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    
?>
<span class='icon_1'></span><span class='icon_2'></span>
    <br />
    <br />
    <h1>Welcome</h1>

    <div>
        <p> Current Books Saved : <?php echo $totalbook?></p>
        <p> Loggers role : <?php echo $role_name?></p>
    </div>
    <br />
   <div class="cont-card" style="margin-top:10px;">
        <form Name='Register' action='index.php' method='POST'>
        <h1 style="border-bottom:1px solid black;">Profile</h1>
        <br />
        <div class="row">
            <div class="column-2">
                Email :
            </div>
            <div class="column-8">
                <input type="text" class="textbox_form <?php echo $restrict?>" name="email" id="email" value="<?php echo $email ?>" <?php echo $isreadonly ?> required/>
            </div>
        </div>
        <div class="row">
            <div class="column-2">
                Password :
            </div>
            <div class="column-8">
                <input type="password" class="textbox_form  <?php echo $restrict?>" name="password" value="" <?php echo $isreadonly ?> id="password">
            </div>
        </div>
        <div class="row <?php echo $visibility_pswd_2?>">
            <div class="column-2">
                Reenter Password :
            </div>
            <div class="column-8">
                <input type="password" class="textbox_form" name="password2" id="password2"/>
            </div>
        </div>
        <div class="row <?php echo $visibility_pswd_1?>">
            <br />
            <div class="column-10">
                <input type="submit" value="Change Password" id="btnVisPswd" style="margin-left:7px;" name="btnVisPswd" class="btn btn-blue-fill float-left"/>
            </div>
        </div>
        <div class="row <?php echo $visibility_pswd_2?>">
            <br />
            <div class="column-10">
                <input type="submit" value="Change Password" id="btnChangePassword" style="margin-left:7px;" name="btnChangePassword" class="btn btn-green-fill float-right"/>
                <input type="submit" value="Cancel" id="btnCancel" name="btnCancel" class="btn btn-yellow float-right"/>
            </div>
        </div>
        </form>
   </div>
   <div class="cont-card <?php echo $visibleStudent ?>" style="margin-top:10px;">
   <h1 style="text-align: center;">Student Details</h1>
      <form method="POST" name="login" Action="index.php">
      <input type="text" class="textbox_form hidden" name="log_id" value="<?php echo $l_id ?>" id="log_id" />
          <br />
          <div class="row">
              <div class="column-2">
                  Name :
              </div>
              <div class="column-8">
                  <input type="text" class="textbox_form" name="name" value="<?php echo $s_name ?>" id="name" required/>
              </div>
          </div>
          <div class="row">
              <div class="column-2">
                  Phone :
              </div>
              <div class="column-8">
                  <input type="text" class="textbox_form" name="phone" value="<?php echo $s_phone ?>" id="phone" required/>
              </div>
          </div>
          <div class="row">
              <div class="column-2">
                  Semester :
              </div>
              <div class="column-8">
                  <input type="text" class="textbox_form" name="semester" value="<?php echo $s_sem ?>" id="semester" required/>
              </div>
          </div>
          <br />
          <input type="submit" class="btn btn-yellow float-right" value="Update" name="btnUpdate" id="btnUpdate"/>
          <br /><br />
      </form>
   </div>
<?php




?>

<?php
$role = $_SESSION["role_id"];
if($role < 2){
   echo "<h1>Manage Database</h1>";
    include ('role_list.php');
}



include ('includes/footer.html');
?>