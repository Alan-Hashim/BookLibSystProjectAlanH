<?php

// //enable Output Buffer
// if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
//   ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^
//     PHP_OUTPUT_HANDLER_REMOVABLE);
// } else {
//   ob_start(null, 0, false);
// }


    include "Connect.php";
   $page_title = 'Book List';
   include ('includes/header.html');

   $userid = $_SESSION["LoggersID"];

   
echo "<h1>Book List</h1>";

if(isset($_REQUEST["Search"])){

  $find = $_REQUEST["txtsearch"];

  $sql = "SELECT * FROM books WHERE BookName LIKE '%$find%'";

  $result = mysqli_query($conn, $sql);
}else{
  $sql = "SELECT * FROM books";
  $result = mysqli_query($conn, $sql);
}

if(isset($_REQUEST["show_null_loc"])){

  $sql = "SELECT * FROM books WHERE loc_id IS NULL";

  $result = mysqli_query($conn, $sql);
}

  $bulk_visible = "visible";
   $visibility = "hidden";

   if(isset($_REQUEST["bulk_delete"])){
    $visibility = "visible";
    $bulk_visible = "hidden";
  }

  if(isset($_REQUEST["cancel_bulk_delete"])){
    $visibility = "hidden";
    $bulk_visible = "visible";
  }

  if(isset($_REQUEST["btn_add_rental"])){
    header("Location:AddBook.php");
  }

  //BTN DELETE ALL SELECTED
  if(isset($_REQUEST["delete_items"])){

    $message = array();
    $total_deleted = 0;

    if(!empty($_REQUEST['cbx_delete'])){
      foreach($_REQUEST['cbx_delete'] as $selected){
        //echo $selected;
        $total_deleted++;

        $sql = "SELECT * FROM books WHERE BookID = $selected";

        $sql1 = "DELETE FROM books WHERE BookID = $selected";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)){
            if($row["B_Path"] !== ""){
              $cur_path = $row["B_Path"];
              unlink("$cur_path");
            }
          }
        }
        if(mysqli_query($conn, $sql1)){
          
          $message[0] = "succesfully deleting ".$total_deleted." item";
          $_SESSION["msg_status"] = 'g';

          //Delete picture
        }
        else
        {
          //echo "Error ".mysqli_error($conn);
          $message[0] = "Delete failed. Error : ".mysqli_error($conn);
          $_SESSION["msg_status"] = 'r';
        }
        $_SESSION["message"] = $message;
      header("Location:BookList.php");
      }
      
    }
    
  }

  $role = $_SESSION["role_id"];
  if($role <= 2){
    $hidden_class = "visible";
  }else{
    $hidden_class = "hidden";
  }

  ?>
  
  <?php
echo "<form action='BookList.php' method='post'>".
    
    "<br />".
    "<div class='row'>".
      "<div class='search-property column-10 float-right $hidden_class'>".
        "<input type='submit' class='btn btn-green-fill' id='show_null_loc' name='show_null_loc' value='Unupdated location book'>".
        "<input type='submit' class='btn btn-blue-fill float-right' id='btn_add_rental' name='btn_add_rental' value=' +  Add Book'>".
      "</div>".
    "</div>".
    "<br />".
    "<div class='row'>".
        "<div class='search-property column-1 float-left $hidden_class'>".
          "<input type='submit' class='btn btn-yellow $visibility' id='cancel_bulk_delete' name='cancel_bulk_delete' value='Cancel'>".
        "</div>".
        "<div class='search-property column-2 float-left $hidden_class'>".
          "<input type='submit' class='btn btn-default $bulk_visible' id='bulk_delete' name='bulk_delete' value='Bulk Delete'>".
          "<input type='submit' class='btn btn-red $visibility' id='delete_items' name='delete_items' value='Delete Item'>".
        "</div>".
        "<div class='search-property column-1 float-right'>".
          "&nbsp;<input type='submit' class='btn btn-default search-btn' value='Search' name='Search' id='Search'/>".
        "</div>".
        "<div class='column-3 float-right'>".
          "<input type='text' class='textbox_form' name='txtsearch' id='txtsearch' placeholder='Search by name'/>".
        "</div>".
      "</div>";
    echo "<table class='tbl_default'>";
      echo "<tr>";
        echo "<th class='$visibility'>";
          echo "Delete";
        echo "</th>";
        echo "<th>";
          echo "ID";
        echo "</th>";
        echo "<th>";
          echo "Title";
        echo "</th>";
        echo "<th>";
          echo "ISBN Code";
        echo "</th>";
        echo "<th>";
          echo "Date Added";
        echo "</th>";
        echo "<th>";
          echo "Action";
        echo "</th>";
      echo "</tr>";

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result))
        {

          $active = '';
          if($row["isViewed"] == 0){
            $active = 'active-row';
          }

          $res_book = '';
          if($row["status"] == "Reserved"){
            $res_book = 'book_reserved';
          }

          $b_id = $row["BookID"];
          
          echo "<tr class='".$active." ".$res_book."'>";
            echo "<td class='$visibility'>";
              echo "<label class='container'><input type='checkbox' class='checkbox' name='cbx_delete[]' value='".$b_id."'/><span class='checkmark'><h5>&check;</h5></span></label>";
            echo "</td>";
            echo "<td>";
              echo $row["BookID"];
            echo "</td>";
            echo "<td>";
              echo $row["BookName"];;
            echo "</td>";
            echo "<td>";
              echo $row["B_ISBNCode"];;
            echo "</td>";
            echo "<td>";
              echo $row["B_Date"];
            echo "</td>";
            echo "<td>";
              echo "<a class='links' href='BookView.php?id=".$row['BookID']."'><img src='includes/Button/view_button_blue.png' height='25px' width='40px'></a>";
              //Check if it already viewed
              if($row["isViewed"] == 0){
                echo "<span class='dot noti-dot'>&nbsp;</span>";
              }
            echo "</td>";
          echo "</tr>";
            
        }
        
      }else{
        echo "<tr><td colspan='5' style='text-align:center;'>No Data Found</td></tr>";
      }
      echo "</table>";
      echo "</form>";

      
      mysqli_close($conn);
    ?>  