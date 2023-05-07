<?php
   include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');
   echo "<header><link rel='stylesheet' href='includes/styles.css' type='text/css' media='screen' /></header>";

   echo "<body style='background-image: url(includes/Background/bg1.jpg);background-size:contain;background-attachment: fixed;'>".
      "<div id='content'>".
         "<div class='cont-card' style='border:3px solid maroon;position:relative; bottom:-15%;'>".
               "<div class='row'>".
                  "<div class='column-10'>".
                     "<h1 style='text-align: right;'>REGISTER STUDENT</h1>".
                     "<form action='RegisterStudent.php' method='POST'>".
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
                              "<input type='text' class='textbox_form' value='Student' name='u_role' id='u_role' readonly/>".
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
            
            $a_role = 3;

            $sql_if_exist = "SELECT * FROM login WHERE LoginEmail = '$email'";
            $result = mysqli_query($conn,$sql_if_exist);

            if(mysqli_num_rows($result)>0){
               $_SESSION["msg_status"] = 'r';
               $errors[] = "Registration failed. Email aleady exist. Please enter a new one";
            }
            else{

               $sql = "INSERT INTO login(LoginEmail, LoginPassword, a_role) VALUES('$email','$password',$a_role)";
               
               if(mysqli_query($conn, $sql)){
                  echo "Successfuly Registered";
                  $_SESSION["msg_status"] = 'g';
                  $errors[] = "Successfuly Registered";
               }
               else
               {
                  
                  $_SESSION["msg_status"] = 'r';
                  $errors[] = " <b>Registration Failed</b> : ".mysqli_error($conn);
               }

               $sqlGetRole = "Select UserId from login WHERE LoginEmail ='$email'";
            $result = mysqli_query($conn, $sqlGetRole);

            if(mysqli_num_rows($result)>0){
               while($row = mysqli_fetch_assoc($result))
               {
                  $u_id = $row["UserId"];
               }
            }
            //////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////

            $sql2 = "INSERT INTO student(s_email,login_id) VALUES('$email',$u_id)";

            if(mysqli_query($conn, $sql2)){
               echo "Successfuly Registered";
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
            echo 
            $_SESSION["msg_status"] = 'r';
            $errors[] = "Password entered aren't match. Error";
         }

      }else{
         $_SESSION["msg_status"] = 'r';
      }

      $_SESSION["message"] = $errors;
      header('Location: '.$_SERVER['REQUEST_URI']);
      }
   
?>