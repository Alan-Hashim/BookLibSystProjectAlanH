<?php
   include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');
   echo "<header><link rel='stylesheet' href='includes/styles.css' type='text/css' media='screen' /></header>";
  
   $sqlGetRole = "Select * from roles WHERE role_id <> 1 And role_id <> 3";
   $result = mysqli_query($conn, $sqlGetRole);


   echo "<body style='background-image: url(includes/Background/bg1.jpg);background-size:contain;background-attachment: fixed;'>".
      "<div id='content'>".
         "<div class='cont-card' style='border:3px solid maroon;position:relative; bottom:-15%;'>".
               "<div class='row'>".
                  "<div class='column-5'>".
                     "<h1 style='text-align: right;'>REGISTER</h1>".
                     "<form Name='Register' action='Register.php' method='POST'>".
                        "<div class='row'>".
                              "<div class='column-2'>".
                                 "<img id='logo' src='includes/Logo/logo2.png' height='70px' width='92px' />".
                              "</div>".
                              "<div class='column-8' id='logo'>".
                                 "<h1>BOOK</h1>".
                                 "<h2>DATABASE</h2>".
                              "</div>".
                        "</div>".
                        "<br />".
                        "<div class='row'>".
                            "<div class='column-3'>".
                               "Email :".
                            "</div>".
                            "<div class='column-7'>".
                              "<input type='text' class='textbox_form' name='email' id='email'/>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='column-3'>".
                               "Role :".
                            "</div>".
                            "<div class='column-7'>".
                              "<select name='u_role' class='textbox_form'>".
                                 "<option value='none' selected>Please Select</option>";
                                 if(mysqli_num_rows($result)>0){
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                       $r_id = $row["role_id"];
                                       $r_name = $row["role_name"];
                                       echo "<option value='".$r_id."'>".$r_name."</option>";
                                    }
                              echo "</select>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='column-3'>".
                               "Password :".
                            "</div>".
                            "<div class='column-7'>".
                               "<input type='password' class='textbox_form' name='password' id='password'/>".
                            "</div>".
                        "</div>".
                        "<div class='row'>".
                            "<div class='column-3'>".
                               "Reenter Password :".
                            "</div>".
                            "<div class='column-7'>".
                               "<input type='password' class='textbox_form' name='password2' id='password2'/>".
                            "</div>".
                        "</div>".
                        "<br /><input type='submit' value='Register' class='btn btn-default float-right' name='Register' id='Register'/>".
                        "<br />".
                     "</form>".
                  "</div>".
                  "<div class='column-5'>".
                     "<br />".
                    "<img id='logo' class='float-right' src='includes/Logo/logo3.png' height='270px' width='300px'/>".
                "</div>".
               "</div>".
         "</div>".
      "</div>".
                  
   "</body>";

  
      if(isset($_POST["Register"]))
      {
         $errors = array();

         // Check for a first name:
         if (empty($_POST['email'])) {
            $errors[] = 'You forgot to enter your email.';
         } else {
            $email = trim($_POST["email"]);
         }
         
         // Check for a first name:
         if ($_POST['u_role'] == "none") {
            $errors[] = 'You forgot to select your role.';
         } else {
            $a_role = $_REQUEST["u_role"];
         }
         
         // Check for a first name:
         if (empty($_POST['password'])) {
            $errors[] = 'You forgot to enter your first password.';
         } else {
            $password = $_POST["password"];
         }
         
         // Check for a first name:
         if (empty($_POST['password2'])) {
            $errors[] = 'You forgot to enter your second password.';
         } else {
            $password2 = $_POST["password2"];
         }
         if(empty($errors)){

            if($password == $password2){
            
            $sql_if_exist = "SELECT * FROM login WHERE LoginEmail = '$email'";
            $result = mysqli_query($conn,$sql_if_exist);

               if(mysqli_num_rows($result)>0){
                  $errors[] ="Registration failed. Email aleady exist. Please enter a new one";
                  $_SESSION["msg_status"] = 'r';
               }
               else{

                  $sql = "INSERT INTO login(LoginEmail, LoginPassword, a_role) VALUES('$email','$password',$a_role)";
                  
                  if(mysqli_query($conn, $sql)){
                     $_SESSION["msg_status"] = 'g';
                     $errors[] = "Successfuly Registered";
                  }
                  else
                  {
                     $_SESSION["msg_status"] = 'r';
                     $errors[] = " <b>Registration Failed</b> : ".mysqli_error($conn);
                  }
               }

            }else{
               $errors[] = "Password entered aren't match. Error";
               $_SESSION["msg_status"] = 'r';
            }
         }else{
            $_SESSION["msg_status"] = 'r';
         }
         $_SESSION["message"] = $errors;
         header('Location: '.$_SERVER['REQUEST_URI']);
      }
   }
?>