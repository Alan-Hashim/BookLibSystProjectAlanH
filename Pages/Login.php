<?php
  include 'Connect.php';
  if(isset($_POST["Login"])){
      $Email = $_POST["email"];
      $Password = $_POST["password"];
      $sql = "SELECT * FROM login WHERE LoginEmail = '$Email' && LoginPassword = '$Password'";

      $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0)
        {
            session_start();
            while($row = mysqli_fetch_assoc($result)) 
            {
              $_SESSION["LoggersID"] = $row["UserId"];
               $_SESSION["message"] = null;
               $_SESSION["msg_status"] = null;
               $_SESSION["role_id"] = $row["a_role"];
            }

            header("Location:index.php");
            
            exit();
        }
        else
        {
            echo "<header><link rel='stylesheet' href='includes/styles.css' type='text/css' media='screen' /></header>";
  
            echo "<body style='background-image: url(includes/Background/bg1.jpg);background-size:contain;background-attachment: fixed;'>".
                "<div id='content'>".
                  "<div class='cont-card warn-cont' style='border:3px solid maroon;'>".
                        "<div class='row' style='border-bottom:1px solid maroon;'>".
                            "<div class='column-5'>".
                                  "<div class='row'>".
                                        "<div class='column-2'>".
                                          "<img id='logo' src='includes/Logo/logo2.png' height='70px' width='92px' />".
                                        "</div>".
                                        "<div class='column-8' id='logo'>".
                                          "<h1>BOOK</h1>".
                                          "<h2>DATABASE</h2>".
                                        "</div>".
                                  "</div>".
                            "</div>".
                            "<div class='column-5'>".
                          "</div>".
                        "</div>".
                        "<br />".
                        "<br />".
                        "<h1 style='text-align: center;'>WE'RE SORRY FOR THE INCONVENIENCE</h1>".
                        "<br />".
                        "<h3 style='text-align: center;'>Seems like you have entered the wrong Email or Password. Please try again.</h3>".
                        "<br />".
                        "<br />".
                        "<a class='links' href='Login.html'>Back</a>".
                  "</div>".
                "</div>".     
            "</body>";
            
        }
          mysqli_close($conn);
  }
?>