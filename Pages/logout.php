<?php
session_start();

session_unset(); //Kosongkan
session_destroy(); //Buang all session

header("Location:Login.html");

?>