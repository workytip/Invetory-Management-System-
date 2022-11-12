<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';

 $id = $_GET['id']; 

 $sql = "delete from vendors where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'vendor Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting vendor'];
    }

    $_SESSION['Message'] = $message;

    header("Location: index.php");
