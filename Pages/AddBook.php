<?php
    
   $page_title = 'Add New Book';
   
   include ('includes/header.html');

   include "Connect.php";

   echo 
   "<h1>Add New Book</h1>".
   "<div class='cont-card' style='margin-top:10px;'>".
      "<form Name='Register' action='AddBook.php' method='POST'  enctype='multipart/form-data'>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Select Book Cover :</p>".
                "</div>".
                "<div class='column-8'>".
                  "<input type='file' name='BookCover' id='BookCover'>".
                "</div>".
            "</div>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Book Title :</p>".
                "</div>".
                "<div class='column-8'>".
                "<input type='text' class='textbox_form' name='b_title' id='b_title'/>".
                "</div>".
            "</div>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Author :</p>".
                "</div>".
                "<div class='column-8'>".
                     "<input type='text' class='textbox_form' name='b_author' id='b_author'/>".
                "</div>".
            "</div>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Remark :</p>".
                "</div>".
                "<div class='column-8'>".
                     "<input type='text' class='textbox_form' name='b_remark' id='b_remark'/>".
                "</div>".
            "</div>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>ISBN Code :</p>".
                "</div>".
                "<div class='column-8'>".
                     "<input type='text' class='textbox_form' name='b_code' id='b_code'/>".
                "</div>".
            "</div>".
            "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Publication :</p>".
                "</div>".
                "<div class='column-8'>".
                     "<input type='text' class='textbox_form' name='b_pub' id='b_pub'/>".
                "</div>".
            "</div>".
            "<br />".
            "<br /><input type='reset' class='btn' value='Clear' name='Clear' id='Clear'/>".
            "<input type='submit' class='btn btn-default float-right' value='Register' name='Register' id='Register'/>".
      "</form>"
   ."</div>";

      if(isset($_POST["Register"]))
      {

        $message = array(); //for array message;
        

        $userid = $_SESSION["LoggersID"];
        //rename file for each user

        
        if(!empty(basename($_FILES["BookCover"]["name"]))){ 
        $filename = $_FILES["BookCover"]["name"];
        $ext = explode(".",$filename);
        $extension = end($ext);

        $name = pathinfo($filename, PATHINFO_FILENAME); //break it to get dirname, basename, extension, filename
        $newfilename = $name."_UserID_".$userid.".".$extension;

         $target_dir = "../Images/"; //Location to keep
         $target_file = $target_dir.basename($newfilename);

         $uploadOk = 1;
         $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //get the file extension.

         //to check if image is actual  or fake
         $check = getimagesize($_FILES["BookCover"]["tmp_name"]);
         if($check !== false){
            echo "File is an image - ".$check["mime"].".";
            $uploadOk = 1;
         }
         else{
            $message[] = "There as a problem. File not Uploaded";
            $_SESSION["msg_status"] = 'r';

            //echo "There as a problem. File not Uploaded";
         }

         // if file already exist
         if(file_exists($target_file)){
            //echo "it's already exist";
            $exists = true;
            $message[] = "it's already exist";
            $_SESSION["msg_status"] = 'r';
            $uploadOk = 0;
         }

         // check file size
         if($_FILES["BookCover"]["size"]>900000){
            //echo "File is too large";

            $message[] = "File is too large";
            $_SESSION["msg_status"] = 'r';

            $uploadOk = 0;
         }

         // Allow certain file format
         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
            //echo "Sorry only JPG, JPEG, PNG and GIF format are accepted";
            $message[] = "Sorry only JPG, JPEG, PNG and GIF format are accepted";
            $_SESSION["msg_status"] = 'r';
            $uploadOk = 0;
         }

         //Check if $uploadOk is set to 0 by an error
         if($uploadOk == 0){
            //echo "Sorry your file as not uploaded";
            $message[] = "Sorry your file is not uploaded";
            $_SESSION["msg_status"] = 'r';
            $b_path = '';
         }
         else{
             
           // try to upload move_uploaded_file($_FILES["BookCover"]["tmp_name"],$target_file) 
           if(move_uploaded_file($_FILES["BookCover"]["tmp_name"],$target_file)){

               //echo "The file " . htmlspecialchars(basename($_FILES["BookCover"]["name"])) . "Has Been Uploaded";
             $message[] = "The file " . htmlspecialchars(basename($_FILES["BookCover"]["name"])) . " Has Been Uploaded";
              
             $b_path = $target_file;
           }
            else{
            $message[] = "There was an error";
            $_SESSION["msg_status"] = 'r';
               
           }
         }
         
        }

        

            if (empty($_POST['b_title'])) {
                $message[] = 'You forgot to enter Title.';
                $saveOK = 0;
             } else {
                $b_title = $_POST["b_title"];
                $saveOK = 1;
             }

             if (empty($_POST['b_author'])) {
                $message[] = 'You forgot to enter Author.';
                $saveOK = 0;
             } else {
                $b_author = $_POST["b_author"];
                $saveOK = 1;
             }

             if (empty($_POST['b_remark'])) {
                $message[] = 'You forgot to enter Remark.';
                $saveOK = 0;
             } else {
                $b_remark = $_POST["b_remark"];
                $saveOK = 1;
             }

             if (empty($_POST['b_code'])) {
                $message[] = 'You forgot to enter ISBN COde.';
                $saveOK = 0;
             } else {
                $b_code = $_POST["b_code"];
                $saveOK = 1;
             }

             if (empty($_POST['b_pub'])) {
                $message[] = 'You forgot to enter Publication.';
                $saveOK = 0;
             } else {
                $b_pub = $_POST["b_pub"];
                $saveOK = 1;
             }
            
             if($check !== false && $exists == false && $saveOK == 1){

            $b_user = $_SESSION["LoggersID"];
            
            $sql = "INSERT INTO books(BookName, BookAuthor, B_Date, B_Remark, B_ISBNCode, B_Publication, B_Path, UserID, isViewed, status) 
            VALUES('$b_title','$b_author',NOW(),'$b_remark','$b_code','$b_pub','$b_path', $b_user, 0, 'Available')";
        
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
            
        }else{
            
            $message[] = "Sorry your file as not uploaded And Data not saved to the DATABASE";
            $_SESSION["msg_status"] = 'y';
            $_SESSION["message"] = $message;
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
         //Add message array into Session
         $_SESSION["message"] = $message;
         
      //Refresh page
      header('Location: '.$_SERVER['REQUEST_URI']);
         
      }
      mysqli_close($conn);
    


  
?>