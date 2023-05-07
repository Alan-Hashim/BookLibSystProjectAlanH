<?php

//enable Output Buffer
if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
  ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^
    PHP_OUTPUT_HANDLER_REMOVABLE);
} else {
  ob_start(null, 0, false);
}

$arr_category = array(
  '000'=>"Computer Information and General Reference",
  '100'=>"Philosophy and Psychology",
  '200'=>"Religion",
  '300'=>"Social Knowledge",
  '400'=>"Language",
  '500'=>"Science and Mathematics",
  '600'=>"Technology",
  '700'=>"Art and Recreation",
  '800'=>"Literature",
  '900'=>"History and Geography");

include "Connect.php";
$page_title = 'View Book';
include ('includes/header.html');
$id = $_REQUEST["id"];
$sql = "SELECT * FROM books WHERE BookID = '$id'";

$result = mysqli_query($conn, $sql);
$reserved = "";
if(mysqli_num_rows($result)>0){
   while($row = mysqli_fetch_assoc($result)){

    $id = $row["BookID"];
    $title = $row["BookName"];
    $auth = $row["BookAuthor"];
    $date = $row["B_Date"];
    $rem = $row["B_Remark"];
    $code = $row["B_ISBNCode"];
    $pub = $row["B_Publication"];
    $bookpath = $row["B_Path"];
    $loc_id = $row["loc_id"];

    if($loc_id != null){
      
      $sqloc = "SELECT * FROM location WHERE loc_id = '$loc_id'";

      $resultloc = mysqli_query($conn, $sqloc);
      if(mysqli_num_rows($resultloc)>0){
        while($rowloc = mysqli_fetch_assoc($resultloc)){
          $level = $rowloc["level_no"];
          $shelve = $rowloc["shelve_no"];
          $category = $rowloc["category_no"];
          $categoryname = $rowloc["category"];
          }
        }
      }

    if($bookpath == ''){
      $path_local_if_none = '../Images/no_image.jpg';
    }
    else{
      $path_local_if_none = $bookpath;
    }

    $role = $_SESSION["role_id"];
  if($role <= 2){
    $hidden_class = "visible";
    $read_only = "";
    $hidden_class_std = "hidden";
    $hidden_loc = "visible";
  }else{
    $hidden_class = "hidden";
    $read_only = "Readonly";
    //$hidden_class_std ="visible";

    $hidden_loc="hidden";
    

      $status_book = $row["status"];
    if($status_book == "Reserved"){
      $reserved = "Book is RESERVED";
      $hidden_class_std = "hidden";
    }
    else{
      $reserved = "Book is AVAILABLE";
      $hidden_class_std = "visible";
    }
  }

    echo 
    "<div class='cont-card' style='margin-top:10px;'>".
      "<form Name='Register' action='BookView.php?id=$id' method='POST'  enctype='multipart/form-data'>".
          "<div class='text-center bg-white'>".
            "Current Book Cover <br />".
            "<img class='imgs' src='$path_local_if_none' height='320px' width='230px'/>".
          "</div>".
              "<div class='row $hidden_class'>".
                  "<div class='column-2'>".
                      "<p>Update Book Cover</p>".
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
                    "<input type='text' class='textbox_form' name='b_title' id='b_title' value='$title' $read_only />".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Author :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_author' id='b_author' value='$auth' $read_only/>".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Date :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_date' id='b_date' value='$date' $read_only readonly/>".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Remark :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_remark' id='b_remark' value='$rem' $read_only />".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>ISBN Code :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_code' id='b_code' value='$code' $read_only />".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Publication :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_pub' id='b_pub' value='$pub' $read_only />".
                "</div>".
              "</div>".
              "<div class='row'>".
                "<div class='column-2'>".
                    "<p>Location :</p>".
                "</div>".
                "<div class='column-8'>".
                    "<input type='text' class='textbox_form' name='b_loc' id='b_loc' value='$loc_id"; if($loc_id != null) echo "| LEVEL $level - Shelve $shelve - Category $category - $categoryname"; echo "' readonly/>".
                "</div>".
              "</div>".
            "<br />".
            "<fieldset class='$hidden_loc' style='border:3px solid black; padding:3% 0% 3% 0%;'>".
                    "<legend>Book Location</legend>".
                    "<div class='row' style='margin-left:10%;'>".
                        "<div class='column-1'>".
                            "<p>Level</p>".
                        "</div>".
                        "<div class='column-3'>".
                            "<select name='level_no' class='textbox_form'>".
                                "<option value='0'>Please select Level</option>".
                                "<option value='1'>Level 1</option>".
                                "<option value='2'>Level 2</option>".
                                "<option value='3'>Level 3</option>".
                            "</select>".
                        "</div>".
                        "<div class='column-1'>".
                            "<p>Shelve</p>".
                        "</div>".
                        "<div class='column-3'>".
                            "<select name='shelve_no' class='textbox_form'>".
                                "<option value='0'>Please select Shelve</option>";
                                for($i = 1; $i<9; $i++){
                                    echo "<option value='".$i."'>Shelve number ".$i."</option>";
                                }
                            echo "</select>".
                        "</div>".
                      "</div>".
                      "<div class='row' style='margin-left:10%;'>".
                        "<div class='column-1'>".
                            "<p>Category</p>".
                        "</div>".
                        "<div class='column-7'>".
                            "<select name='category_no' class='textbox_form'>".
                                "<option value='0'>Please select Category</option>";
                                foreach($arr_category as $cat=>$cat_val){
                                    echo "<option value='".$cat."'>".$cat_val."</option>";
                                }
                            echo "</select>".
                        "</div>".
                      "</div>".
                      "<div class='row' style='margin-left:10%;'>".
                          "<div class='column-8'>".
                            "<input type='submit' class='btn btn-green-fill float-right $hidden_class' value='Update Location' name='btnUpdtLoc' id='btnUpdtLoc'/>".
                          "</div>".
                      "</div>".
                    "<br />".
                    
                "</fieldset>".
            "<br />".
            "<h3>".$reserved."</h3>".
            "<input type='submit' class='btn btn-green-fill $hidden_class_std' value='Issue This Book' name='btnIssue' id='btnIssue'/>".
            "<input type='submit' class='btn btn-yellow float-right $hidden_class' value='UPDATE' name='Update' id='Update'/>".
            "<input type='submit' class='btn btn-red $hidden_class' value='DELETE' name='Delete' id='Delete'/>".
            
            "<input type='hidden' class='textbox_form' name='bookpath' id='bookpath' value='$bookpath' />".
      "</form>"
   ."</div>".
   "<br /><br /><br />";

  }
  if(isset($_REQUEST["btnUpdtLoc"])){

    $updateOK = 1;
    $message = array();

    $l_lvl = $_POST["level_no"];
    $l_slv = $_POST["shelve_no"];
    $l_cat = $_POST["category_no"];

    if($l_lvl == 0){
      $updateOK = 0;
      $message[] = "please select LEVEL NUMBER";
       $_SESSION["msg_status"] = 'y';
    }

    if($l_slv == 0){
      $updateOK = 0;
      $message[] = "please select SHELVE NUMBER";
       $_SESSION["msg_status"] = 'y';
    }

    if($l_cat == 0){
      $updateOK = 0;
      $message[] = "please select CATEGORY";
      $_SESSION["msg_status"] = 'y';
    }

    if($updateOK = 1){

        $loc_code = $l_lvl."-".$l_slv."-".$l_cat;

        echo $loc_code;

        //EDIT BOOKS' Location
        $sql = "UPDATE books SET loc_id = '$loc_code' Where BookID = $id";
            
        if(mysqli_query($conn, $sql)){
          //Refresh page
      
          $message[] = "Book Location Updated";
      
          $_SESSION["msg_status"] = 'g';
          
        }else{

          $message[] = "Book Location was not Updated";
      
          $_SESSION["msg_status"] = 'y';

        }

    }
        
  
    $_SESSION["message"] = $message;
    header('Location: '.$_SERVER['REQUEST_URI']);

  }


  /////////////////////////////////////////////////////////////////////////



  if(isset($_REQUEST["btnIssue"])){
    header('Location:AddIssue.php?id='.$id.'');
  }
 
  // To Update
  if(isset($_REQUEST["Update"])){
    $message = array();
    //Update
    if(!empty(basename($_FILES["BookCover"]["name"]))){

        $userid = $_SESSION["LoggersID"];
        //rename file for each user
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
          //echo "File is an image - ".$check["mime"].".";
          $uploadOk = 1;
        }
        else{
          //echo "There as a problem. File not Uploaded";
          $message[] = "This is not Image File Type. Please Reupload";
          $_SESSION["msg_status"] = 'r';
        }

        // if file already exist
        if(file_exists($target_file)){
         // echo "it's already exist";
         $exists = true;
          $message[] = "it's already exist";
          $_SESSION["msg_status"] = 'r';
          $uploadOk = 0;
        }

        // check file size
        if($_FILES["BookCover"]["size"]>500000){
          // echo "File is too large";
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
          $message[] = "Sorry your file as not uploaded";
          $_SESSION["msg_status"] = 'r';
          $b_path = $_POST["bookpath"]; // Use current Pic Path
        }
        else{
          // try to upload move_uploaded_file($_FILES["BookCover"]["tmp_name"],$target_file)
          if(move_uploaded_file($_FILES["BookCover"]["tmp_name"],$target_file)){
              //delete curr img
              if(!empty($_POST["bookpath"])){
                $cur_path = $_POST["bookpath"];
                unlink("$cur_path");
              }
              //echo "The file " . htmlspecialchars(basename($_FILES["BookCover"]["name"])) . "Has Been Re-Uploaded";
              $message[] = "The file " . htmlspecialchars(basename($_FILES["BookCover"]["name"])) . "Has Been Re-Uploaded";
              $_SESSION["msg_status"] = 'g';

              $b_path = $target_file; //update pict Path
              
          }
            else{
              //echo "There was an error.";
              $message[] = "There was an error.";
              $_SESSION["msg_status"] = 'r';
          }

        }
    }
    else{
      //Keep Current Pict Data
      $b_path = $_POST["bookpath"]; // Use current Pic Path

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
//Update New Data
    if($check !== false && $exists == false && $saveOK == 1){
          
          $b_user = $_SESSION["LoggersID"];
          $b_title = $conn->real_escape_string($b_title);
          $sql = "UPDATE books SET BookName = '$b_title', BookAuthor = '$b_author', B_Remark = '$b_remark', B_ISBNCode = '$b_code', B_Publication = '$b_pub', B_Path = '$b_path' Where BookID = $id";
         
          if(mysqli_query($conn, $sql)){
            //Refresh page

            $message[] = "Database Updated";

            if($_SESSION["msg_status"] == 'r'){
              // to check if there is no error in Uploading file
              $_SESSION["msg_status"] = 'r';
            }else{
              $_SESSION["msg_status"] = 'g';
            }
            
          }
          else
          {
            //echo "Error ".mysqli_error($conn);
            $message[] = "Error ".mysqli_error($conn);
            $_SESSION["msg_status"] = 'r';
          }

        }else{
            
          $message[] = "Sorry your file as not uploaded And Data not saved to the DATABASE";
          $_SESSION["msg_status"] = 'y';
          $_SESSION["message"] = $message;
          header('Location: '.$_SERVER['REQUEST_URI']);
      }

        $_SESSION["message"] = $message;
        header('Location: '.$_SERVER['REQUEST_URI']);
  }
}
else {
  $message = array();
  $message[] = "Record not exist";
  $_SESSION["msg_status"] = 'r';
  $_SESSION["message"] = $message;
}



if(isset($_REQUEST["Delete"])){
  $message = array();
  //delete from folder
  if(!empty($_POST["bookpath"])){
    $cur_path = $_POST["bookpath"];
    unlink("$cur_path");
  }

  //Delete from database
  $sql = "DELETE FROM books WHERE BookID = $id";
         
  if(mysqli_query($conn, $sql)){

    $message[] = "succesfully Deleted";
    $_SESSION["msg_status"] = 'g';

    header("Location:BookList.php");
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