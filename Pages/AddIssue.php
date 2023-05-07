<?php
$page_title = 'Roles!';
include ('includes/header.html');

include ('connect.php');
$b_id = $_REQUEST["id"];
$s_id = $_SESSION["LoggersID"];

//get book name
        $sql = "SELECT * FROM books WHERE BookID = $b_id";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)){
             $b_name = $row["BookName"];
          }
        }
//get student name
        $sql1 = "SELECT * FROM student WHERE login_id = $s_id";

        $result1 = mysqli_query($conn, $sql1);

        if(mysqli_num_rows($result1)>0){
          while($row = mysqli_fetch_assoc($result1)){
             $s_name = $row["s_name"];
             $student_id = $row["student_id"];
          }
        }



        if(isset($_POST["btn_issue_book"]))
      {
         /*
         STEP 1 : Mark book status as RESERVED
         STEP 2 : Add new ISSUIING BOOK 
         */

        $message = array(); //for array message;

        $b_id = $_REQUEST["id"];
        $s_id = $student_id;
        
        
        $sql = "INSERT INTO issuing_book(s_id, b_id, date_issue,status) 
        VALUES($s_id,$b_id,NOW(),3)";
    
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

        $sql1 = "UPDATE books SET status = 'Reserved' WHERE BookID = $b_id";
    
        if(mysqli_query($conn, $sql1)){
        $message[] = "Book reserved";
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
   <div class="cont-card" style="margin-top:10px">
   
      <form action="AddIssue.php?id=<?php echo $b_id ?>" method="POST">
         <h1>
            Roles
         </h1>
         <br />
            <div class="row">
                <div class="column-2">
                    <p>Book Title :</p>
                </div>
                <div class="column-8">
                  <input type="text" class="textbox_form" name="b_name" value="<?php echo $b_name?>" id="b_name" readonly/>
                </div>
            </div>
            <div class="row">
                <div class="column-2">
                    <p>Student Name :</p>
                </div>
                <div class="column-8">
                  <input type="text" class="textbox_form" name="s_name" value="<?php echo $s_name?>" id="s_name" readonly/>
                </div>
            </div>
            <br />
            <input type="reset" class="btn" value="Clear" name="Clear" id="Clear"/>
            <input type="submit" class="btn btn-green-fill float-right" value="Reserve" name="btn_issue_book" id="btn_issue_book"/>
      </form>
   </div>
   <?php
      

      
?>