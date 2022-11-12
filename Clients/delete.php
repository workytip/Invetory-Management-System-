<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';

 $id = $_GET['id']; 

 $sql = "delete from clients where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Client Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Client'];
    }

    $_SESSION['Message'] = $message;

    header("Location: index.php");
