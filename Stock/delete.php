<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';

 $id = $_GET['id']; 

 $sql = "delete from stock where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Stock Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting stock'];
    }

    $_SESSION['Message'] = $message;

    header("Location: index.php");
